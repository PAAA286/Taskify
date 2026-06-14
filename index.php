<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Taskify — Task Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <style>
        /* ===== Variables ===== */
        :root {
            --bg:        #f0f2f5;
            --surface:   #ffffff;
            --border:    #e2e6ea;
            --border2:   #d0d5dd;
            --text:      #111827;
            --muted:     #6b7280;
            --accent:    #4f46e5;
            --accent-h:  #4338ca;
            --accent-bg: #eef2ff;
            --green:     #16a34a;
            --green-bg:  #f0fdf4;
            --yellow:    #d97706;
            --yellow-bg: #fffbeb;
            --red:       #dc2626;
            --red-bg:    #fef2f2;
            --blue:      #2563eb;
            --blue-bg:   #eff6ff;
            --radius:    10px;
            --shadow:    0 1px 4px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
        }

        /* ===== Reset ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ===== Top Nav ===== */
        nav {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: -0.02em;
        }
        .nav-brand .icon {
            width: 32px; height: 32px;
            background: var(--accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-size: 1rem;
        }
        .nav-stats {
            display: flex;
            gap: 1.5rem;
            font-size: 0.8rem;
            color: var(--muted);
        }
        .nav-stats span strong {
            color: var(--text);
            font-weight: 600;
        }

        /* ===== Layout ===== */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* ===== Page Header ===== */
        .page-header {
            margin-bottom: 1.8rem;
        }
        .page-header h1 {
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--text);
        }
        .page-header p {
            color: var(--muted);
            font-size: 0.88rem;
            margin-top: 0.25rem;
        }

        /* ===== Add Task Card ===== */
        .add-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .add-card h2 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .form-row.three { grid-template-columns: 1fr 1fr 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
        .form-group.full { grid-column: 1 / -1; }
        label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        input[type="text"],
        input[type="date"],
        textarea,
        select {
            background: #f9fafb;
            border: 1px solid var(--border2);
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            font-family: 'Sora', sans-serif;
            font-size: 0.88rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
        }
        input:focus, textarea:focus, select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
            background: white;
        }
        textarea { resize: vertical; min-height: 70px; }

        /* ===== Buttons ===== */
        .btn {
            padding: 0.65rem 1.4rem;
            border-radius: 8px;
            border: none;
            font-family: 'Sora', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-primary {
            background: var(--accent);
            color: white;
        }
        .btn-primary:hover { background: var(--accent-h); box-shadow: 0 4px 12px rgba(79,70,229,0.3); }
        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border2);
        }
        .btn-ghost:hover { border-color: var(--accent); color: var(--accent); }
        .btn-danger {
            background: var(--red-bg);
            color: var(--red);
            border: 1px solid #fecaca;
        }
        .btn-danger:hover { background: var(--red); color: white; }
        .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.78rem; }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.2rem;
        }

        /* ===== Toolbar ===== */
        .toolbar {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            margin-bottom: 1.2rem;
            flex-wrap: wrap;
        }
        .search-wrap {
            flex: 1;
            min-width: 200px;
            position: relative;
        }
        .search-wrap input {
            padding-left: 2.4rem;
        }
        .search-icon {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.9rem;
            pointer-events: none;
        }
        .filter-group {
            display: flex;
            gap: 0.5rem;
        }
        .filter-btn {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            border: 1px solid var(--border2);
            background: white;
            font-family: 'Sora', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.15s;
        }
        .filter-btn.active, .filter-btn:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        /* ===== Task List ===== */
        #task-list { display: flex; flex-direction: column; gap: 0.75rem; }

        .task-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.2rem 1.4rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: box-shadow 0.2s, transform 0.15s;
            animation: slideIn 0.3s ease both;
        }
        .task-card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }
        .task-card.completed { opacity: 0.6; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Priority stripe */
        .task-card { border-left: 4px solid var(--border); }
        .task-card.priority-High   { border-left-color: var(--red); }
        .task-card.priority-Medium { border-left-color: var(--yellow); }
        .task-card.priority-Low    { border-left-color: var(--green); }

        .task-check {
            width: 20px; height: 20px;
            border-radius: 50%;
            border: 2px solid var(--border2);
            cursor: pointer;
            flex-shrink: 0;
            margin-top: 2px;
            transition: all 0.2s;
            display: flex; align-items: center; justify-content: center;
            background: white;
        }
        .task-check:hover { border-color: var(--accent); }
        .task-check.checked { background: var(--green); border-color: var(--green); color: white; }

        .task-body { flex: 1; }
        .task-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text);
            margin-bottom: 0.3rem;
        }
        .task-title.done { text-decoration: line-through; color: var(--muted); }
        .task-desc {
            font-size: 0.82rem;
            color: var(--muted);
            margin-bottom: 0.6rem;
            line-height: 1.5;
        }
        .task-meta {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            font-family: 'DM Mono', monospace;
        }
        .badge-high     { background: var(--red-bg);    color: var(--red); }
        .badge-medium   { background: var(--yellow-bg); color: var(--yellow); }
        .badge-low      { background: var(--green-bg);  color: var(--green); }
        .badge-pending  { background: #f3f4f6;          color: var(--muted); }
        .badge-progress { background: var(--blue-bg);   color: var(--blue); }
        .badge-done     { background: var(--green-bg);  color: var(--green); }
        .badge-date     { background: var(--accent-bg); color: var(--accent); }

        .task-actions {
            display: flex;
            gap: 0.4rem;
            flex-shrink: 0;
        }

        /* ===== Empty State ===== */
        .empty {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--muted);
        }
        .empty .empty-icon { font-size: 3rem; margin-bottom: 1rem; }
        .empty h3 { font-size: 1rem; color: var(--text); margin-bottom: 0.4rem; }
        .empty p  { font-size: 0.85rem; }

        /* ===== Modal ===== */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.35);
            backdrop-filter: blur(2px);
            z-index: 200;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: white;
            border-radius: 14px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            animation: modalIn 0.25s ease;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)    translateY(0); }
        }
        .modal h2 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.4rem;
            color: var(--text);
        }

        /* ===== Toast ===== */
        #toast {
            position: fixed;
            bottom: 2rem; right: 2rem;
            background: var(--text);
            color: white;
            padding: 0.75rem 1.4rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            z-index: 300;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        #toast.show { transform: translateY(0); opacity: 1; }
        #toast.success { background: var(--green); }
        #toast.error   { background: var(--red); }

        /* ===== Responsive ===== */
        @media (max-width: 600px) {
            .form-row, .form-row.three { grid-template-columns: 1fr; }
            .nav-stats { display: none; }
            .filter-group { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

<!-- ===== NAV ===== -->
<nav>
    <div class="nav-brand">
        <div class="icon">✓</div>
        Taskify
    </div>
    <div class="nav-stats">
        <span><strong id="stat-total">0</strong> Total</span>
        <span><strong id="stat-pending">0</strong> Pending</span>
        <span><strong id="stat-done">0</strong> Done</span>
    </div>
</nav>

<!-- ===== MAIN ===== -->
<div class="container">

    <div class="page-header">
        <h1>My Tasks</h1>
        <p>Stay on top of your day — add, track, and complete tasks.</p>
    </div>

    <!-- Add Task Form -->
    <div class="add-card">
        <h2>➕ Add New Task</h2>
        <div class="form-row">
            <div class="form-group full">
                <label for="title">Task Title *</label>
                <input type="text" id="title" placeholder="What needs to be done?" />
            </div>
        </div>
        <div class="form-row" style="margin-top:1rem;">
            <div class="form-group full">
                <label for="description">Description</label>
                <textarea id="description" placeholder="Add more details (optional)..."></textarea>
            </div>
        </div>
        <div class="form-row three" style="margin-top:1rem;">
            <div class="form-group">
                <label for="priority">Priority *</label>
                <select id="priority">
                    <option value="">Select priority</option>
                    <option value="High">🔴 High</option>
                    <option value="Medium">🟡 Medium</option>
                    <option value="Low">🟢 Low</option>
                </select>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" id="due_date" />
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-ghost" onclick="clearForm()">Clear</button>
            <button class="btn btn-primary" onclick="addTask()">➕ Add Task</button>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="search-wrap">
            <span class="search-icon">🔍</span>
            <input type="text" id="search" placeholder="Search tasks..." oninput="loadTasks()" />
        </div>
        <div class="filter-group" id="status-filters">
            <button class="filter-btn active" onclick="setFilter('All', this)">All</button>
            <button class="filter-btn" onclick="setFilter('Pending', this)">Pending</button>
            <button class="filter-btn" onclick="setFilter('In Progress', this)">In Progress</button>
            <button class="filter-btn" onclick="setFilter('Completed', this)">Completed</button>
        </div>
        <select id="priority-filter" onchange="loadTasks()" style="padding:0.5rem 0.8rem; border-radius:8px; border:1px solid var(--border2); font-family:'Sora',sans-serif; font-size:0.8rem; color:var(--muted); background:white; cursor:pointer;">
            <option value="All">All Priorities</option>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
        </select>
    </div>

    <!-- Task List -->
    <div id="task-list">
        <div class="empty">
            <div class="empty-icon">📋</div>
            <h3>Loading tasks...</h3>
        </div>
    </div>
</div>

<!-- ===== EDIT MODAL ===== -->
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <h2>✏️ Edit Task</h2>
        <input type="hidden" id="edit-id" />
        <div class="form-group" style="margin-bottom:1rem;">
            <label for="edit-title">Task Title *</label>
            <input type="text" id="edit-title" />
        </div>
        <div class="form-group" style="margin-bottom:1rem;">
            <label for="edit-desc">Description</label>
            <textarea id="edit-desc"></textarea>
        </div>
        <div class="form-row" style="margin-bottom:1rem;">
            <div class="form-group">
                <label for="edit-priority">Priority *</label>
                <select id="edit-priority">
                    <option value="High">🔴 High</option>
                    <option value="Medium">🟡 Medium</option>
                    <option value="Low">🟢 Low</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edit-status">Status *</label>
                <select id="edit-status">
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:1.5rem;">
            <label for="edit-due">Due Date</label>
            <input type="date" id="edit-due" />
        </div>
        <div class="form-actions">
            <button class="btn btn-ghost" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary" onclick="updateTask()">Save Changes</button>
        </div>
    </div>
</div>

<!-- ===== TOAST ===== -->
<div id="toast"></div>

<!-- ===== JAVASCRIPT ===== -->
<script>
    const API = 'api.php';
    let currentFilter = 'All';

    // ---- Toast notification ----
    function showToast(msg, type = 'success') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className = `show ${type}`;
        setTimeout(() => t.className = '', 3000);
    }

    // ---- Set filter ----
    function setFilter(filter, btn) {
        currentFilter = filter;
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        loadTasks();
    }

    // ---- Load tasks ----
    async function loadTasks() {
        const search   = document.getElementById('search').value;
        const priority = document.getElementById('priority-filter').value;
        const params   = new URLSearchParams({
            action: 'get_tasks',
            status: currentFilter,
            priority,
            search
        });

        const res  = await fetch(`${API}?${params}`);
        const data = await res.json();

        if (data.success) {
            renderTasks(data.data);
            updateStats(data.data);
        }
    }

    // ---- Render task cards ----
    function renderTasks(tasks) {
        const list = document.getElementById('task-list');

        if (!tasks.length) {
            list.innerHTML = `
                <div class="empty">
                    <div class="empty-icon">🎉</div>
                    <h3>No tasks found</h3>
                    <p>Add a new task above to get started.</p>
                </div>`;
            return;
        }

        list.innerHTML = tasks.map(t => {
            const isDone    = t.status === 'Completed';
            const dueBadge  = t.due_date
                ? `<span class="badge badge-date">📅 ${formatDate(t.due_date)}</span>` : '';
            const statusMap = { 'Pending': 'badge-pending', 'In Progress': 'badge-progress', 'Completed': 'badge-done' };
            const priorityMap = { High: 'badge-high', Medium: 'badge-medium', Low: 'badge-low' };

            return `
            <div class="task-card priority-${t.priority} ${isDone ? 'completed' : ''}" id="task-${t.id}">
                <div class="task-check ${isDone ? 'checked' : ''}" onclick="toggleStatus(${t.id}, '${t.status}')">
                    ${isDone ? '✓' : ''}
                </div>
                <div class="task-body">
                    <div class="task-title ${isDone ? 'done' : ''}">${t.title}</div>
                    ${t.description ? `<div class="task-desc">${t.description}</div>` : ''}
                    <div class="task-meta">
                        <span class="badge ${priorityMap[t.priority]}">${t.priority}</span>
                        <span class="badge ${statusMap[t.status]}">${t.status}</span>
                        ${dueBadge}
                    </div>
                </div>
                <div class="task-actions">
                    <button class="btn btn-ghost btn-sm" onclick="openEdit(${JSON.stringify(t).replace(/"/g, '&quot;')})">✏️</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteTask(${t.id})">🗑️</button>
                </div>
            </div>`;
        }).join('');
    }

    // ---- Update nav stats ----
    function updateStats(tasks) {
        document.getElementById('stat-total').textContent   = tasks.length;
        document.getElementById('stat-pending').textContent = tasks.filter(t => t.status === 'Pending').length;
        document.getElementById('stat-done').textContent    = tasks.filter(t => t.status === 'Completed').length;
    }

    // ---- Format date ----
    function formatDate(d) {
        if (!d) return '';
        const date = new Date(d + 'T00:00:00');
        return date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
    }

    // ---- Add task ----
    async function addTask() {
        const title    = document.getElementById('title').value.trim();
        const desc     = document.getElementById('description').value.trim();
        const priority = document.getElementById('priority').value;
        const due_date = document.getElementById('due_date').value;

        if (!title)    return showToast('Task title is required.', 'error');
        if (!priority) return showToast('Please select a priority.', 'error');

        const res  = await fetch(`${API}?action=add_task`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ title, description: desc, priority, due_date })
        });
        const data = await res.json();

        if (data.success) {
            showToast('Task added! ✓');
            clearForm();
            loadTasks();
        } else {
            showToast(data.message, 'error');
        }
    }

    // ---- Clear form ----
    function clearForm() {
        ['title','description','priority','due_date'].forEach(id => {
            document.getElementById(id).value = '';
        });
    }

    // ---- Toggle status (quick complete) ----
    async function toggleStatus(id, current) {
        const next = current === 'Completed' ? 'Pending' : 'Completed';
        const res  = await fetch(`${API}?action=update_status`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, status: next })
        });
        const data = await res.json();
        if (data.success) loadTasks();
    }

    // ---- Open edit modal ----
    function openEdit(task) {
        document.getElementById('edit-id').value       = task.id;
        document.getElementById('edit-title').value    = task.title;
        document.getElementById('edit-desc').value     = task.description || '';
        document.getElementById('edit-priority').value = task.priority;
        document.getElementById('edit-status').value   = task.status;
        document.getElementById('edit-due').value      = task.due_date || '';
        document.getElementById('editModal').classList.add('open');
    }

    function closeModal() {
        document.getElementById('editModal').classList.remove('open');
    }

    // ---- Update task ----
    async function updateTask() {
        const id          = document.getElementById('edit-id').value;
        const title       = document.getElementById('edit-title').value.trim();
        const description = document.getElementById('edit-desc').value.trim();
        const priority    = document.getElementById('edit-priority').value;
        const status      = document.getElementById('edit-status').value;
        const due_date    = document.getElementById('edit-due').value;

        if (!title) return showToast('Task title is required.', 'error');

        const res  = await fetch(`${API}?action=update_task`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, title, description, priority, status, due_date })
        });
        const data = await res.json();

        if (data.success) {
            showToast('Task updated! ✓');
            closeModal();
            loadTasks();
        } else {
            showToast(data.message, 'error');
        }
    }

    // ---- Delete task ----
    async function deleteTask(id) {
        if (!confirm('Delete this task?')) return;
        const res  = await fetch(`${API}?action=delete_task`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const data = await res.json();
        if (data.success) {
            showToast('Task deleted.', 'error');
            loadTasks();
        }
    }

    // ---- Close modal on overlay click ----
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // ---- Init ----
    loadTasks();
</script>
</body>
</html>
