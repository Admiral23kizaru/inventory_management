<?php
session_start();
include('db.php'); // Include your database connection file

// Check if user is admin and logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

// Fetch total number of products in the database
$totalProductsQuery = "SELECT COUNT(*) as total FROM products";
$totalProductsResult = $conn->query($totalProductsQuery);
$totalProducts = $totalProductsResult->fetch_assoc()['total'];

// Handle search functionality
$searchQuery = "";
$searchProductsCount = 0;
$result = null; // Default to null

if (isset($_GET['search'])) {
    $searchQuery = trim($_GET['search']); // Get search input from user

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR category LIKE ?");
    $searchTerm = '%' . $searchQuery . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Count matching products
    $stmtCount = $conn->prepare("SELECT COUNT(*) as count FROM products WHERE name LIKE ? OR category LIKE ?");
    $stmtCount->bind_param("ss", $searchTerm, $searchTerm);
    $stmtCount->execute();
    $searchCountResult = $stmtCount->get_result();
    $searchProductsCount = $searchCountResult->fetch_assoc()['count'];
} else {
    // If no search query, display all products
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $searchProductsCount = $totalProducts; // Total products if no search
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<style>
    body {
        background-image: url("INVENTORY.webp");
        background-size: cover;
        background-position: center;
        min-height: 50vh;
    }
    .container {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 30px;
        margin-top: 50px;
        border-radius: 10px;
        max-width: 1200px;
    }
</style>
<div class="container">
    <h1>INVENTORY MANAGEMENT SYSTEM</h1>
    <!-- Logout button with confirmation -->
    <a href="logout.php" class="btn btn-danger mb-3" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
    <a href="add_product.php" class="btn btn-success mb-3">Add Product</a>

    <!-- Search Bar -->
    <form method="GET" action="dashboard.php" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or category" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <p>Total products in the database: <strong><?php echo $totalProducts; ?></strong></p>

    <?php if (!empty($searchQuery)): ?>
        <p>Products matching your search "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>": <strong><?php echo $searchProductsCount; ?></strong></p>
    <?php else: ?>
        <p>Currently displaying all products.</p>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['stock']); ?></td>
                        <td>
                            <a href="update_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
