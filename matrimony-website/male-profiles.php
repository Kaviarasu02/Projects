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

$query = "SELECT * FROM users WHERE gender = 'male'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matrimony Profiles - Male</title>
    <link rel="stylesheet" type="text/css" href="styles/male-profiles.css" />
    <script src="scripts/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="header-card">
        <header>
            <div class="logo">
                <img src="img/logo.png" alt="Matrimony Logo" />
            </div>
            <h1>Matrimony</h1>
        </header>
    </div>

    <main>
        <div class="container">
            <div class="pro-header">
                <h1>Profile Gallery</h1>
            </div>
            <section class="gallery">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="profile-card" data-profile-id="' . $row['id'] . '">';
                        echo '<img src="img/profile/men/men' . $row['id'] . '.jpg" alt="' . $row['first_name'] . ' ' . $row['last_name'] . '">';
                        echo '<div class="profile-details">';
                        echo '<h2>' . $row['first_name'] . ' ' . $row['last_name'] . '</h2>';
                        echo '<p>Age: ' . $row['age'] . '</p>';
                        echo '<p>Location: ' . $row['location'] . '</p>';
                        echo '<p>Profession: ' . $row['profession'] . '</p>';
                        echo '<div class="star-rating">';
                        echo '<span class="star" data-value="1">&#9734;</span>';
                        echo '<span class="star" data-value="2">&#9734;</span>';
                        echo '<span class="star" data-value="3">&#9734;</span>';
                        echo '<span class="star" data-value="4">&#9734;</span>';
                        echo '<span class="star" data-value="5">&#9734;</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No profiles found.</p>';
                }
                $conn->close();
                ?>
            </section>
        </div>
    </main>

    <footer>
        <div class="rights">
            <p>&copy; 2024 Matrimony. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
