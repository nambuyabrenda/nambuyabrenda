<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'yujo_reservations');
define('DB_USER', 'root');
define('DB_PASS', '');

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Connect to database
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle status updates
if (isset($_POST['action']) && isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];
    $action = $_POST['action'];
    
    if ($action === 'confirm') {
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'confirmed' WHERE id = ?");
        $stmt->execute([$reservation_id]);
        $_SESSION['message'] = 'Reservation confirmed successfully';
    } elseif ($action === 'cancel') {
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'cancelled' WHERE id = ?");
        $stmt->execute([$reservation_id]);
        $_SESSION['message'] = 'Reservation cancelled';
    } elseif ($action === 'complete') {
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'completed' WHERE id = ?");
        $stmt->execute([$reservation_id]);
        $_SESSION['message'] = 'Reservation marked as completed';
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
        $stmt->execute([$reservation_id]);
        $_SESSION['message'] = 'Reservation deleted';
    }
    
    header('Location: manage-reservations.php');
    exit;
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// Filtering
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';

$query = "SELECT * FROM reservations WHERE 1=1";
$count_query = "SELECT COUNT(*) FROM reservations WHERE 1=1";
$params = [];

if ($status_filter && $status_filter !== 'all') {
    $query .= " AND status = :status";
    $count_query .= " AND status = :status";
    $params[':status'] = $status_filter;
}

if ($date_filter) {
    $query .= " AND reservation_date = :date";
    $count_query .= " AND reservation_date = :date";
    $params[':date'] = $date_filter;
}

// Get total count for pagination
$stmt = $pdo->prepare($count_query);
$stmt->execute($params);
$total_reservations = $stmt->fetchColumn();
$total_pages = ceil($total_reservations / $limit);

// Get reservations for current page
$query .= " ORDER BY reservation_date DESC, reservation_time DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get status counts for filter badges
$status_counts = [];
$statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
foreach ($statuses as $status) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE status = ?");
    $stmt->execute([$status]);
    $status_counts[$status] = $stmt->fetchColumn();
}

