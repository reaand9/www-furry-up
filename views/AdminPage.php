<?php
    session_start();
    require_once "../bl/UserManager.php";
    require_once "../bl/RoleManager.php";
    require_once "../bl/AdminManager.php";
    require_once "../bl/PrivilegeManager.php";

    $privilegemanager = new PrivilegeManager();
    $privileges = $privilegemanager->getPrivileges();

    $adminmanager = new AdminManager();
    $admins = $adminmanager->getUser(); // has the session array 
    $adminUsers = $adminmanager->getAdvancedUser();
    $adminrolecard = $adminmanager->getRoleCard();
    $adminpetstatuscard = $adminmanager->getPetStatusCard();

    $rolemanager = new RoleManager();
    $roles = $rolemanager->getRoles();

    $label = array_column($adminpetstatuscard, 'pet_statusDescription');
    $data = array_column($adminpetstatuscard, 'total_pets');
    
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style-admin.css">
    <title>Admin Page</title>
</head>
<body style="background-image: url('login-regist.png'); 
    background-size: cover;        
    background-position: center;  
    background-repeat: no-repeat;  
    background-attachment: fixed;">

    <header class="header">
    <h1 class="logo">FURRY UP</h1>
    <div class="nav-buttons">
      <button onclick="location.href='HomePage.php'">HOME</button>
      <button onclick="location.href='#contact'">CONTACT</button>
    </div>
    </header>

    <div class="main-content">
    <div class="whole-regis col s6 m6 l6">
        <div class="row">
            <div class="col s3 m3 l3"></div>

            <div class="col s6 m6 l6">
                <div class="row">

                    <h4 style="text-align: center; font-weight:800; padding-bottom: 5px;">
                        Create or Update User
                    </h4>

                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="firstNameInput" type="text" style="width: 81%;" class="validate round-input">
                        <label class="labelnames" for="firstNameInput">First Name</label>
                    </div>

                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="lastNameInput" type="text" style="width: 81%;" class="validate round-input">
                        <label class="labelnames" for="lastNameInput">Last Name</label>
                    </div>

                    <div class="input-field col s12 m12 l12"> <!-- age -->
                        <i class="material-icons prefix">calendar_today</i> <!-- icon -->
                        <input id="ageInput" type="text" class="validate round-input" style="width: 81%;" maxlength="3"> <!-- input type -->
                        <label class="labelnames" for="ageInput">Age</label> <!-- label -->
                    </div>

                    <div class="input-field col s12">
                        <i class="material-icons prefix">email</i>
                        <input id="emailInput" type="text" class="validate round-input" style="width: 81%;">
                        <label class="labelnames" for="emailInput">Email</label>
                    </div>

                    <div class="input-field col s12">
                        <i class="material-icons prefix">lock</i>
                        <input id="passwordInput" type="text" class="validate round-input" style="width: 81%;">
                        <label class="labelnames" for="passwordInput">Password</label>
                    </div>

                    <div class="input-field col s12">
                        <select id="roleSelect">
                            <option value="" disabled selected>Choose your option</option>
                            <?php foreach($roles as $index => $role) : ?>
                                <option value="<?= $role['roleID'] ?>">
                                    <?= $role['roleDescription'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <label>User role</label>
                    </div>

                    <div class="input-field col s12">
                        <select id="privilegeSelect">
                            <option value="" disabled selected>Choose your option</option>
                            <?php foreach($privileges as $index => $priv) : ?>
                                <option value="<?= $priv['privilegeID'] ?>">
                                    <?= $priv['privilegeDescription'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <label>User privilege</label>
                    </div>

                    <div class="add col s12 m12 l12">
                        <a class="waves-effect waves-light btn-small add-btn" onclick="addAdminFunc()">
                        <i class="material-icons left">add_circle</i>
                        ADD OR UPDATE A USER
                        </a>
                    </div>

    </div>
    </div>
    </div>
    </div>
    </div>

        <div class="main-content">
            <div class="whole-regis-table col s6 m6 l6">
                <div class="row">
                    <h4 style="text-align: center; font-weight:800; padding-bottom: 5px;">
                        Data Table
                    </h4>
                <div ></div>
            <div>
        <div class="row">

        <table class="highlight centered" id="Datatable">
                            <tr>
                                <th>USER ID</th>
                                <th>FIRST NAME</th>
                                <th>LAST NAME</th>
                                <th>AGE</th>
                                <th>ROLE</th>
                                <th>PRIVILEGE</th>
                                <th>EMAIL</th>
                                <th>PASSWORD</th>
                                <th>ACTION</th>
                            </tr>

                            <?php if(!empty($adminUsers)) : ?>
                                <?php foreach($adminUsers as $index => $user) : ?>
                                    <tr>
                                        <td><?= $index + 1 ?>.</td>
                                        <td><?= $user['firstName'] ?></td>
                                        <td><?= $user['lastName'] ?></td>
                                        <td><?= $user['age'] ?></td>
                                        <td><?= $user['roleDescription'] ?></td>
                                        <td><?= $user['privilegeDescription'] ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td><?= $user['passWord'] ?></td>
                                        <td>
                                            <a class="waves-effect waves-light btn-small update-btn" onclick="updateFunc(<?= $user['userID'] ?>)">
                                                <i class="material-icons left">refresh</i>
                                                UPDATE
                                            </a>

                                            <a class="waves-effect waves-light btn-small delete-btn" onclick="deleteFunc(<?= $user['userID'] ?>)">
                                                <i class="material-icons left">remove_circle_outline</i>
                                                DELETE
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7">NO DATA FOUND</td>
                                </tr>
                            <?php endif ?>
                        </table>

    </div> </div> </div> </div> </div>
    
    <section id="cards">

        <h3>Dashboard</h3>

        <!-- USERS SECTION -->
        <div class="dashboard-section">

            <div class="section-header">
                <h5>User Roles</h5>
                <div class="divider-line"></div>
            </div>

                <div class="card-group">

                    <?php foreach($adminrolecard as $index => $role) : ?>

                    <div class="card">
                        <div class="card-content white-text">

                            <span class="card-title">
                                <?= $role['roleDescription'] ?>
                            </span>

                            <p>Total number of users in this role: <?= $role['total_users'] ?></p>

                        </div>
                    </div>

                    <?php endforeach; ?>

                </div>
            </div>

        <!-- PET STATUS SECTION -->
        <div class="dashboard-section">

            <div class="section-header">
                <h5>Pet Status Overview</h5>
                <div class="divider-line"></div>
            </div>

                <div class="card-group">

                    <?php foreach($adminpetstatuscard as $index => $role) : ?>

                    <div class="card">
                        <div class="card-content white-text">

                            <span class="card-title">
                                <h4><?= $role['pet_statusDescription'] ?></h4>
                            </span>

                            <p>Total number of pets in this status: <?= $role['total_pets'] ?></p>

                        </div>
                    </div>

                    <?php endforeach; ?>

                </div>
            </div>

        </section>

    <section id="chartSection">

        <div class="charts">
            <div>
                <canvas id="adminChart1"></canvas>
            </div>
        </div>

        <script>
            window.barData = {
                label: <?= json_encode($label); ?>,
                data: <?= json_encode($data); ?>
            }
        </script>

    </section>

    <footer id="contact">
        <h2>CONTACT US</h2>
        <p>Email: furryupinfo@gmail.com</p>
        <p>Phone: +63 912 345 6789</p>
        <p>Address: Interior Lot 92M From Leonard Wood Road, Cabinet Hill - Furry Up, Paranaque City</p>
        <p>© 2025 Furry Up | Paranaque City, Philippines</p>
    </footer>

    <script src="../scripts/Service.js"></script>
    <script src="../scripts/Chart.js"></script>
</body>
</body>
</html>