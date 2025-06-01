<?php

    include_once("../../../config/config.php");
    include_once("../layout/header.php");

    include_once('../../models/Fetch_data.php');
    $data = $fetch_data->all_admin_data();

?>

<section class="mt-3 pt-5">
    <div class="container">

        <div class="card border-dark">
            <div class="card-header border-dark text-dark">
                Admins
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>User Image</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>

                    </thead>
                    <?php $no = 1;
                    if ($data) {
                        foreach ($data as $row) {
                    ?>
                            <tbody>
                                <tr>
                                    <th><?= $no ?></th>
                                    <th><?= $row['name'] ?></th>
                                    <th><?= $row['email'] ?></th>
                                    <th><?= $row['mobile'] ?></th>
                                    <th>
                                        <img class="user_image"
                                            src="<?= base_url('assets/upload/' . $row['image']) ?>"
                                            onerror="this.onerror=null; this.src='<?= base_url('assets/upload/default.jpg') ?>';"
                                            width="100"
                                            height="100"
                                            alt="User Image">
                                    </th>
                                    <td align="center"> <a href="<?= base_url('admin/views/admin/edit_profile.php?id=' . $row['id']) ?>"><button class="btn btn-outline-info">Edit</button></a></td>
                                    <td align="center"><button class="btn btn-outline-danger" id="delete_admin" name="delete_admin" data-id="<?= $row['id'] ?>">Delete</button></td>
                                </tr>
                            </tbody>
                        <?php $no++;
                        }
                    } else { ?>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center">Data not Found</td>
                            </tr>
                        </tbody>
                    <?php } ?>

                </table>
            </div>
        </div>

    </div>
</section>

<?php include_once('../layout/footer.php'); ?>

<script>
    $(document).ready(function() {

        $("#delete_admin").click(function() {

            var id = $(this).data('id');
            swal.fire({
                title: "Are you sure you want to delete this?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url('admin/controllers/Admin.php') ?>',
                        method: 'POST',
                        data: {
                            'id': id,
                            'admin_delete': 'admin_delete'
                        },

                        success: function(response) {
                            var res = JSON.parse(response);

                            if (res.status == '1') {

                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Admin has been deleted.",
                                    icon: "success"
                                }).then(() => {
                                    location.reload();
                                });

                            }

                        },
                        error: function(error) {
                            alert('Error submitting the form.');
                            console.log(error);
                        },
                    });

                }
            });

        });

    });

</script>