$admin_name = $_SESSION['admin_name'] ?? 'Administrator';
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations - Yujo Izakaya Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #8B0000 0%, #660000 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 2rem;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .nav-item {
            padding: 0.8rem 1.5rem;
            margin: 0.2rem 0;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-item i {
            width: 24px;
        }

        .nav-item a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            flex: 1;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.1);
        }

        .nav-item.active {
            background: rgba(255,255,255,0.2);
            border-left: 4px solid #D4AF37;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .page-title h1 {
            font-size: 1.8rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #8B0000;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .logout-btn {
            padding: 0.5rem 1rem;
            background: #f0f0f0;
            border: none;
            border-radius: 6px;
            color: #666;
            cursor: pointer;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #8B0000;
            color: white;
        }

        /* Alert Message */
        .alert {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert .close {
            cursor: pointer;
            font-size: 1.2rem;
        }

        /* Filters */
        .filters-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .filter-form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #eaeaea;
            border-radius: 6px;
            font-family: inherit;
        }

        .filter-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-filter {
            padding: 0.8rem 1.5rem;
            background: #8B0000;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-reset {
            padding: 0.8rem 1.5rem;
            background: #f0f0f0;
            color: #666;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        /* Status Tabs */
        .status-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .status-tab {
            padding: 0.5rem 1.5rem;
            background: white;
            border: 2px solid #eaeaea;
            border-radius: 30px;
            color: #666;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .status-tab:hover {
            border-color: #8B0000;
        }

        .status-tab.active {
            background: #8B0000;
            border-color: #8B0000;
            color: white;
        }

        .status-tab .count {
            background: rgba(0,0,0,0.1);
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            margin-left: 0.5rem;
            font-size: 0.8rem;
        }

        .status-tab.active .count {
            background: rgba(255,255,255,0.2);
        }

        /* Reservations Table */
        .reservations-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .add-btn {
            padding: 0.8rem 1.5rem;
            background: #8B0000;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 1rem;
            background: #f8f9fa;
            color: #555;
            font-weight: 600;
            font-size: 0.9rem;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .status-completed {
            background: #cce5ff;
            color: #004085;
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            color: white;
        }

        .btn-confirm {
            background: #28a745;
        }

        .btn-cancel {
            background: #dc3545;
        }

        .btn-complete {
            background: #17a2b8;
        }

        .btn-delete {
            background: #6c757d;
        }

        .btn-view {
            background: #007bff;
        }

        .btn-edit {
            background: #ffc107;
            color: #333;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .page-link {
            padding: 0.5rem 1rem;
            background: white;
            border: 2px solid #eaeaea;
            border-radius: 6px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
        }

        .page-link:hover,
        .page-link.active {
            background: #8B0000;
            border-color: #8B0000;
            color: white;
        }

        /* Export Buttons */
        .export-btns {
            display: flex;
            gap: 0.5rem;
        }

        .export-btn {
            padding: 0.5rem 1rem;
            background: #f0f0f0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            text-decoration: none;
        }

        .export-btn:hover {
            background: #8B0000;
            color: white;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
            }
            .sidebar-header h2 {
                display: none;
            }
            .nav-item span {
                display: none;
            }
            .main-content {
                margin-left: 80px;
            }
        }

        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
            }
            .filter-group {
                width: 100%;
            }
            .status-tabs {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Yujo Admin</h2>
            </div>
            
            <div class="nav-item">
                <i class="fas fa-dashboard"></i>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <div class="nav-item active">
                <i class="fas fa-calendar-check"></i>
                <a href="manage-reservations.php">Reservations</a>
            </div>
            <div class="nav-item">
                <i class="fas fa-utensils"></i>
                <a href="manage-menu.php">Menu</a>
            </div>
            <div class="nav-item">
                <i class="fas fa-wine-bottle"></i>
                <a href="manage-drinks.php">Drinks</a>
            </div>
            <div class="nav-item">
                <i class="fas fa-users"></i>
                <a href="manage-staff.php">Staff</a>
            </div>
            <div class="nav-item">
                <i class="fas fa-cog"></i>
                <a href="settings.php">Settings</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>Manage Reservations</h1>
                </div>
                <div class="user-menu">
                    <span><?php echo htmlspecialchars($admin_name); ?></span>
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($admin_name, 0, 1)); ?>
                    </div>
                    <a href="logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>

            <!-- Alert Message -->
            <?php if ($message): ?>
            <div class="alert" id="alertMessage">
                <?php echo htmlspecialchars($message); ?>
                <span class="close" onclick="this.parentElement.style.display='none'">&times;</span>
            </div>
            <?php endif; ?>

            <!-- Filters -->
            <div class="filters-section">
                <form method="GET" class="filter-form">
                    <div class="filter-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Status</option>
                            <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="confirmed" <?php echo $status_filter === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                            <option value="cancelled" <?php echo $status_filter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>Date</label>
                        <input type="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>">
                    </div>
                    
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="manage-reservations.php" class="btn-reset">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Status Tabs -->
            <div class="status-tabs">
                <a href="?status=all" class="status-tab <?php echo $status_filter === 'all' || !$status_filter ? 'active' : ''; ?>">
                    All <span class="count"><?php echo $total_reservations; ?></span>
                </a>
                <a href="?status=pending" class="status-tab <?php echo $status_filter === 'pending' ? 'active' : ''; ?>">
                    Pending <span class="count"><?php echo $status_counts['pending']; ?></span>
                </a>
                <a href="?status=confirmed" class="status-tab <?php echo $status_filter === 'confirmed' ? 'active' : ''; ?>">
                    Confirmed <span class="count"><?php echo $status_counts['confirmed']; ?></span>
                </a>
                <a href="?status=completed" class="status-tab <?php echo $status_filter === 'completed' ? 'active' : ''; ?>">
                    Completed <span class="count"><?php echo $status_counts['completed']; ?></span>
                </a>
                <a href="?status=cancelled" class="status-tab <?php echo $status_filter === 'cancelled' ? 'active' : ''; ?>">
                    Cancelled <span class="count"><?php echo $status_counts['cancelled']; ?></span>
                </a>
            </div>

            <!-- Reservations Table -->
            <div class="reservations-section">
                <div class="section-header">
                    <h2>Reservations List</h2>
                    <div style="display: flex; gap: 1rem;">
                        <div class="export-btns">
                            <a href="export-csv.php" class="export-btn">
                                <i class="fas fa-file-csv"></i> CSV
                            </a>
                            <a href="export-pdf.php" class="export-btn">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </div>
                        <a href="add-reservation.php" class="add-btn">
                            <i class="fas fa-plus"></i> New Reservation
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Guests</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reservations)): ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 3rem; color: #999;">
                                    <i class="fas fa-calendar-times" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                                    No reservations found
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($reservations as $res): ?>
                                <tr>
                                    <td>#<?php echo $res['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($res['name']); ?></strong><br>
                                        <small style="color: #999;"><?php echo htmlspecialchars($res['email']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($res['phone']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($res['reservation_date'])); ?></td>
                                    <td><?php echo date('g:i A', strtotime($res['reservation_time'])); ?></td>
                                    <td><?php echo $res['guests']; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $res['status']; ?>">
                                            <?php echo ucfirst($res['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d', strtotime($res['created_at'])); ?></td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="view-reservation.php?id=<?php echo $res['id']; ?>" class="action-btn btn-view" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="edit-reservation.php?id=<?php echo $res['id']; ?>" class="action-btn btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <?php if ($res['status'] === 'pending'): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="reservation_id" value="<?php echo $res['id']; ?>">
                                                <input type="hidden" name="action" value="confirm">
                                                <button type="submit" class="action-btn btn-confirm" title="Confirm" onclick="return confirm('Confirm this reservation?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if ($res['status'] === 'confirmed'): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="reservation_id" value="<?php echo $res['id']; ?>">
                                                <input type="hidden" name="action" value="complete">
                                                <button type="submit" class="action-btn btn-complete" title="Mark Complete" onclick="return confirm('Mark this reservation as completed?')">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if ($res['status'] !== 'cancelled' && $res['status'] !== 'completed'): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="reservation_id" value="<?php echo $res['id']; ?>">
                                                <input type="hidden" name="action" value="cancel">
                                                <button type="submit" class="action-btn btn-cancel" title="Cancel" onclick="return confirm('Cancel this reservation?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="reservation_id" value="<?php echo $res['id']; ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" class="action-btn btn-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this reservation? This cannot be undone.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <?php if (!empty($res['special_requests'])): ?>
                                        <small style="color: #8B0000; display: block; margin-top: 0.5rem;">
                                            <i class="fas fa-comment"></i> <?php echo htmlspecialchars(substr($res['special_requests'], 0, 30)) . '...'; ?>
                                        </small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page-1; ?>&status=<?php echo $status_filter; ?>&date=<?php echo $date_filter; ?>" class="page-link">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&status=<?php echo $status_filter; ?>&date=<?php echo $date_filter; ?>" 
                       class="page-link <?php echo $i === $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page+1; ?>&status=<?php echo $status_filter; ?>&date=<?php echo $date_filter; ?>" class="page-link">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alert after 3 seconds
        setTimeout(() => {
            const alert = document.getElementById('alertMessage');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>
</body>
</html>