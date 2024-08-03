<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.html");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="styles/profile.css" />
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
                    <a href="logout.php">Logout <i class="fas fa-sign-out-alt"></i></a>
                </button>
            </div>
        </header>
    </div>
    <section>
        <div class="profile-container">
            <h2>Welcome, <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>!</h2>
            <p>Your profile details go here.</p>
            <!-- Add more user-specific information as needed -->
        </div>
    </section>
    <footer>
        <div class="rights">
            <p>&copy; 2023 Matrimony. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
