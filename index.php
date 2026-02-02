<?php
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $host = "localhost";
        $port = 3307;
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "tamilhacks";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname, $port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT uname1, upswd1 FROM register1 WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($uname1, $stored_password);
            $stmt->fetch();

            if ($password === $stored_password) {
                $_SESSION['uname1'] = $uname1;
                header("Location: home.html");
                exit();
            } else {
                $error = "❌ Invalid password.";
            }
        } else {
            $error = "❌ Email not registered.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $error = "❌ Both email and password are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:white(255, 254, 254); /* dark gray background */
            color: white;
            padding: 20px;
        }

        .login-container {
            max-width: 400px;
            margin: 40px auto;
            background-color: #4a4a4a; /* keep same as background for consistent look */
            padding: 30px 25px;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
            color: white;
            font-size: 22px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 6px;
            font-weight: bold;
            color: white;
        }

        input[type="email"],
        input[type="password"] {
            padding: 10px;
            border: none;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 16px;
            width: 100%;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            box-shadow: 0 0 5px #5bb8d9; /* blue glow */
        }

        button {
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            color: white;
            margin-bottom: 12px;
        }

        .btn-primary {
            background-color: #d45a57; /* muted red */
        }

        .btn-primary:hover {
            background-color: #b64b49;
        }

        .btn-secondary {
            background-color: #5bb8d9; /* bright sky blue */
        }

        .btn-secondary:hover {
            background-color: #499ec1;
        }

        .error-message {
            color: #ff6b6b;
            margin-bottom: 15px;
            text-align: center;
            font-weight: bold;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: white;
        }

        .footer-text a {
            color: #5bb8d9;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>User Login</h2>

        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="off" />

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autocomplete="off" />

            <button type="submit" class="btn-primary">Login</button>
        </form>

        

        <p class="footer-text">Don't have an account? <a href="register.html">Register here</a></p>
    </div>

</body>
</html>
