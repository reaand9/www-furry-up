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
    <title>Sign in Page</title>
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
    <div class="whole-regis">
    <div class="row">
        <div class="col s3 m3 l3"></div>
        <div class="col s6 m6 l6">
            <div class="row">   
                <h4 style="text-align: center; font-weight:800; padding-bottom: 5px;">Sign in</h4>
                <h6 style="text-align: center; font-weight:200;">Give a paw to our furry friends!</h6>
                <div class="input-field col s12 m12 l12">
                    <i class="material-icons prefix">account_circle</i> <!-- icon -->
                    <input id="emailInput" type="text" class="validate round-input" style="width: 81%;"> <!-- input type -->
                    <label class="labelnames" for="emailInput">Email</label> <!-- label -->
                    <span class="field-error" id="emailError"></span>
                </div>

                <div class="input-field col s12 m12 l12 password-field">
                    <i class="material-icons prefix" id="togglePasswordIcon" onclick="togglePasswordVisibility()">visibility_off</i><!-- icon -->
                    <input id="passwordInput" type="password" class="validate round-input password-with-icon" style="width: 81%;"> <!-- input type -->
                    <label class="labelnames" for="passwordInput">Password</label> <!-- label -->
                    <span class="field-error" id="passwordError"></span>
                </div>

                <div class="add col s12 m12 l12"> <!-- button -->
                        <a class="waves-effect waves-light btn-small auth-btn" onclick="signinFunc()">
                        <i class="buttons material-icons left">login</i> <!-- icon -->
                        Sign in</a> 
                </div>

                <div class="col s12 m12 l12"></div>

            </div>
            </div>
        </div>
        <div class="col s4 m4 l4"></div>
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
