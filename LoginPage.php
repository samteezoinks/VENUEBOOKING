<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $res = $conn->query("SELECT * FROM customer WHERE Email='$email'");
    if ($row = $res->fetch_assoc()) {
        if (password_verify($pass, $row['Password'])) {
            $_SESSION['uid'] = $row['CustomerID'];
            $_SESSION['uname'] = $row['ContactPerson'];
            header("Location: MainPage.php");
        } else { echo "<script>alert('Wrong password');</script>"; }
    } else { echo "<script>alert('User not found');</script>"; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Tagaytay Booking</title>
    <style>
        body {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('tagaytay_view.jpg'); /* Optional: Add a Tagaytay photo */
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    width: 350px;
    text-align: center;
}

input {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 30px; /* Rounded pill shape */
    background: #f9f9f9;
}

button {
    width: 100%;
    padding: 12px;
    background: #2c3e50;
    color: white;
    border: none;
    border-radius: 30px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #e67e22; /* Changes to Tagaytay Orange on hover */
    transform: scale(1.02);
}
    </style>
</head>
<body>
    <div class="card">
        <h2>Tagsbnb</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="pass" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p style="text-align:center">No account? <a href="SignupPage.php">Sign up</a></p>
    </div>
</body>
</html>