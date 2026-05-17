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

    else if(
        isset($_POST["action"]) && $_POST["action"] === "createAdoption"
        && isset($_POST["fullName"], $_POST["address"], $_POST["email"], $_POST["phone"], $_POST["reason"], $_POST["petID"])
    ){
        $fullName = trim($_POST["fullName"]);
        $address = trim($_POST["address"]);
        $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
        $phoneNumber = preg_replace('/\D/', '', $_POST["phone"]);
        $contactNumber = '';
        $reason = trim($_POST["reason"]);
        $petID = (int) $_POST["petID"];
        $userID = isset($_SESSION["userID"]) ? (int) $_SESSION["userID"] : null;

        if (!$email) {
            http_response_code(400);
            echo "Invalid email address.";
            exit;
        }

        if (!$phoneNumber) {
            http_response_code(400);
            echo "Invalid phone number.";
            exit;
        }

        try {
            $database = new Database();
            $conn = $database->connectDB();

            $insertQuery = "INSERT INTO tbl_adoption_request \
                (adoption_request_status, userID, petID, fullName, address, email, phoneNumber, reason, createdAt, updatedAt) \
                VALUES (:status, :userID, :petID, :fullName, :address, :email, :phoneNumber, :reason, NOW(), NOW())";

            $statement = $conn->prepare($insertQuery);
            $statement->bindValue(":status", 1, PDO::PARAM_INT);
            if ($userID !== null) {
                $statement->bindValue(":userID", $userID, PDO::PARAM_INT);
            } else {
                $statement->bindValue(":userID", null, PDO::PARAM_NULL);
            }
            $statement->bindValue(":petID", $petID, PDO::PARAM_INT);
            $statement->bindValue(":fullName", $fullName, PDO::PARAM_STR);
            $statement->bindValue(":address", $address, PDO::PARAM_STR);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            $statement->bindValue(":phoneNumber", $phoneNumber, PDO::PARAM_STR);
            $statement->bindValue(":reason", $reason, PDO::PARAM_STR);
            $statement->execute();

            $petQuery = "SELECT name, age, petDescription, picture FROM tbl_pets WHERE petID = :petID LIMIT 1";
            $petStatement = $conn->prepare($petQuery);
            $petStatement->bindValue(":petID", $petID, PDO::PARAM_INT);
            $petStatement->execute();
            $pet = $petStatement->fetch(PDO::FETCH_ASSOC);

            $petName = $pet["name"] ?? 'Unknown';
            $petAge = $pet["age"] ?? 'Unknown';
            $petDescription = $pet["petDescription"] ?? 'No description available';
            $petPicture = $pet["picture"] ?? '';

            $emailBody = "<h3>New Adoption Request</h3>" .
                "<p><strong>Applicant:</strong> " . htmlspecialchars($fullName) . "</p>" .
                "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>" .
                "<p><strong>Phone Number:</strong> " . htmlspecialchars($phoneNumber) . "</p>" .
                "<p><strong>Address:</strong> " . htmlspecialchars($address) . "</p>" .
                "<p><strong>Reason:</strong> " . nl2br(htmlspecialchars($reason)) . "</p>" .
                "<h4>Pet Details</h4>" .
                "<p><strong>Pet Name:</strong> " . htmlspecialchars($petName) . "</p>" .
                "<p><strong>Age:</strong> " . htmlspecialchars($petAge) . " years old</p>" .
                "<p><strong>Description:</strong> " . htmlspecialchars($petDescription) . "</p>";

            if (!empty($petPicture)) {
                $emailBody .= "<p><strong>Picture:</strong> " . htmlspecialchars($petPicture) . "</p>";
            }

            $emailResult = sendEmail(
                "furryupinfo@gmail.com",
                "Furry Up Admin",
                "New Adoption Request from " . $fullName,
                $emailBody
            );

            if ($emailResult === true) {
                echo "Adoption request submitted successfully and notification email sent.";
            } else {
                error_log("Adoption email failed: " . $emailResult);
                echo "Adoption request saved, but notification email could not be sent right now.";
            }
        } catch (Exception $e) {
            error_log("Adoption request error: " . $e->getMessage());
            http_response_code(500);
            echo "Unable to process adoption request at the moment.";
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
