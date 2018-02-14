<script type="text/javascript">
    <?php
    if(!(isset($_SESSION['status']))) {
        $_SESSION['status'] = "not sign-in";
        $_SESSION['dsn'] = "zero";
    }

    if ($_SESSION['status'] == "not sign-in") { ?>
    document.getElementById('signup').style.display = "block";
    document.getElementById('signin').style.display = "block";
    document.getElementById("changepwe").style.display = "none";
    document.getElementById("signout").style.display = "none";
    <?php }
    else { ?>
    document.getElementById('signup').style.display = "none";
    document.getElementById('signin').style.display = "none";
    document.getElementById("changepwd").style.display = "block";
    document.getElementById('signout').style.display = "block";
    <?php } ?>
</script>