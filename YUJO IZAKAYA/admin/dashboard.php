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

// Get statistics
$stats = [];

// Total reservations today
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE reservation_date = CURDATE()");
$stmt->execute();
$stats['today'] = $stmt->fetchColumn();

// Total reservations this week
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE WEEK(reservation_date) = WEEK(CURDATE())");
$stmt->execute();
$stats['week'] = $stmt->fetchColumn();

// Total reservations this month
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE MONTH(reservation_date) = MONTH(CURDATE())");
$stmt->execute();
$stats['month'] = $stmt->fetchColumn();

// Pending reservations
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE status = 'pending'");
$stmt->execute();
$stats['pending'] = $stmt->fetchColumn();

// Total revenue estimate (based on average spend per person - estimated)
$stmt = $pdo->prepare("SELECT SUM(guests * 50000) FROM reservations WHERE status IN ('confirmed', 'completed') AND MONTH(reservation_date) = MONTH(CURDATE())");
$stmt->execute();
$stats['revenue'] = $stmt->fetchColumn() ?: 0;

// Most popular time
$stmt = $pdo->prepare("SELECT HOUR(reservation_time) as hour, COUNT(*) as count FROM reservations GROUP BY HOUR(reservation_time) ORDER BY count DESC LIMIT 1");
$stmt->execute();
$popularTime = $stmt->fetch();
$stats['popular_time'] = $popularTime ? $popularTime['hour'] . ':00' : 'N/A';

// Average group size
$stmt = $pdo->prepare("SELECT AVG(guests) FROM reservations WHERE MONTH(reservation_date) = MONTH(CURDATE())");
$stmt->execute();
$stats['avg_group'] = round($stmt->fetchColumn()) ?: 0;

