    var contactInput = document.getElementById("contact");

    contactInput.addEventListener("input", function(){
        validateNumFields(this);
    });
    
    function validateNumFields(element){
        element.value = element.value.replace(/[^0-9]/g, "");
    }

    $(document).ready(function(){
        $('#amadoTable').DataTable();
        $('select').formSelect();
        $('.datepicker').datepicker({
            maxDate: new Date(),
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
    
    function addFunc(){
        var firstName = document.getElementById("firstNameInput").value;
        var lastName = document.getElementById ("lastNameInput").value;
        var age = document.getElementById ("ageInput").value;
        var email = document.getElementById ("emailInput").value;
        var passWord = document.getElementById ("passwordInput").value;
        var select = document.getElementById("roleSelect").value;

        if(firstName.length < 5 || lastName.length < 5){
            alert("");
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
                Swal.fire({
                    title: "Success!",
                    text: "Successfully added a user named " + firstName + " " + lastName,
                    icon: "success",
                    confirmButtonText: "OK!"
                }).then((result) => {
                    if(result.isConfirmed){
                        location.reload(true);
                    }
                });
            },
            error: function (xhr){ // holds the error message and error code + holds the http response...
                alert(xhr.status + " : " + xhr.responseText); // response text returns the text "Cannot process..."
            }
       });
    }

    function addAdminFunc(){
        var firstName = document.getElementById("firstNameInput").value;
        var lastName = document.getElementById ("lastNameInput").value;
        var age = document.getElementById ("ageInput").value;
        var email = document.getElementById ("emailInput").value;
        var passWord = document.getElementById ("passwordInput").value;
        var select = document.getElementById("roleSelect").value;
        var privilege = document.getElementById("privilegeSelect").value;

        if(firstName.length < 5 || lastName.length < 5){
            alert("");
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
                Swal.fire({
                    title: "Success!",
                    text: "Successfully added a user named " + firstName + " " + lastName,
                    icon: "success",
                    confirmButtonText: "OK!"
                }).then((result) => {
                    if(result.isConfirmed){
                        location.reload(true);
                    }
                });
            },
            error: function (xhr){ // holds the error message and error code + holds the http response...
                alert(xhr.status + " : " + xhr.responseText); // response text returns the text "Cannot process..."
            }
       });
    }

    function updateFunc(userID){
        var firstName = document.getElementById("firstNameInput").value;
        var lastName = document.getElementById("lastNameInput").value;
        var age = document.getElementById ("ageInput").value;
        var email = document.getElementById("emailInput").value;
        var passWord = document.getElementById("passwordInput").value;

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
        var email = document.getElementById ("emailInput").value;
        var passWord = document.getElementById ("passwordInput").value;

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

