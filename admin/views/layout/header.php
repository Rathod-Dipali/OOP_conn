<?php

    if (!isset($_SESSION['admin_user_name']) && !isset($_SESSION['admin_user_id'])) {
        redirect('','admin/views/admin/login.php');
    }    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Header</title>

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/custome_style/style.css') ?>">
    <script src="<?= base_url('assets/js/bootstrap.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

</head>

<body>

    <nav class="navbar bg-dark navbar-expand-lg">
        <div class="container-fluid">
            <a href="<?= base_url('admin/views/dashboard.php') ?>" class="navbar-brand light_color">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link light_color active" aria-current="page" href="<?= base_url('admin/views/dashboard.php') ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link light_color" aria-current="page" href="<?= base_url('admin/views/admin/admins.php') ?>">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link light_color" aria-current="page" href="<?= base_url('admin/views/categorys/categorys.php') ?>">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link light_color" aria-current="page" href="<?= base_url('admin/views/sub_categorys/sub_categorys.php') ?>">Subcategory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link light_color" aria-current="page" href="<?= base_url('admin/views/products/products.php') ?>">Product</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="user_image"
                                src="<?= base_url('assets/upload/'.$_SESSION['user_image_name']) ?>"
                                onerror="this.onerror=null; this.src='<?= base_url('assets/upload/default.jpg') ?>';"
                                width="100"
                                height="100"
                                alt="User Image">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('admin/views/admin/add_admin.php') ?>">Add Admin</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('admin/views/admin/edit_profile.php?id='.$_SESSION['admin_user_id']) ?>">Edit Profile</a></li>
                            <li><a class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#change_password_modal">Change password</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="btn dropdown-item" id="Logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="alert_container"></div>

    <?php if (isset($_SESSION['login_success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['login_success_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['login_success_message']); ?>
    <?php endif; ?>

    <!-- Change-Password Modal -->
    <div class="modal fade" id="change_password_modal" tabindex="-1" aria-labelledby="change_password_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="change_password_modal_heading">Change Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="change_password_error"></div>

                <div class="modal-body">
                    <form id="change_password_form" name="change_password_form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Old Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="old_password" id="old_password">
                            <span id="old_pass_error"></span>
                        </div>
                        <div class="form-group">
                            <label>New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="new_password" id="new_password">
                            <span id="new_pass_error"></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                            <span id="conf_pass_error"></span>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-dark mt-2" name="change_password" id="change_password">Change Password</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {            

            /* Code for Change-Password */
            $("#change_password_form").validate({
                rules: {
                    old_password: {
                        required: true,
                        noOnlySpaces: true
                    },
                    new_password: {
                        required: true,
                        noOnlySpaces: true,
                        minlength: [8]
                    },
                    confirm_password: {
                        required: true,
                        noOnlySpaces: true,
                        equalTo: "[name='new_password']"
                    },
                },
                messages: {
                    old_password: {
                        required: "Please enter old password."
                    },
                    new_password: {
                        required: "Please enter new password.",
                        minlength: "Password must be 8 charecter long."
                    },
                    confirm_password: {
                        required: "Please enter confrim new password.",
                        equalTo: "Passwords does not match."

                    },
                },
            });

            $("#change_password").click(function() {
                
                if ($("#change_password_form").valid()) {

                    const form = document.getElementById("change_password_form");
                    const formData = new FormData(form);

                    formData.append('change_password', 'change_password');

                    $.ajax({
                        url: '<?php echo base_url('admin/controllers/Admin.php') ?>',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,

                        success: function(response) {
                            var res = JSON.parse(response);
                            console.log(res);
                            
                            if (res.status == '1') {

                                $('#change_password_modal').modal('hide');

                                $("#alert_container").html("<div class='alert alert-success alert-dismissible fade show' role='alert'>" + res.message + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button><div>");
                                setTimeout(function() {
                                    $(".alert-success").fadeOut();
                                }, 5000);
                                
                                return;
                                
                            }
                            $("#change_password_error").html("<div class='alert alert-danger alert-dismissible fade show' role='alert'>" + res.message + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button><div>");
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

            /* Logout */
            $("#Logout").click(function() {
                
                $.ajax({
                        url: '<?php echo base_url('admin/controllers/Admin.php') ?>',
                        method: 'POST',
                        data: {
                            'admin_logout':'admin_logout'
                        },

                        success: function(response) {
                            var res = JSON.parse(response);
                            
                            if (res.status == '1') {

                                window.location.href = "<?php base_url('admin/views/admin/login.php') ?>";
                                return;
                                
                            }

                        },
                        error: function(error) {
                            alert('Error submitting the form.');
                            console.log(error);
                        },
                    });

            });

        });
    </script>
