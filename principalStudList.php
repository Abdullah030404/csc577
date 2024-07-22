<?php
include_once "principalHeader.php"; 
require_once "db_connection.php";

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$where_clause = $search ? "AND (s.studentName LIKE '%$search%' OR s.studentIC LIKE '%$search%')" : '';

// Sorting
$sort = isset($_GET['sort']) ? $conn->real_escape_string($_GET['sort']) : 's.classID';
$order = isset($_GET['order']) ? $conn->real_escape_string($_GET['order']) : 'ASC';

// Fetch student data
$query = "
    SELECT SQL_CALC_FOUND_ROWS s.studentIC, s.studentName, s.studentAge, s.studentEmail, c.className
    FROM student s
    JOIN class c ON s.classID = c.classID
    WHERE s.status = 'A'
    $where_clause
    ORDER BY $sort $order
    LIMIT $offset, $records_per_page
";
$result = $conn->query($query);

// Get total number of records
$total_records = $conn->query("SELECT FOUND_ROWS()")->fetch_row()[0];
$total_pages = ceil($total_records / $records_per_page);

// Fetch student data
$students = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 80px auto;
            padding: 20px;
            margin-top: 20px;
        }
        .main-content {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .profile-header {
            background-color: #2b4560;
            color: #ffffff;
            padding: 2rem;
            text-align: center;
            font-size: 1.5em;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #white;
            margin-bottom: 20px;
            text-align: center;
        }
        .search-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        .search-form input[type="search"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
            font-size: 16px;
        }
        .search-form button {
            padding: 10px 20px;
            background-color: #2b4560;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .search-form button:hover {
            background-color: #1c2e3f;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2b4560;
            color: white;
        }
        th a {
            color: white;
            text-decoration: none;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .action-link {
            color: #2b4560;
            text-decoration: none;
            margin-right: 10px;
            transition: color 0.3s;
        }
        .action-link:hover {
            color: #1c2e3f;
            text-decoration: underline;
        }
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination a {
            display: block;
            padding: 8px 12px;
            background-color: #2b4560;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .pagination a:hover, .pagination .active a {
            background-color: #1c2e3f;
        }
        .no-data {
            text-align: center;
            font-size: 1.2em;
            color: #333;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-content">
            <div class="profile-header">
                <h2>Student List</h2>
            </div>
            <form class="search-form" action="" method="GET">
                <input type="search" name="search" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
            <?php if (empty($students)): ?>
                <div class="no-data">No matching data found.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th><a href="?sort=studentIC&order=<?php echo $sort == 'studentIC' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Student IC</a></th>
                            <th><a href="?sort=studentName&order=<?php echo $sort == 'studentName' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Student Name</a></th>
                            <th><a href="?sort=studentAge&order=<?php echo $sort == 'studentAge' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Age</a></th>
                            <th><a href="?sort=studentEmail&order=<?php echo $sort == 'studentEmail' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Email</a></th>
                            <th><a href="?sort=className&order=<?php echo $sort == 'className' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Class</a></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['studentIC']); ?></td>
                                <td><?php echo htmlspecialchars($student['studentName']); ?></td>
                                <td><?php echo htmlspecialchars($student['studentAge']); ?></td>
                                <td><?php echo htmlspecialchars($student['studentEmail']); ?></td>
                                <td><?php echo htmlspecialchars($student['className']); ?></td>
                                <td>
                                    <a class="action-link" href="principalUpdateStud.php?studentIC=<?php echo htmlspecialchars($student['studentIC']); ?>">Update</a>
                                    <a class="action-link" href="principalDeleteStud.php?studentIC=<?php echo htmlspecialchars($student['studentIC']); ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li <?php echo $page == $i ? 'class="active"' : ''; ?>>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>
</body>
</html>
