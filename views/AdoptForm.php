<?php
session_start();

    // BLOCK if not logged in
    if(!isset($_SESSION['userID'])) {
        header("Location: SignInPage.php");
        exit;
    }

    require_once "../bl/PetManager.php";

    $petID = $_GET['petID'];

    $petManager = new PetManager();
    $pets = $petManager->getPets();

    $selectedPet = null;

    foreach ($pets as $pet) {
        if ($pet['petID'] == $petID) {
            $selectedPet = $pet;
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Materialize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="style-adopt.css">

    <title>Adoption Page</title>
</head>

<body style="background-image: url('login-regist.png'); 
    background-size: cover;        
    background-position: center;  
    background-repeat: no-repeat;  
    background-attachment: fixed;">

<!-- HEADER -->
<header class="header">
    <h1 class="logo">FURRY UP</h1>
    <div class="nav-buttons">
        <button onclick="location.href='HomePage.php'">HOME</button>
        <button onclick="location.href='HomePage.php#about'">ABOUT US</button>
        <button onclick="location.href='#contact'">CONTACT</button>
    </div>
</header>

<!-- MAIN -->
<div class="container">
    <div class="adopt-wrapper">

        <!-- LEFT -->
        <div class="adopt-left card">
            <h3>Your Lovely Companion</h3>

            <?php if($selectedPet): ?>
                <img src="../uploads/<?php echo $selectedPet['picture']; ?>" class="pet-img">

                <h4><?php echo $selectedPet['name']; ?></h4>

                <p>
                    <?php echo $selectedPet['age']; ?> years old • 
                    <?php echo $selectedPet['petDescription']; ?>
                </p>
            <?php else: ?>
                <p>Pet not found.</p>
            <?php endif; ?>
        </div>

        <!-- RIGHT -->
        <div class="adopt-right card">
            <h3>Adoption Request Form</h3>

            <form>
                <input type="hidden" name="petID" value="<?php echo $petID; ?>">

                <div class="input-field">
                    <input type="text" name="fullName" required>
                    <label>Full Name</label>
                </div>

                <div class="input-field">
                    <input type="text" name="address" required>
                    <label>Address</label>
                </div>

                <div class="input-field">
                    <input type="text" id="contact" name="contact" required>
                    <label>Contact Number</label>
                </div>

                <div class="input-field">
                    <textarea name="reason" class="materialize-textarea" required></textarea>
                    <label>Why do you want to adopt?</label>
                </div>

                <button type="submit">
                    Submit Request
                </button>
            </form>
        </div>

    </div>
</div>

<!-- FOOTER -->
<footer id="contact">
    <h2>CONTACT US</h2>
    <p>Email: furryupinfo@gmail.com</p>
    <p>Phone: +63 912 345 6789</p>
    <p>Address: Interior Lot 92M From Leonard Wood Road, Cabinet Hill - Furry Up, Paranaque City</p>
    <p>© 2025 Furry Up | Paranaque City, Philippines</p>
</footer>

</body>
</html>