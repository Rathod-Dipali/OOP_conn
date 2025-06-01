<?php

    include_once("../../../config/config.php");
    include_once("../layout/header.php");

?>


<section class="mt-3 pt-5">
    <div class="container">

        <div class="card border-dark">
            <div class="card-header border-dark text-dark">
                Add Admin
            </div>
            <div class="card-body">
                <form id="add_admin_form" name="add_admin_form" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>

                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>

                    <div class="form-group">
                        <label>Mobile <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="mobile" id="mobile" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <img src="<?= base_url('assets/upload/default.jpg') ?>" class="mt-2" alt="Image not choosen" width="100" id="img">
                    </div>

                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>

                    <div class="form-group">
                        <label>Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="a_confirm_password" id="a_confirm_password">
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-dark mt-2" name="insert_admin" id="insert_admin">Add Admin</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</section>

<?php include_once('../layout/footer.php'); ?>

<script>
    var file = document.getElementById("image");
    var img = document.getElementById("img");
    file.addEventListener("change", (e) => {
        img.src = URL.createObjectURL(e.target.files[0])
    });

    $.validator.addMethod("noOnlySpaces", function(value, element) {
        return this.optional(element) || /^(?!\s*$).+/.test(value);
    }, "Field cannot be empty or contain only spaces");

    $("#add_admin_form").validate({
        rules: {
            name: {
                required: true,
                noOnlySpaces: true
            },
            email: {
                required: true,
                noOnlySpaces: true,
                email: true
            },
            mobile: {
                required: true,
                noOnlySpaces: true,
                digits: true,
                rangelength: [10, 10]
            },
            password: {
                required: true,
                noOnlySpaces: true,
                minlength: [8]
            },
            a_confirm_password: {
                required: true,
                noOnlySpaces: true,
                equalTo: "[name='password']"
            },
        },
        messages: {
            name: {
                required: "Please enter your name."
            },
            email: {
                required: "Please enter your email.",
                email: "Please enter valid email address."
            },
            mobile: {
                required: "Please enter your phonenumber.",
                digits: "Please enter a valid phonenumber.",
                rangelength: "Please enter valid phonenumber."
            },
            password: {
                required: "Please enter password.",
                minlength: "Password must be 8 charecter long."
            },
            a_confirm_password: {
                required: "Please enter password.",
                equalTo: "Passwords does not match."

            },
        },
    });

    $("#insert_admin").click(function() {

        if ($("#add_admin_form").valid()) {

            const form = document.getElementById("add_admin_form");
            const formData = new FormData(form);

            formData.append('insert_admin', 'insert_admin');

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

                        $("#alert_container").html("<div class='alert alert-success alert-dismissible fade show' role='alert'>" + res.message + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button><div>");
                        setTimeout(function() {
                            $(".alert-success").fadeOut();
                        }, 5000);

                        return;

                    }
                    
                    $("#alert_container").html("<div class='alert alert-danger alert-dismissible fade show' role='alert'>" + res.message + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button><div>");
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
</script>
