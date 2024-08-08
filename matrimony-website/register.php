<?php
// Database connection details
$host = 'localhost';
$db = 'matrimony_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first-name'];
    // $middleName = $_POST['middle-name'];
    // $lastName = $_POST['last-name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    // $gender = $_POST['gender'];
    // $age = $_POST['age'];
    // $profession = $_POST['profession'];
    // $location = $_POST['location'];
    // $religion = $_POST['religion'];
    // $community = $_POST['community'];
    // $caste = $_POST['caste'];
    $mobileNo = $_POST['mobile-no'];
    $email = $_POST['email'];

    // $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, password, gender, age, profession, location, religion, community, caste, mobile_no, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt = $conn->prepare("INSERT INTO users (first_name, password, mobile_no, email) VALUES (?, ?, ?, ?)");

    // $stmt->bind_param("sssssiissssss", $firstName, $middleName, $lastName, $password, $gender, $age, $profession, $location, $religion, $community, $caste, $mobileNo, $email);
    $stmt->bind_param("ssss", $firstName, $password, $mobileNo, $email);
    if ($stmt->execute()) {
        // echo "Registration successful!";
        header("Location: login.php");
    } else {
        echo "Error: " . $stmt->error;
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
    <title>matrimony-register</title>
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
        <div class="register-container">
            <div class="heading">Register</div>
            <form class="form" action="register.php" method="post">
                <input placeholder="First Name" id="first-name" name="first-name" type="text" class="input" required />
                <!-- <input placeholder="Middle Name (Optional)" id="middle-name" name="middle-name" type="text" class="input" /> -->
                <!-- <input placeholder="Last Name" id="last-name" name="last-name" type="text" class="input" required /> -->
                <input placeholder="Password" id="password" name="password" type="password" class="input" required />
                <!-- <select id="gender" name="gender" class="input" required>
                    <option value="" disabled selected>Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <input placeholder="Age" id="age" name="age" type="number" class="input" min="18" required />
                <input placeholder="Profession" id="profession" name="profession" type="text" class="input" required />
                <input placeholder="Location" id="location" name="location" type="text" class="input" required />
                <input placeholder="Religion" id="religion" name="religion" type="text" class="input" required />
                <input placeholder="Community" id="community" name="community" type="text" class="input" required />
                <input placeholder="Caste" id="caste" name="caste" type="text" class="input" required /> -->
                <input placeholder="Mobile No" id="mobile-no" name="mobile-no" type="tel" class="input" required />
                <input placeholder="Email" id="email" name="email" type="email" class="input" required />
                <input value="Register" type="submit" class="login-button" />
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