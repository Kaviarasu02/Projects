<?php
session_start();

// Database connection details
$host = 'localhost';
$db = 'matrimony';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, first_name, last_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $firstName, $lastName, $hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['first_name'] = $firstName;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['logged_in'] = true;
        header("Location: profile.php");
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
}
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>matrimony-login</title>
    <link rel="stylesheet" type="text/css" href="styles/login.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>
<body>
    <div class="header-card">
        <header>
            <div class="logo">
                <img src="img/logo.png" alt="matrimony_logo" />
            </div>
            <h1>Matrimony</h1>
            <div class="login">
                <button class="btn">
                    <a href="login.html">Login <i class="fas fa-user"></i></a>
                </button>
                <button class="btn">
                    <a href="register.html">Register <i class="fa-solid fa-user-plus"></i></a>
                </button>
            </div>
        </header>
    </div>
    <section>
        <div class="login-container">
            <div class="heading">Login</div>
            <form class="form" action="login.php" method="post">
                <input placeholder="Email" id="email" name="email" type="email" class="input" required />
                <input placeholder="Password" id="password" name="password" type="password" class="input" required />
                <input value="Login" type="submit" class="login-button" />
            </form>
        </div>
    </section>
    <footer>
        <div class="rights">
            <p>&copy; 2023 Matrimony. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
