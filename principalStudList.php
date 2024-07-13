<?php
include_once "principalHeader.php"; 
require_once "db_connection.php";

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$where_clause = $search ? "WHERE s.studentName LIKE '%$search%' OR s.studentIC LIKE '%$search%'" : '';

// Sorting
$sort = isset($_GET['sort']) ? $conn->real_escape_string($_GET['sort']) : 's.classID';
$order = isset($_GET['order']) ? $conn->real_escape_string($_GET['order']) : 'ASC';

// Fetch student data
$query = "
    SELECT SQL_CALC_FOUND_ROWS s.studentIC, s.studentName, s.studentAge, s.studentEmail, c.className
    FROM student s
    JOIN class c ON s.classID = c.classID
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
        }
        .main-content {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 80px;
        }
        .table th {
            background-color: #2b4560;
            color: white;
        }
        .action-link {
            color: #2b4560;
            text-decoration: none;
            margin-right: 10px;
        }
        .action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container main-content">
        <h2 class="mb-4">Student List</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><a href="?sort=studentIC&order=<?php echo $sort == 'studentIC' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>" class="text-white">Student IC</a></th>
                        <th><a href="?sort=studentName&order=<?php echo $sort == 'studentName' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>" class="text-white">Student Name</a></th>
                        <th><a href="?sort=studentAge&order=<?php echo $sort == 'studentAge' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>" class="text-white">Age</a></th>
                        <th><a href="?sort=studentEmail&order=<?php echo $sort == 'studentEmail' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>" class="text-white">Email</a></th>
                        <th><a href="?sort=className&order=<?php echo $sort == 'className' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>" class="text-white">Class</a></th>
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
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>