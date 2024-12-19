<?php
session_start();
include('db.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] === 'admin') {
                header('Location: index.php'); 
            } else {
                header('Location: add_product.php'); 
            }
            exit();
        } else {
            echo "<div class='alert alert-danger'>Invalid password.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>No account found with that email.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .btn-link {
            color: #007BFF;
        }
        .btn-link:hover {
            text-decoration: underline;
        }
        #loader {
            display: none;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
<div class="container animate__animated animate__fadeInDown mt-5">
    <h1>Login</h1>
    <form method="POST" action="" onsubmit="showLoader()">
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <a href="signup.php" class="btn btn-link d-block text-center mt-2">Don't have an account? Signup here.</a>
    </form>
    <!-- Loader -->
    <div id="loader" class="text-center mt-3">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p>Please wait...</p>
    </div>
</div>

<script>
    function showLoader() {
        document.querySelector('button[type="submit"]').disabled = true;
        document.getElementById('loader').style.display = 'block';
    }
</script>
</body>
</html>
