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

    $body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Signup</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                
                <table width="600" cellpadding="0" cellspacing="0" border="0" 
                       style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #8E9CE6; color: #ffffff; padding: 20px; text-align: center;">
                            <h2 style="margin: 0;">New User Signup</h2>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            
                            <table width="100%" cellpadding="10" cellspacing="0" border="0">
                                
                                <tr>
                                    <td style="font-weight: bold; width: 150px;">Name:</td>
                                    <td>' . htmlspecialchars($_POST["fName"] . " " . $_POST["lName"]) . '</td>
                                </tr>

                                <tr style="background-color: #f9f9f9;">
                                    <td style="font-weight: bold;">Email:</td>
                                    <td>' . htmlspecialchars($userEmail) . '</td>
                                </tr>

                                <tr>
                                    <td style="font-weight: bold;">Role:</td>
                                    <td>' . htmlspecialchars($_POST["roleID"]) . '</td>
                                </tr>

                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f1f1f1; text-align: center; padding: 15px; font-size: 12px; color: #666;">
                            This is an automated notification from your system.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
';

    $result = sendEmail(
        "$userEmail",
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
