<?php
    /**
        * --------------------------------------------- *
        * @author: Jerson A. Martínez M. (Side Master)  *
        * --------------------------------------------- *
    */

    @session_start();
    if (@$_SESSION['login'] != 1){
        header("Location: ../../");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include ("build/head.php"); ?>
    </head>

    <body class="flat-blue">
        <div class="app-container">
            <div class="row content-container">
                <?php include ("build/tape.php"); ?>
                
                <?php include ("build/menu_left.php"); ?>
                
                <?php include ("build/view_users.php"); ?>
            </div>

            <?php include ("build/footer.php"); ?>
        </div>
        <?php include ("build/scripts.php"); ?>
        <script type="text/javascript">
            setTimeout(function(){
                $("navbar-nav .active").removeClass("active");
                $(".two__item").addClass("active");
            }, 100);
        </script>
    </body>
</html>
