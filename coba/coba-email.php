<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
    input[type="submit"]:disabled {
        background-color: red;
    }
    </style>
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-4 offset-md-4" style="background-color: lightblue;">
                <form action="page2.php" id="myForm1" class="needs-validation" novalidate>
                    <h1 class="text-center">Registration</h1>
                    <hr>
                    <div class="form-group">
                        First Name<input name="myInput" id="fisrtNameId" type="text" class="form-control"
                            pattern="^[a-z]{2,15}$" required autofocus>
                        <div class="valid-feedback">Valid</div>
                        <div class="invalid-feedback">a to z only (2 to 15 long)</div>
                    </div>
                    <div class="form-group">
                        Last Name<input name="myInput" id="lastNameId" type="text" class="form-control"
                            pattern="^[a-z]{2,15}$" required>
                        <div class="valid-feedback">Valid</div>
                        <div class="invalid-feedback">a to z only (2 to 15 long)</div>
                    </div>
                    <div class="form-group">
                        E-mail<input type="email" name="myInput" id="emailId" class="form-control" is-email required>
                        <div class="valid-feedback">Valid</div>
                        <div class="invalid-feedback">Not a valid email address</div>
                    </div>
                    <div class="form-group">
                        Password<input type="text" id="pwdId" class="form-control" pattern="^[a-z]{2,6}$" required>
                        <div class="valid-feedback">Valid</div>
                        <div class="invalid-feedback">a to z only (2 to 6 long)</div>
                    </div>
                    <div class="form-group">
                        Confirm Password<input type="text" id="cPwdId" class="form-control myCpwdClass"
                            pattern="^[a-z]{2,6}$" required>
                        <div id="cPwdValid" class="valid-feedback">Passwords Match</div>
                        <div id="cPwdInvalid" class="invalid-feedback">a to z only (2 to 6 long)</div>
                    </div>
                    <div class="form-group">
                        Description<textarea form="myForm1" name="myInput" id="descId" type="text" class="form-control"
                            required></textarea>
                        <div class="valid-feedback">Valid</div>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="agreeId" class="custom-control-input form-control" required>
                            <label for="agreeId" id="agreeLabelId" class="custom-control-label">Agree to terms <a
                                    href="https://www.youtube.com/watch?v=5_nWGG_TFDM" target="_blank"> (terms &
                                    conditions)</a></label>
                            <div id="agreeValid" class="valid-feedback">Valid</div>
                            <div id="agreeInvalid" class="invalid-feedback">Needs to be checked</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button id="submitBtn" type="submit" class="btn btn-secondary" disabled>Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // ----------- Set all elements as INVALID --------------
        var myInputElements = document.querySelectorAll(".form-control");
        var i;
        for (i = 0; i < myInputElements.length; i++) {
            myInputElements[i].classList.add('is-invalid');
            myInputElements[i].classList.remove('is-valid');
        }
        // ------------ Check passwords similarity --------------
        $('#pwdId, #cPwdId').on('keyup', function() {
            if ($('#pwdId').val() != '' && $('#cPwdId').val() != '' && $('#pwdId').val() == $('#cPwdId')
                .val()) {
                $('#cPwdValid').show();
                $('#cPwdInvalid').hide();
                $('#cPwdInvalid').html('Passwords Match').css('color', 'green');
                $('.myCpwdClass').addClass('is-valid');
                $('.myCpwdClass').removeClass('is-invalid');
                $("#submitBtn").attr("disabled", false);
                $('#submitBtn').addClass('btn-primary').removeClass('btn-secondary');
                for (i = 0; i < myInputElements.length; i++) {
                    var myElement = document.getElementById(myInputElements[i].id);
                    if (myElement.classList.contains('is-invalid')) {
                        $("#submitBtn").attr("disabled", true);
                        $('#submitBtn').addClass('btn-secondary').removeClass('btn-primary');
                        break;
                    }
                }
            } else {
                $('#cPwdValid').hide();
                $('#cPwdInvalid').show();
                $('#cPwdInvalid').html('Not Matching').css('color', 'red');
                $('.myCpwdClass').removeClass('is-valid');
                $('.myCpwdClass').addClass('is-invalid');
                $("#submitBtn").attr("disabled", true);
                $('#submitBtn').addClass('btn-secondary').removeClass('btn-primary');
            }
        });
        // ----------------- Validate on submit -----------------
        let currForm1 = document.getElementById('myForm1');
        currForm1.addEventListener('submit', function(event) {
            if (currForm1.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                $("#submitBtn").attr("disabled", false);
                $('#submitBtn').addClass('btn-primary').removeClass('btn-secondary');
                currForm1.classList.add('was-validated');
            }
        }, false);
        // ----------------- Validate on input -----------------
        currForm1.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener(('input'), () => {
                if (input.checkValidity()) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
                var is_valid = $('.form-control').length === $('.form-control.is-valid').length;
                // $("#submitBtn").attr("disabled", !is_valid);
                if (is_valid) {
                    $("#submitBtn").attr("disabled", false);
                    $('#submitBtn').addClass('btn-primary').removeClass('btn-secondary');
                } else {
                    $("#submitBtn").attr("disabled", true);
                    $('#submitBtn').addClass('btn-secondary').removeClass('btn-primary');
                }
            });
        });
        // ------------------------------------------------------
    });
    </script>
</body>

</html>