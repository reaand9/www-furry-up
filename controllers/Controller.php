<?php
    session_start();
    require_once "../bl/UserManager.php";
    require_once "../bl/AdminManager.php";
    require_once "../model/database.php";
    require_once "../helper/send.php";

    $usermanager = new UserManager();
    $adminmanager = new AdminManager();

    if(
    isset($_POST["fName"], $_POST["lName"], $_POST["age"], 
          $_POST["email"], $_POST["passWord"], 
          $_POST["roleID"], $_POST["privilegeID"])
    ){

    $userEmail = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    if (!$userEmail) {
        http_response_code(400);
        echo "Invalid email address.";
        exit;
    }

    $created = $usermanager->addUserFunc(
        $_POST["roleID"],
        $_POST["privilegeID"], 
        $_POST["fName"],
        $_POST["lName"],
        $_POST["age"],
        $userEmail,
        $_POST["passWord"]
    );

    if (!$created) {
        http_response_code(500);
        echo "Unable to add user to the database.";
        exit;
    }

    $body = "
        <h3>New Signup</h3>
        <p><strong>Name:</strong> " . htmlspecialchars($_POST["fName"] . " " . $_POST["lName"]) . "</p>
        <p><strong>Email:</strong> " . htmlspecialchars($userEmail) . "</p>
        <p><strong>Role ID:</strong> " . htmlspecialchars($_POST["roleID"]) . "</p>
    ";

    $result = sendEmail(
        "furryupinfo@gmail.com",
        "Admin",
        "New user signed up",
        $body
    );

    if ($result === true) {
        echo "User added and email sent successfully.";
    } else {
        error_log("Signup email failed for {$userEmail}: {$result}");
        echo "User added successfully. Notification email could not be sent right now.";
    }

        exit;
    
    }

    else if(isset($_POST["action"]) && $_POST["action"] == "update"){
    $adminmanager->updateUserFunc(
        $_POST["uID"],   
        $_POST["fName"],
        $_POST["lName"],
        $_POST["age"],
        $_POST["email"],
        $_POST["passWord"]
    );
    exit;
    }

    else if(isset($_POST["action"]) && $_POST["action"] == "delete"){
    $adminmanager->deleteUserFunc($_POST["uID"]);
    exit;
    }

        else if(isset($_POST["email"], $_POST["passWord"])){
            $usermanager -> signinUserFunc($_POST["email"], $_POST["passWord"]);
        }
    
?>
