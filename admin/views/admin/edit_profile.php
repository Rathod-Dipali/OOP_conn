<?php

    include_once("../../../config/config.php");
    include_once("../layout/header.php");

    include_once('../../models/Fetch_data.php');
    $data = $fetch_data->auth_detail($_GET['id']);
    
?>


<section class="mt-3 pt-5">
    <div class="container">

        <div class="card border-dark">
            <div class="card-header border-dark text-dark">
                Edit Admin Data
            </div>
            <div class="card-body">
                <form id="update_profile_form" name="update_profile_form" method="post" enctype="multipart/form-data">

                    <input type="hidden" class="form-control" name="id" id="id" value="<?= $data['id'] ?>">

                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="<?= $data['name'] ?>">
                    </div>

                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= $data['email'] ?>">
                    </div>

                    <div class="form-group">
                        <label>Mobile <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="mobile" id="mobile" value="<?= $data['mobile'] ?>" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <img
                        src="<?= base_url('assets/upload/' . $data['image']) ?>"
                        onerror="this.onerror=null; this.src='<?= base_url('assets/upload/default.jpg') ?>';"
                        width="100"
                        alt="User Image">
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-dark mt-2" name="update_profile" id="update_profile">Update Profile</button>
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

    $(document).ready(function(){

        $.validator.addMethod("noOnlySpaces", function(value, element) {
        return this.optional(element) || /^(?!\s*$).+/.test(value);
        }, "Field cannot be empty or contain only spaces");
    
        $("#update_profile_form").validate({
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
        },
        });
    
        $("#update_profile").click(function() {

        if ($("#update_profile_form").valid()) {

            const form = document.getElementById("update_profile_form");
            const formData = new FormData(form);

            formData.append('update_admin', 'update_admin');

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

    });

</script>
