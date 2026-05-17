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

    <main class="admin-dashboard full-width">

        <div class="row top-stats-row">
            <div class="col s12 m6 l3">
                <div class="card-panel blue lighten-5 center-align stat-card">
                    <span class="stat-label">Total Users</span>
                    <h5><?= count($adminUsers) ?></h5>
                    <p class="muted-text">Active admin accounts</p>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card-panel blue lighten-5 center-align stat-card">
                    <span class="stat-label">Roles</span>
                    <h5><?= count($roles) ?></h5>
                    <p class="muted-text">Available role types</p>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card-panel blue lighten-5 center-align stat-card">
                    <span class="stat-label">Privileges</span>
                    <h5><?= count($privileges) ?></h5>
                    <p class="muted-text">Permission levels</p>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card-panel blue lighten-5 center-align stat-card">
                    <span class="stat-label">Status Types</span>
                    <h5><?= count($adminpetstatuscard) ?></h5>
                    <p class="muted-text">Pet status overview</p>
                </div>
            </div>
        </div>

        <div class="row dashboard-grid">
            <div class="col s12 l8">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Create or Update User</span>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="firstNameInput" type="text" class="validate round-input">
                                <label class="labelnames" for="firstNameInput">First Name</label>
                                <span class="field-error" id="firstNameError"></span>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="lastNameInput" type="text" class="validate round-input">
                                <label class="labelnames" for="lastNameInput">Last Name</label>
                                <span class="field-error" id="lastNameError"></span>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">calendar_today</i>
                                <input id="ageInput" type="text" class="validate round-input" maxlength="3">
                                <label class="labelnames" for="ageInput">Age</label>
                                <span class="field-error" id="ageError"></span>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">email</i>
                                <input id="emailInput" type="text" class="validate round-input">
                                <label class="labelnames" for="emailInput">Email</label>
                                <span class="field-error" id="emailError"></span>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix" id="togglePasswordIcon" onclick="togglePasswordVisibility()">visibility_off</i>
                                <input id="passwordInput" type="password" class="validate round-input">
                                <label class="labelnames" for="passwordInput">Password</label>
                                <span class="field-error" id="passwordError"></span>
                            </div>

                            <div class="input-field col s12 m6">
                                <select id="roleSelect">
                                    <option value="" disabled selected>Choose your option</option>
                                    <?php foreach($roles as $index => $role) : ?>
                                        <option value="<?= $role['roleID'] ?>"><?= $role['roleDescription'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label>User role</label>
                                <span class="field-error" id="roleError"></span>
                            </div>

                            <div class="input-field col s12 m6">
                                <select id="privilegeSelect">
                                    <option value="" disabled selected>Choose your option</option>
                                    <?php foreach($privileges as $index => $priv) : ?>
                                        <option value="<?= $priv['privilegeID'] ?>"><?= $priv['privilegeDescription'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label>User privilege</label>
                                <span class="field-error" id="privilegeError"></span>
                            </div>

                            <div class="col s12 center-align">
                                <a class="waves-effect waves-light btn add-btn" onclick="addAdminFunc()">
                                    <i class="material-icons left">add_circle</i>
                                    ADD OR UPDATE A USER
                                </a>
                            </div>

                            <div class="col s12">
                                <span class="field-error action-error" id="formActionError"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m8">
                        <div class="card dashboard-card">
                            <div class="card-content">
                                <span class="card-title">Data Table</span>
                                <div class="table-wrapper fixed-table">
                                    <table class="highlight centered responsive-table" id="Datatable">
                                        <thead>
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
                                        </thead>
                                        <tbody>
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
                                                    <td colspan="9">NO DATA FOUND</td>
                                                </tr>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 m4">
                        <div class="card dashboard-card chart-card">
                            <div class="card-content">
                                <span class="card-title">Status Overview</span>
                                <canvas id="statusChart" style="max-height:260px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12 l4">
                <div class="card dashboard-card calendar-card">
                    <div class="card-content">
                        <div class="calendar-header">
                            <div>
                                <span class="calendar-month"><?= date('F Y') ?></span>
                            </div>
                            <i class="material-icons">more_vert</i>
                        </div>
                        <div class="calendar-grid labels">
                            <div>SU</div>
                            <div>MO</div>
                            <div>TU</div>
                            <div>WE</div>
                            <div>TH</div>
                            <div>FR</div>
                            <div>SA</div>
                        </div>
                        <div class="calendar-grid days">
                            <div class="calendar-day muted">26</div>
                            <div class="calendar-day muted">27</div>
                            <div class="calendar-day muted">28</div>
                            <div class="calendar-day muted">29</div>
                            <div class="calendar-day muted">30</div>
                            <div class="calendar-day">1</div>
                            <div class="calendar-day">2</div>
                            <div class="calendar-day">3</div>
                            <div class="calendar-day">4</div>
                            <div class="calendar-day">5</div>
                            <div class="calendar-day">6</div>
                            <div class="calendar-day">7</div>
                            <div class="calendar-day">8</div>
                            <div class="calendar-day">9</div>
                            <div class="calendar-day">10</div>
                            <div class="calendar-day">11</div>
                            <div class="calendar-day">12</div>
                            <div class="calendar-day">13</div>
                            <div class="calendar-day">14</div>
                            <div class="calendar-day">15</div>
                            <div class="calendar-day">16</div>
                            <div class="calendar-day today"><?= date('j') ?></div>
                            <div class="calendar-day">18</div>
                            <div class="calendar-day">19</div>
                            <div class="calendar-day">20</div>
                            <div class="calendar-day">21</div>
                            <div class="calendar-day">22</div>
                            <div class="calendar-day">23</div>
                            <div class="calendar-day muted">24</div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </main>

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
</html>
