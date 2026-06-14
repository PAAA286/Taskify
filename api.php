<?php
// =============================================
// Taskify — API (CRUD Backend)
// =============================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

// ---- Helper: send JSON response ----
function respond(bool $success, string $message, $data = null): void {
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
    exit;
}

// ---- Helper: sanitize input ----
function clean(string $val): string {
    return htmlspecialchars(strip_tags(trim($val)));
}

// =============================================
// READ — Get all tasks
// =============================================
if ($method === 'GET' && $action === 'get_tasks') {
    $filter   = $_GET['status']   ?? 'All';
    $priority = $_GET['priority'] ?? 'All';
    $search   = $_GET['search']   ?? '';

    $sql    = "SELECT * FROM tasks WHERE 1=1";
    $params = [];
    $types  = '';

    if ($filter !== 'All') {
        $sql    .= " AND status = ?";
        $params[] = $filter;
        $types   .= 's';
    }
    if ($priority !== 'All') {
        $sql    .= " AND priority = ?";
        $params[] = $priority;
        $types   .= 's';
    }
    if (!empty($search)) {
        $sql    .= " AND (title LIKE ? OR description LIKE ?)";
        $like    = "%$search%";
        $params[] = $like;
        $params[] = $like;
        $types   .= 'ss';
    }

    $sql .= " ORDER BY FIELD(priority,'High','Medium','Low'), created_at DESC";

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $tasks  = $result->fetch_all(MYSQLI_ASSOC);
    respond(true, 'Tasks fetched.', $tasks);
}

// =============================================
// CREATE — Add new task
// =============================================
if ($method === 'POST' && $action === 'add_task') {
    $data = json_decode(file_get_contents('php://input'), true);

    $title       = clean($data['title']       ?? '');
    $description = clean($data['description'] ?? '');
    $priority    = clean($data['priority']    ?? '');
    $due_date    = clean($data['due_date']    ?? '');

    // Validation
    $errors = [];
    if (empty($title))    $errors[] = 'Task title is required.';
    if (empty($priority)) $errors[] = 'Priority is required.';
    if (!in_array($priority, ['Low', 'Medium', 'High'])) $errors[] = 'Invalid priority value.';
    if (!empty($due_date) && !strtotime($due_date)) $errors[] = 'Invalid due date.';

    if (!empty($errors)) respond(false, implode(' ', $errors));

    $due_date_val = !empty($due_date) ? $due_date : null;

    $stmt = $conn->prepare(
        "INSERT INTO tasks (title, description, priority, due_date) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param('ssss', $title, $description, $priority, $due_date_val);

    if ($stmt->execute()) {
        respond(true, 'Task added successfully.', ['id' => $conn->insert_id]);
    } else {
        respond(false, 'Failed to add task.');
    }
}

// =============================================
// UPDATE — Edit task
// =============================================
if ($method === 'PUT' && $action === 'update_task') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id          = (int)($data['id']          ?? 0);
    $title       = clean($data['title']       ?? '');
    $description = clean($data['description'] ?? '');
    $priority    = clean($data['priority']    ?? '');
    $status      = clean($data['status']      ?? '');
    $due_date    = clean($data['due_date']    ?? '');

    // Validation
    $errors = [];
    if (!$id)             $errors[] = 'Invalid task ID.';
    if (empty($title))    $errors[] = 'Task title is required.';
    if (empty($priority)) $errors[] = 'Priority is required.';
    if (!in_array($priority, ['Low', 'Medium', 'High']))           $errors[] = 'Invalid priority.';
    if (!in_array($status, ['Pending', 'In Progress', 'Completed'])) $errors[] = 'Invalid status.';

    if (!empty($errors)) respond(false, implode(' ', $errors));

    $due_date_val = !empty($due_date) ? $due_date : null;

    $stmt = $conn->prepare(
        "UPDATE tasks SET title=?, description=?, priority=?, status=?, due_date=? WHERE id=?"
    );
    $stmt->bind_param('sssssi', $title, $description, $priority, $status, $due_date_val, $id);

    if ($stmt->execute()) {
        respond(true, 'Task updated successfully.');
    } else {
        respond(false, 'Failed to update task.');
    }
}

// =============================================
// UPDATE STATUS — Quick toggle
// =============================================
if ($method === 'PUT' && $action === 'update_status') {
    $data   = json_decode(file_get_contents('php://input'), true);
    $id     = (int)($data['id']     ?? 0);
    $status = clean($data['status'] ?? '');

    if (!$id || !in_array($status, ['Pending', 'In Progress', 'Completed'])) {
        respond(false, 'Invalid data.');
    }

    $stmt = $conn->prepare("UPDATE tasks SET status=? WHERE id=?");
    $stmt->bind_param('si', $status, $id);

    if ($stmt->execute()) {
        respond(true, 'Status updated.');
    } else {
        respond(false, 'Failed to update status.');
    }
}

// =============================================
// DELETE — Remove task
// =============================================
if ($method === 'DELETE' && $action === 'delete_task') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id   = (int)($data['id'] ?? 0);

    if (!$id) respond(false, 'Invalid task ID.');

    $stmt = $conn->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        respond(true, 'Task deleted.');
    } else {
        respond(false, 'Failed to delete task.');
    }
}

respond(false, 'Invalid request.');
