<?php
session_start();

require_once "../bl/PetManager.php";

$petID = isset($_GET['petID']) ? $_GET['petID'] : null;

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style-signin-signup.css">
    <title>Adoption Page</title>
</head>
<body style="background-image: url('login-regist.png'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">

<header class="header">
    <h1 class="logo">FURRY UP</h1>
    <div class="nav-buttons">
        <button onclick="location.href='HomePage.php'">HOME</button>
        <button onclick="location.href='HomePage.php#about'">ABOUT US</button>
        <button onclick="location.href='#contact'">CONTACT</button>
    </div>
</header>

<div class="main-content">
    <div class="whole-regis col s6 m6 l6">
        <div class="row">
            <div class="col s3 m3 l3"></div>
            <div class="col s6 m6 l6">
                <div class="row">

                    <h4 style="text-align: center; font-weight:800; padding-bottom: 5px;">Adoption Request</h4>
                    <h6 style="text-align: center; font-weight:200;">Please complete the form to request adoption</h6>

                    <br>

                    <?php if ($selectedPet): ?>
                        <div class="selected-pet-card" >
                            <div class="pet-card-image">
                                <img src="../uploads/<?php echo htmlspecialchars($selectedPet['picture']); ?>" alt="<?php echo htmlspecialchars($selectedPet['name']); ?>">
                            </div>
                            <div class="pet-card-info">
                                <h5><?php echo htmlspecialchars($selectedPet['name']); ?></h5>
                                <p><strong>Age:</strong> <?php echo htmlspecialchars($selectedPet['age']); ?> years old</p>
                                <p><strong>Description:</strong> <?php echo htmlspecialchars($selectedPet['petDescription']); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($selectedPet['pet_statusDescription']); ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <p style="text-align: center; color: #777; margin-bottom: 24px;">No pet selected. Please return to the pet list and choose a pet to adopt.</p>
                    <?php endif; ?>

                    <form id="adoptionForm" method="post">
                        <input type="hidden" name="petID" value="<?php echo htmlspecialchars($petID); ?>">

                        <div class="input-field col s12 m12 l12">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="fullName" name="fullName" type="text" style="width: 81%;" class="validate round-input" maxlength="49">
                            <label class="labelnames" for="fullName">Full Name</label>
                            <span class="field-error" id="fullNameError"></span>
                        </div>

                        <div class="input-field col s12 m12 l12">
                            <i class="material-icons prefix">home</i>
                            <input id="address" type="text" name="address" style="width: 81%;" class="validate round-input">
                            <label class="labelnames" for="address">Address</label>
                            <span class="field-error" id="addressError"></span>
                        </div>

                        <div class="input-field col s12 m12 l12">
                            <i class="material-icons prefix">email</i>
                            <input id="email" type="email" name="email" style="width: 81%;" class="validate round-input">
                            <label class="labelnames" for="email">Email Address</label>
                            <span class="field-error" id="emailError"></span>
                        </div>

                        <div class="input-field col s12 m12 l12">
                            <i class="material-icons prefix">phone</i>
                            <input id="phoneNumber" type="text" name="phone" style="width: 81%;" class="validate round-input">
                            <label class="labelnames" for="phoneNumber">Phone Number</label>
                            <span class="field-error" id="phoneError"></span>
                        </div>

                        <div class="input-field col s12 m12 l12">
                            <i class="material-icons prefix">edit_note</i>
                            <textarea id="reason" name="reason" class="materialize-textarea round-input adopt-textarea" style="width: 88%;"></textarea>
                            <label class="labelnames" for="reason">Why do you want to adopt?</label>
                            <span class="field-error" id="reasonError"></span>
                        </div>

                        <div class="add col s12 m12 l12" style="display:flex; justify-content:center;">
                            <a class="waves-effect waves-light btn-small auth-btn" onclick="submitAdoption()" style="width: 100%;">
                                <i class="buttons material-icons left">send</i>
                                Submit Request
                            </a>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col s3 m3 l3"></div>
        </div>
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

<script>
function clearError(id){ if(id){ document.getElementById(id).textContent = ''; }}

function submitAdoption(){
    ['fullNameError','addressError','emailError','phoneError','reasonError'].forEach(id=>clearError(id));

    const fullName = document.getElementById('fullName').value.trim();
    const address = document.getElementById('address').value.trim();
    const email = document.getElementById('email').value.trim();
    const phoneRaw = document.getElementById('phoneNumber').value;
    const phoneDigits = phoneRaw.replace(/\D/g,'');
    const reason = document.getElementById('reason').value.trim();

    let valid = true;

    if(!fullName){ document.getElementById('fullNameError').textContent = 'This field cannot be empty'; valid = false; }
    if(!address){ document.getElementById('addressError').textContent = 'This field cannot be empty'; valid = false; }
    if(!email){ document.getElementById('emailError').textContent = 'This field cannot be empty'; valid = false; }
    else { const gmailPattern = /^[A-Za-z0-9._%+-]+@gmail\.com$/i; if(!gmailPattern.test(email)){ document.getElementById('emailError').textContent = 'Please enter a valid @gmail.com address'; valid = false; }}
    if(!phoneDigits || phoneDigits.length < 10){ document.getElementById('phoneError').textContent = 'Phone number must be at least 10 digits'; valid = false; }
    if(!reason){ document.getElementById('reasonError').textContent = 'This field cannot be empty'; valid = false; }

    if(valid){
        $.ajax({
            url: "../controllers/Controller.php",
            type: "POST",
            data: {
                action: "createAdoption",
                fullName: fullName,
                address: address,
                email: email,
                phone: phoneDigits,
                reason: reason,
                petID: document.querySelector('input[name="petID"]').value
            },
            success: function(response) {
                showThemedAlert({
                    title: "Request sent",
                    text: response,
                    icon: "success"
                }).then(function(){
                    window.location.href = "HomePage.php";
                });
            },
            error: function(xhr) {
                showThemedAlert({
                    title: "Error",
                    text: xhr.responseText || "Unable to submit request.",
                    icon: "error"
                });
            }
        });
    }
}

['fullName','address','email','phoneNumber','reason'].forEach(function(id){ const el = document.getElementById(id); if(el){ el.addEventListener('input', function(){ const err = document.getElementById(id + 'Error'); if(err) err.textContent = ''; }); } });
</script>

</body>
</html>