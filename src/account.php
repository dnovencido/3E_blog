<?php
    include "session.php";
?>
<?php include "layouts/_header.php"; ?>
         <header>
            <?php include "layouts/_navigation.php" ; ?>
         </header>
         <section class="container">
            <h1>Hello <?= $_SESSION['name'] ?></h1>
         </section>
<?php include "layouts/_footer.php"; ?>