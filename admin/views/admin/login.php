<?php include_once("../../../config/config.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/custome_style/style.css') ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

</head>

<body>

    <div class="container d-flex justify-content-center align-items-center">
        <?php if (isset($_SESSION['logout_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['logout_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['logout_message']); ?>
        <?php endif; ?>

        <div class="mt-5">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title p-1 text-center text-bg-dark text-light">Login</h5>
                    <div id="login_alert_container"></div>
                    <form id="login_form" name="login_form" method="post">
                        <div class="form-group">
                            <label>Email :</label>
                            <input type="email" class="form-control" name="login_email" id="login_email" required value="<?php echo isset($_COOKIE['admin_email']) ? $_COOKIE['admin_email'] : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Password :</label>
                            <input type="password" class="form-control" name="login_password" required id="login_password" value="<?php echo isset($_COOKIE['admin_password']) ? $_COOKIE['admin_password'] : '' ?>">
                        </div>
                        <div class="form-group">
                            <input type="checkbox" class="" name="remeber_me" id="remeber_me" <?php if (isset($_COOKIE['admin_password']) && isset($_COOKIE['admin_email'])) { ?> checked <?php } ?>>
                            <label>Remember me :</label>
                        </div>
                        <button type="button" class="btn mt-3 d-flex justify-content-center btn-outline-dark" id="login_admin" name="login_admin">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $.validator.addMethod("noOnlySpaces", function(value, element) {
                return this.optional(element) || /^(?!\s*$).+/.test(value);
            }, "Field cannot be empty or contain only spaces");

            $("#login_form").validate({
                rules: {
                    login_email: {
                        required: true,
                        noOnlySpaces: true,
                        email: true
                    },
                    login_password: {
                        required: true,
                        noOnlySpaces: true,
                        minlength: [8]
                    },
                },
                messages: {
                    login_email: {
                        required: "Please enter your email.",
                        email: "Please enter valid email address."
                    },
                    login_password: {
                        required: "Please enter password.",
                        minlength: "Password must be 8 charecter long."
                    },
                },
            });

            $("#login_admin").click(function() {

                if ($("#login_form").valid()) {

                    const form = document.getElementById("login_form");
                    const formData = new FormData(form);

                    formData.append('login_admin', 'login_admin');

                    $.ajax({
                        url: '<?php echo base_url('admin/controllers/Admin.php') ?>',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,

                        success: function(response) {
                            var res = JSON.parse(response);

                            if (res.status == '1') {

                                window.location.href = "<?php base_url('admin/views/dashboard.php') ?>";
                                return;

                            }
                            $("#login_alert_container").html("<div class='alert alert-danger alert-dismissible fade show' role='alert'>" + res.message + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button><div>");
                            setTimeout(function() {
                                $(".alert-danger").fadeOut();
                            }, 5000);

                        },
                        error: function(error) {
                            alert('Error submitting the form.');
                            console.log(error);
                        },
                    });
                }
            });

        });
    </script>

</body>

</html>
