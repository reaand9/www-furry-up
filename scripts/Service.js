    var ageInput = document.getElementById("ageInput");

    if(ageInput){
        ageInput.addEventListener("input", function(){
            validateNumFields(this);
        });
    }
    
    function validateNumFields(element){
        element.value = element.value.replace(/[^0-9]/g, "");
    }

    $(document).ready(function(){
        if($.fn.DataTable && $('#Datatable').length){
            $('#Datatable').DataTable();
        }

        $('select').formSelect();
        $('.datepicker').datepicker({
            maxDate: new Date(),
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        initializeValidationEvents();
    });

    function showFieldError(errorId, message){
        var errorElement = document.getElementById(errorId);

        if(errorElement){
            errorElement.textContent = message;
        }
    }

    function clearFieldError(errorId){
        var errorElement = document.getElementById(errorId);

        if(errorElement){
            errorElement.textContent = "";
        }
    }

    function clearAllFieldErrors(){
        var errorElements = document.querySelectorAll(".field-error");

        errorElements.forEach(function(errorElement){
            errorElement.textContent = "";
        });
    }

    function getTrimmedValue(inputId){
        var element = document.getElementById(inputId);

        if(!element){
            return "";
        }

        return element.value.trim();
    }

    function isValidGmail(email){
        var gmailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
        return gmailPattern.test(email);
    }

    function validateRequiredField(value, errorId){
        if(value === ""){
            showFieldError(errorId, "This field cannot be left blank");
            return false;
        }

        clearFieldError(errorId);
        return true;
    }

    function validateGmailField(email, errorId){
        if(email === ""){
            showFieldError(errorId, "This field cannot be left blank");
            return false;
        }

        if(!isValidGmail(email)){
            showFieldError(errorId, "Please enter a valid @gmail.com address");
            return false;
        }

        clearFieldError(errorId);
        return true;
    }

    function validateSelectField(value, errorId){
        if(value === "" || value === null){
            showFieldError(errorId, "Please choose one option");
            return false;
        }

        clearFieldError(errorId);
        return true;
    }

    function showActionError(message){
        showFieldError("formActionError", message);
    }

    function clearActionError(){
        clearFieldError("formActionError");
    }

    function togglePasswordVisibility(){
        var passwordInput = document.getElementById("passwordInput");
        var togglePasswordIcon = document.getElementById("togglePasswordIcon");

        if(passwordInput && togglePasswordIcon){
            if(passwordInput.type === "password"){
                passwordInput.type = "text";
                togglePasswordIcon.textContent = "visibility";
            }
            else{
                passwordInput.type = "password";
                togglePasswordIcon.textContent = "visibility_off";
            }
        }
    }

    function initializeValidationEvents(){
        var fieldMaps = [
            { inputId: "firstNameInput", errorId: "firstNameError", eventName: "input" },
            { inputId: "lastNameInput", errorId: "lastNameError", eventName: "input" },
            { inputId: "ageInput", errorId: "ageError", eventName: "input" },
            { inputId: "emailInput", errorId: "emailError", eventName: "input" },
            { inputId: "passwordInput", errorId: "passwordError", eventName: "input" },
            { inputId: "roleSelect", errorId: "roleError", eventName: "change" },
            { inputId: "privilegeSelect", errorId: "privilegeError", eventName: "change" }
        ];

        fieldMaps.forEach(function(fieldMap){
            var element = document.getElementById(fieldMap.inputId);

            if(element){
                element.addEventListener(fieldMap.eventName, function(){
                    clearFieldError(fieldMap.errorId);
                    clearActionError();
                });
            }
        });
    }

    function showCreateUserAlert(firstName, lastName, returnedData) {
        var message = returnedData || ("Successfully added a user named " + firstName + " " + lastName);
        var title = "Success!";
        var html = message;

        if (message.toLowerCase().indexOf("notification email could not be sent") !== -1) {
            title = "User Added";
            html = "Successfully added a user named <b>" + firstName + " " + lastName + "</b>.<br><br>Admin email notification could not be sent right now.";
        }
        else if (message.toLowerCase().indexOf("email sent successfully") !== -1) {
            html = "Successfully added a user named <b>" + firstName + " " + lastName + "</b>.";
        }

        Swal.fire({
            title: title,
            html: html,
            icon: "success",
            confirmButtonText: "OK"
        }).then((result) => {
            if(result.isConfirmed){
                location.reload(true);
            }
        });
    }

    function showCreateUserError(xhr) {
        Swal.fire({
            icon: "error",
            title: xhr.status === 400 ? "Invalid Input" : "Unable to Add User",
            text: xhr.responseText || "Something went wrong while adding the user."
        });
    }

    function validateSigninFields(email, passWord){
        var isValid = true;

        if(!validateGmailField(email, "emailError")){
            isValid = false;
        }

        if(!validateRequiredField(passWord, "passwordError")){
            isValid = false;
        }

        return isValid;
    }

    function validateSignupFields(firstName, lastName, age, email, passWord, select){
        var isValid = true;

        if(!validateRequiredField(firstName, "firstNameError")){
            isValid = false;
        }

        if(!validateRequiredField(lastName, "lastNameError")){
            isValid = false;
        }

        if(!validateRequiredField(age, "ageError")){
            isValid = false;
        }

        if(!validateGmailField(email, "emailError")){
            isValid = false;
        }

        if(!validateRequiredField(passWord, "passwordError")){
            isValid = false;
        }

        if(!validateSelectField(select, "roleError")){
            isValid = false;
        }

        return isValid;
    }

    function validateAdminFields(firstName, lastName, age, email, passWord, select, privilege){
        var isValid = validateSignupFields(firstName, lastName, age, email, passWord, select);

        if(!validateSelectField(privilege, "privilegeError")){
            isValid = false;
        }

        return isValid;
    }

    function validateUpdateFields(userID, firstName, lastName, age, email, passWord){
        var isValid = true;

        clearActionError();

        if(!userID || isNaN(userID)){
            showActionError("Please select a valid user first");
            isValid = false;
        }

        if(!validateRequiredField(firstName, "firstNameError")){
            isValid = false;
        }

        if(!validateRequiredField(lastName, "lastNameError")){
            isValid = false;
        }

        if(!validateRequiredField(age, "ageError")){
            isValid = false;
        }

        if(!validateGmailField(email, "emailError")){
            isValid = false;
        }

        if(!validateRequiredField(passWord, "passwordError")){
            isValid = false;
        }

        return isValid;
    }
    
    function addFunc(){
        clearAllFieldErrors();

        var firstName = getTrimmedValue("firstNameInput");
        var lastName = getTrimmedValue("lastNameInput");
        var age = getTrimmedValue("ageInput");
        var email = getTrimmedValue("emailInput").toLowerCase();
        var passWord = getTrimmedValue("passwordInput");
        var select = document.getElementById("roleSelect").value;

        if(!validateSignupFields(firstName, lastName, age, email, passWord, select)){
            return;
        }

       $.ajax({
            url: "../controllers/Controller.php", 
            type: "POST",
            data: {
                fName:firstName, 
                lName:lastName,
                age: age,
                email:email,
                privilegeID: 2,
                passWord:passWord,
                roleID:select,
            },
            success: function(returnedData){
                showCreateUserAlert(firstName, lastName, returnedData);
            },
            error: function (xhr){
                showCreateUserError(xhr);
            }
       });
    }

    function addAdminFunc(){
        clearAllFieldErrors();
        clearActionError();

        var firstName = getTrimmedValue("firstNameInput");
        var lastName = getTrimmedValue("lastNameInput");
        var age = getTrimmedValue("ageInput");
        var email = getTrimmedValue("emailInput").toLowerCase();
        var passWord = getTrimmedValue("passwordInput");
        var select = document.getElementById("roleSelect").value;
        var privilege = document.getElementById("privilegeSelect").value;

        if(!validateAdminFields(firstName, lastName, age, email, passWord, select, privilege)){
            return;
        }

       $.ajax({
            url: "../controllers/Controller.php", 
            type: "POST",
            data: {
                fName:firstName, 
                lName:lastName,
                age: age,
                email:email,
                passWord:passWord,
                roleID:select,
                privilegeID: privilege
            },
            success: function(returnedData){
                showCreateUserAlert(firstName, lastName, returnedData);
            },
            error: function (xhr){
                showCreateUserError(xhr);
            }
       });
    }

    function updateFunc(userID){
        clearAllFieldErrors();

        var firstName = getTrimmedValue("firstNameInput");
        var lastName = getTrimmedValue("lastNameInput");
        var age = getTrimmedValue("ageInput");
        var email = getTrimmedValue("emailInput").toLowerCase();
        var passWord = getTrimmedValue("passwordInput");

        if(!validateUpdateFields(userID, firstName, lastName, age, email, passWord)){
            return;
        }

    $.ajax({
        url: "../controllers/Controller.php",
        type: "POST",
        data: {
            action: "update",
            uID: userID,
            fName: firstName,
            lName: lastName,
            age: age,
            email: email,
            passWord: passWord
        },
        success: function(){
            Swal.fire("Updated!", "User updated successfully", "success")
            .then(() => location.reload());
            }
        });
    }
    
    function deleteFunc(userID){
        clearActionError();

        if(!userID || isNaN(userID)){
            showActionError("Please select a valid user first");
            return;
        }

        $.ajax({
            url: "../controllers/Controller.php",
            type: "POST",
            data: {
                action: "delete",
                uID: userID
            },
            success: function(){
                Swal.fire("Deleted!", "User deleted successfully", "success")
                .then(() => location.reload());
        }
    });
    }

    function redirectFunc(redirectID) {
        if (redirectID == 1){
            window.location.href = "../views/SignInPage.php";
        }else if (redirectID == 2){
            window.location.href = "../views/DashboardPage.php";
        }else if (redirectID == 3){
            window.location.href = "../views/SignUpPage.php";
        }else if (redirectID == 4){
            window.location.href = "../views/AdminPage.php"
        }
    }

    function signinFunc(){
        clearAllFieldErrors();

        var email = getTrimmedValue("emailInput").toLowerCase();
        var passWord = getTrimmedValue("passwordInput");

        if(!validateSigninFields(email, passWord)){
            return;
        }

            $.ajax({
                url: "../controllers/Controller.php",
                type: "POST",
                data: {
                email:email,
                passWord:passWord,
            },
            success: function(response) {
            if (response == 1) {
            // ADMIN
                Swal.fire("Success!", "Admin login successful!", "success")
                    .then(() => redirectFunc(4)); // Admin Page
                }
                else if (response == 2) {
            // USER
                Swal.fire("Success!", "Login successful!", "success")
                .then(() => redirectFunc(2)); // Dashboard
                }
                else {
                    Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Invalid credentials!"
                }); 
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "ERm...",
                text: xhr.responseText,
            });
             }
        });
    }

    function filterPets(speciesID){
        $.ajax({
            url: "../controllers/Controller.php",
            type: "POST",
            data: { 
                speciesID: speciesID 
            },
            success: function(response){
                document.querySelector(".pet-container").innerHTML = response;
            }
        });
    }

    $(document).ready(function(){
    $('select').formSelect();
    });

