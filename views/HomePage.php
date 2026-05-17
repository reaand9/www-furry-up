<?php
  session_start();
  require_once "../bl/PetManager.php";

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <!-- google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Noto+Sans+Display:wght@300;400;600;700;800&display=swap" rel="stylesheet"> <!-- google fonts-->
    <link rel="stylesheet" href="style-home.css">
    <title>Home Page</title>
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <h1 class="logo">FURRY UP</h1>
    <div class="nav-buttons">
      <button onclick="location.href='#home'">HOME</button>
      <button onclick="location.href='#about'">ABOUT US</button>
      <button onclick="location.href='#contact'">CONTACT</button>
      <button onclick="location.href='#shelter'" class="adopt">ADOPT</button>
      <button onclick="location.href='SignInPage.php'" class="signin">SIGN IN</button>
      <button onclick="location.href='SignUpPage.php'" class="signup">SIGN UP</button>
    </div>
  </header>

  <!-- MAIN SECTION -->
  <section class="banner" id="home">
    <div class="overlay"></div>
    <div class="banner-text">
      <h2>Rescue a pet, <h2 style="color: #6b2210;">change lives</h2></h2>
      <p>Be their hero and give them the chance to live a better life surrounded by kindness, warmth, and a family who cares.</p>
      <button onclick="location.href='#shelter'">Meet our furry friends</button>
    </div>
    <div class="col s6 m10 l10" id="float-img">
      <img src="dog-home.png" class="banner-img">
    </div>
  </section>

  <!-- SHELTER SECTION -->
  <section class="shelter" id="shelter">

    <div class="shelter-header">
      <span class="tag">- ADOPT NOW -</span>
      <h2>Every Animal Deserves a Loving Home<span>.</span></h2>
      <p>
        Adoption is a lifelong promise of love and care — open your heart and give a homeless pet a forever home.
      </p>
    </div>

    <!-- filter tabs -->
    <div class="tabs" style="width: 700px;">
      <a href="?species=1#shelter"><button class="cats">Cats</button></a>
      <a href="?species=2#shelter"><button class="dogs">Dogs</button></a>
      <a href="?species=3#shelter"><button class="bunnies">Birds</button></a>
      <a href="HomePage.php#shelter"><button>All</button></a>
    </div>

    <!-- pet cards -->
    <div class="pet-container">

      <?php foreach($pets as $pet): ?>

        <div class="pet-card">
            <div class="pet-card-image">
                <img src="../uploads/<?php echo $pet['picture']; ?>" alt="<?php echo htmlspecialchars($pet['name']); ?>">
            </div>
            <div class="pet-card-info">
                <h5><?php echo htmlspecialchars($pet['name']); ?></h5>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> years old</p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($pet['petDescription']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($pet['pet_statusDescription']); ?></p>
            </div>
            <button onclick="location.href='AdoptForm.php?petID=<?php echo $pet['petID']; ?>'">Adopt</button>
        </div>
        <?php endforeach; ?>

    </div>

  </section>

  <!-- ABOUT US SECTION -->
  <section class="about-us-top" id="about">

    <div class="about-us-wrapper">

      <div class="about-us-image">
        <img src="shelter-about-us.jpg" alt="about us">
      </div>

      <div class="about-us-content">

        <div class="about-label">- ABOUT US -</div>

        <h3>What Makes Us Care About Pets.</h3>

        <h5>Our love for animals drives everything we do.</h5>

        <p>
          We care about pets because we see their unique personalities, 
          the joy they bring, and their unwavering loyalty. 
          Every animal deserves a chance to live a happy, healthy life, 
          surrounded by love. Our mission is to rescue, protect, and find 
          forever homes for these animals, giving them the second chance they truly deserve.
        </p>

      </div> 
    </div>

  </section>

  <!-- ADVOCACY SECTION -->      
  <section class="advocacy">

    <div class="advocacy-container">

      <div class="advocacy-text">
        <h3>Lend a Paw, Change a Life<span>.</span></h3>

        <p>
          Join us in making a difference today. Your support helps rescue
          animals, provide care, and give them the chance to find loving homes.
        </p>

        <h5>How You Can Help:</h5>

        <ul>
          <li><strong>Adopt a Pet</strong> – Open your heart and home to a pet in need.</li>
          <li><strong>Donate</strong> – Your donation directly funds veterinary care, food, and shelter.</li>
          <li><strong>Volunteer</strong> – Give your time to make a meaningful impact.</li>
        </ul>
      </div>

      <div class="advocacy-image">
        <img src="cat-advocacy.png" alt="cat">
      </div>

    </div>

  </section>

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


