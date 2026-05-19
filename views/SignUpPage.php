<?php
    session_start();
    require_once "../bl/UserManager.php";
    require_once "../bl/RoleManager.php";

    $usermanager = new UserManager();
    $users = $usermanager->getUser(); // has the session array 
    $advancedUsers = $usermanager->getAdvancedUser();

    $rolemanager = new RoleManager();
    $roles = $rolemanager->getRoles();
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
    <title>Sign Up Page</title>
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

    <div class="main-content">
    <div class="whole-regis col s6 m6 l6">
    <div class="row">
        <div class="col s3 m3 l3">
        </div>
        <div class="col s6 m6 l6">
            <div class="row">

                    <h4 style="text-align: center; font-weight:800; padding-bottom: 5px;">Sign up</h4>
                    <h6 style="text-align: center; font-weight:200;">Be a loving companion!</h6>
                    
                    <div class="input-field col s12 m12 l12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="firstNameInput" type="text" style="width: 81%;" class="validate round-input" maxlength="49">
                        <label class="labelnames" for="firstNameInput">First Name</label>
                        <span class="field-error" id="firstNameError"></span>
                    </div>

                    <div class="input-field col s12 m12 l12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="lastNameInput" type="text" style="width: 81%;" class="validate round-input" maxlength="49">
                        <label class="labelnames" for="lastNameInput">Last Name</label>
                        <span class="field-error" id="lastNameError"></span>
                    </div>

                    <div class="input-field col s12 m12 l12"> <!-- age -->
                        <i class="material-icons prefix">calendar_today</i> <!-- icon -->
                        <input id="ageInput" type="text" class="validate round-input" style="width: 81%;" maxlength="3"> <!-- input type -->
                        <label class="labelnames" for="ageInput">Age</label> <!-- label -->
                        <span class="field-error" id="ageError"></span>
                    </div>

                    <div class="input-field col s12 m12 l12"> <!-- email -->
                        <i class="material-icons prefix">email</i> <!-- icon -->
                        <input id="emailInput" type="text" class="validate round-input" style="width: 81%;" maxlength="49"> <!-- input type -->
                        <label class="labelnames" for="emailInput">Email</label> <!-- label -->
                        <span class="field-error" id="emailError"></span>
                    </div>

                    <div class="input-field col s12 m12 l12"> <!-- password -->
                        <i class="material-icons prefix" id="togglePasswordIcon" onclick="togglePasswordVisibility()">visibility_off</i> <!-- icon -->
                        <input id="passwordInput" type="password" class="validate round-input" style="width: 81%;" maxlength="49"> <!-- input type -->
                        <label class="labelnames" for="passwordInput">Password</label>  <!-- label -->
                        <span class="field-error" id="passwordError"></span>
                    </div>

                    <div class="input-field col s12 m12 l12"> <!-- confirm password -->
                        <i class="material-icons prefix">lock</i> <!-- icon -->
                        <input id="confirmPasswordInput" type="password" class="validate round-input" style="width: 81%;" maxlength="49"> <!-- input type -->
                        <label class="labelnames" for="confirmPasswordInput">Confirm Password</label>  <!-- label -->
                        <span class="field-error" id="confirmPasswordError"></span>
                    </div>

                <div class="input-field col s12 m12 l12"> <!-- user roles drop down -->
                    <select id="roleSelect">
                        <option value="" disabled selected>Choose your option</option>
                        <?php foreach($roles as $index => $role) : ?>
                        <option value="<?= $role['roleID'] ?>"><?= $role['roleDescription'] ?></option> <!-- kukunin ung value from column roleDescription in tbl_user_roles -->
                        <?php endforeach ?>
                    </select>
                    <label>How will you help our furry friends?</label>
                    <span class="field-error" id="roleError"></span>
                </div>

                <div class="add col s6 m6 l6"> <!-- add button -->
                    <a class="waves-effect waves-light btn-small auth-btn" onclick="addFunc()">
                    <i class="buttons material-icons left">add_circle</i> <!-- icon -->
                    Sign up</a> 
                </div>

                <?php if(!empty($advancedUsers)) : ?> <!-- login button -->
                    <div class="add col s6 m6 l6"> <!-- button -->
                        <a class="waves-effect waves-light btn-small auth-btn" style="width: 100%;" onclick="redirectFunc(1)">
                        <i class="buttons material-icons left">login</i> <!-- icon -->
                        Sign in</a> 
                    </div>
                <?php endif ?>

                </div>
            </div> 
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

</body>
</html>

