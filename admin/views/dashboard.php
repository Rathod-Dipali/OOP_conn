<?php

    include_once("../../config/config.php");
    include_once("layout/header.php");

?>

<section class="mt-3 pt-5">
    <div class="container">
        <h2 class="text-center text-dark"><?php echo "Welcome ".$_SESSION['admin_user_name']; ?></h2>
    </div>
</section>

<?php include_once('layout/footer.php'); ?>
