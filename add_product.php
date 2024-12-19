<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO products (name, category, price, quantity, stock) VALUES ('$name', '$category', '$price', '$quantity', '$stock')";

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background-image: url("INVENTORY.webp");
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: translateY(-10px);
        }
        h1 {
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: bold;
            color: #007BFF;
        }
        .input-group-text {
            background-color: #007BFF;
            color: white;
        }
        .btn-primary {
            background-color: #007BFF;
            border-color: #007BFF;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container animate__animated animate__fadeInDown mt-5">
    <h1>Add Product</h1>
    <form method="POST" action="">
        <div class="mb-4">
            <label for="name" class="form-label">Product Name</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-box"></i></span>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
        <div class="mb-4">
            <label for="category" class="form-label">Category</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                <input type="text" class="form-control" id="category" name="category" required>
            </div>
        </div>
        <div class="mb-4">
            <label for="price" class="form-label">Price</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
        </div>
        <div class="mb-4">
            <label for="quantity" class="form-label">Quantity</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
        </div>
        <div class="mb-4">
            <label for="stock" class="form-label">Stock</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Product</button>
    </form>
</div>
</body>
</html>
