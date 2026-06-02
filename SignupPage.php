<?php
include 'db_connect.php';
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    
    // Matches your ERD: ContactPerson, Email, Phone
    $sql = "INSERT INTO customer (ContactPerson, Email, Phone, Password) VALUES ('$name', '$email', '$phone', '$pass')";
    if ($conn->query($sql)) { header("Location: LoginPage.php"); } 
    else { $msg = "Error: " . $conn->error; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up | Tagaytay Venue</title>
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
        <h2 style="text-align:center; color:#1a1a2e;">Join Us</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Contact Person Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="phone" placeholder="Phone Number">
            <input type="password" name="pass" placeholder="Password" required>
            <button type="submit">Create Account</button>
        </form>
    </div>
</body>
</html>