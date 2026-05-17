<?php
    session_start();
    require_once "../bl/UserManager.php";
    require_once "../bl/RoleManager.php";
    require_once "../bl/PetManager.php";

    $usermanager = new UserManager();
    $users = $usermanager->getUser(); // has the session array 
    $advancedUsers = $usermanager->getAdvancedUser();

    $rolemanager = new RoleManager();
    $roles = $rolemanager->getRoles();

    $petManager = new PetManager();

    $speciesID = isset($_GET['species']) ? $_GET['species'] : null;

    $pets = $petManager->getPets($speciesID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> <!-- ajax -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- sweet alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> <!-- materialize css -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> <!-- materialize css -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!-- icons for materialize css -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <!-- google font -->
    <link rel="stylesheet" href="style-signin-signup.css">
    <title>Dashboard Page</title>
</head>
<body style="background-image: url('login-regist.png'); 
    background-size: cover;        
    background-position: center;  
    background-repeat: no-repeat;  
    background-attachment: fixed;" >

    <header class="header">
    <h1 class="logo">FURRY UP</h1>
    <div class="nav-buttons">
      <button onclick="location.href='HomePage.php'">HOME</button>
      <button onclick="location.href='HomePage.php#about'">ABOUT US</button>
      <button onclick="location.href='#contact'">CONTACT</button>
    </div>
    </header>

  <section class="">

  </section>


    <div class="main-content">
    <div class="whole-regis">   
            <h4 style="text-align: center; font-weight:800; padding-bottom: 5px;">Dashboard</h4>

            <p>Pending Adoption Requests:</p>
    </div>
    </div>

    <footer id="contact">
        <h2>CONTACT US</h2>
        <p>Email: furryupinfo@gmail.com</p>
        <p>Phone: +63 912 345 6789</p>
        <p>Address: Interior Lot 92M From Leonard Wood Road, Cabinet Hill - Furry Up, Paranaque City</p>
        <p>© 2025 Furry Up | Paranaque City, Philippines</p>
    </footer>

    <script src="../scripts/Service.js"></script>
</body>
</html>