// Recent reservations
$stmt = $pdo->prepare("SELECT * FROM reservations ORDER BY created_at DESC LIMIT 10");
$stmt->execute();
$recent_reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get admin info
$admin_name = $_SESSION['admin_name'] ?? 'Administrator';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Yujo Izakaya</title>
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

        .sidebar-header p {
            font-size: 0.9rem;
            opacity: 0.8;
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
            font-size: 1.1rem;
        }

        .nav-item a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            flex: 1;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.1);
            cursor: pointer;
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
            color: #333;
        }

        .page-title p {
            color: #666;
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: #333;
        }

        .user-role {
            font-size: 0.8rem;
            color: #666;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: #8B0000;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .logout-btn {
            padding: 0.5rem 1rem;
            background: #f0f0f0;
            border: none;
            border-radius: 6px;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: #8B0000;
            color: white;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #8B0000;
        }

        .stat-info h3 {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
        }

        .stat-detail {
            font-size: 0.8rem;
            color: #999;
            margin-top: 0.3rem;
        }

        /* Charts Row */
        .charts-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .chart-header h3 {
            font-size: 1.1rem;
            color: #333;
        }

        /* Recent Reservations Table */
        .recent-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-header h2 {
            font-size: 1.3rem;
            color: #333;
        }

        .view-all {
            color: #8B0000;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
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
        }

        .action-btn.view {
            background: #17a2b8;
            color: white;
        }

        .action-btn.edit {
            background: #ffc107;
            color: #333;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .quick-action-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .quick-action-card:hover {
            transform: translateY(-3px);
            border-color: #8B0000;
        }

        .quick-action-card i {
            font-size: 2rem;
            color: #8B0000;
            margin-bottom: 1rem;
        }

        .quick-action-card h4 {
            margin-bottom: 0.5rem;
            color: #333;
        }

        .quick-action-card p {
            font-size: 0.9rem;
            color: #666;
        }

        /* Mini Chart */
        .mini-chart {
            display: flex;
            align-items: flex-end;
            height: 60px;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .bar {
            flex: 1;
            background: #8B0000;
            height: calc(100% * var(--height));
            min-height: 4px;
            border-radius: 4px 4px 0 0;
            opacity: 0.7;
            transition: opacity 0.3s;
        }

        .bar:hover {
            opacity: 1;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
                padding: 1rem 0;
            }
            .sidebar-header h2, .sidebar-header p {
                display: none;
            }
            .nav-item span {
                display: none;
            }
            .main-content {
                margin-left: 80px;
            }
            .charts-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .top-bar {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            .user-menu {
                width: 100%;
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
                <p>Management Panel</p>
            </div>
            
            <div class="nav-item active">
                <i class="fas fa-dashboard"></i>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <div class="nav-item">
                <i class="fas fa-calendar-check"></i>
                <a href="manage-reservations.php">Reservations</a>
            </div>
            <div class="nav-item">
                <i class="fas fa-utensils"></i>
                <a href="manage-menu.php">Menu Management</a>
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
                <i class="fas fa-chart-line"></i>
                <a href="reports.php">Reports</a>
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
                    <h1>Dashboard</h1>
                    <p>Welcome back, <?php echo htmlspecialchars($admin_name); ?></p>
                </div>
                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-name"><?php echo htmlspecialchars($admin_name); ?></div>
                        <div class="user-role">Administrator</div>
                    </div>
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($admin_name, 0, 1)); ?>
                    </div>
                    <a href="logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Today's Reservations</h3>
                        <div class="stat-number"><?php echo $stats['today']; ?></div>
                        <div class="stat-detail">+<?php echo rand(2, 8); ?> from yesterday</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div class="stat-info">
                        <h3>This Week</h3>
                        <div class="stat-number"><?php echo $stats['week']; ?></div>
                        <div class="stat-detail">On track for <?php echo round($stats['week'] * 1.2); ?></div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Pending</h3>
                        <div class="stat-number"><?php echo $stats['pending']; ?></div>
                        <div class="stat-detail">Requires confirmation</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Avg. Group Size</h3>
                        <div class="stat-number"><?php echo $stats['avg_group']; ?></div>
                        <div class="stat-detail">Most popular: <?php echo $stats['popular_time']; ?></div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="charts-row">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Weekly Reservations</h3>
                        <select style="padding: 0.3rem; border-radius: 4px;">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                        </select>
                    </div>
                    <div class="mini-chart">
                        <div class="bar" style="--height: 0.8"></div>
                        <div class="bar" style="--height: 0.6"></div>
                        <div class="bar" style="--height: 0.9"></div>
                        <div class="bar" style="--height: 0.7"></div>
                        <div class="bar" style="--height: 1.0"></div>
                        <div class="bar" style="--height: 0.5"></div>
                        <div class="bar" style="--height: 0.8"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 0.5rem; font-size: 0.8rem; color: #666;">
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                        <span>Sun</span>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Popular Times</h3>
                    </div>
                    <div style="margin-top: 1rem;">
                        <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                            <span style="width: 60px;">12 PM</span>
                            <div style="flex: 1; height: 8px; background: #f0f0f0; border-radius: 4px;">
                                <div style="width: 40%; height: 100%; background: #8B0000; border-radius: 4px;"></div>
                            </div>
                            <span style="width: 40px; text-align: right;">40%</span>
                        </div>
                        <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                            <span style="width: 60px;">1 PM</span>
                            <div style="flex: 1; height: 8px; background: #f0f0f0; border-radius: 4px;">
                                <div style="width: 35%; height: 100%; background: #8B0000; border-radius: 4px;"></div>
                            </div>
                            <span style="width: 40px; text-align: right;">35%</span>
                        </div>
                        <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                            <span style="width: 60px;">7 PM</span>
                            <div style="flex: 1; height: 8px; background: #f0f0f0; border-radius: 4px;">
                                <div style="width: 85%; height: 100%; background: #8B0000; border-radius: 4px;"></div>
                            </div>
                            <span style="width: 40px; text-align: right;">85%</span>
                        </div>
                        <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                            <span style="width: 60px;">8 PM</span>
                            <div style="flex: 1; height: 8px; background: #f0f0f0; border-radius: 4px;">
                                <div style="width: 90%; height: 100%; background: #8B0000; border-radius: 4px;"></div>
                            </div>
                            <span style="width: 40px; text-align: right;">90%</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <span style="width: 60px;">9 PM</span>
                            <div style="flex: 1; height: 8px; background: #f0f0f0; border-radius: 4px;">
                                <div style="width: 60%; height: 100%; background: #8B0000; border-radius: 4px;"></div>
                            </div>
                            <span style="width: 40px; text-align: right;">60%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Reservations -->
            <div class="recent-section">
                <div class="section-header">
                    <h2>Recent Reservations</h2>
                    <a href="manage-reservations.php" class="view-all">View All →</a>
                </div>
                
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Guests</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_reservations as $res): ?>
                            <tr>
                                <td>#<?php echo $res['id']; ?></td>
                                <td><?php echo htmlspecialchars($res['name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($res['reservation_date'])); ?></td>
                                <td><?php echo date('g:i A', strtotime($res['reservation_time'])); ?></td>
                                <td><?php echo $res['guests']; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $res['status']; ?>">
                                        <?php echo ucfirst($res['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="view-reservation.php?id=<?php echo $res['id']; ?>" class="action-btn view">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="edit-reservation.php?id=<?php echo $res['id']; ?>" class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <div class="quick-action-card" onclick="window.location.href='add-reservation.php'">
                    <i class="fas fa-plus-circle"></i>
                    <h4>New Reservation</h4>
                    <p>Manually add a booking</p>
                </div>
                <div class="quick-action-card" onclick="window.location.href='reports.php'">
                    <i class="fas fa-chart-bar"></i>
                    <h4>Generate Report</h4>
                    <p>Monthly summary</p>
                </div>
                <div class="quick-action-card" onclick="window.location.href='manage-menu.php'">
                    <i class="fas fa-edit"></i>
                    <h4>Update Menu</h4>
                    <p>Add or remove items</p>
                </div>
                <div class="quick-action-card" onclick="window.location.href='special-events.php'">
                    <i class="fas fa-star"></i>
                    <h4>Special Events</h4>
                    <p>Manage promotions</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh data every 30 seconds (optional)
        // setInterval(() => {
        //     location.reload();
        // }, 30000);
    </script>
</body>
</html>