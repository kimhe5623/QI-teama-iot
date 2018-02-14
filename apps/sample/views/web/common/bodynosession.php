<body>
<div class="wrapper">
    <div class="sidebar" data-color="gray" data-image="assets/img/walking-sidebar2.jpg">

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="/" class="simple-text">
                    My Doctor A
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="/">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="notifications.html">
                        <i class="pe-7s-bell"></i>
                        <p>About us</p>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="Patientpage()">
                        <i class="pe-7s-user"></i>
                        <p>Patient List</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li id="signup" style="display:none;">
                            <a href="/chkemail">
                                <p>Sign Up</p>
                            </a>
                        </li>
                        <li id="signin" style="display:none;">
                            <a href="/signin">
                                <p>Sign In</p>
                            </a>
                        </li>

                        <li id="profile" style="display:none;">
                            <a href="/chkpwdprofile">
                                <p>Profile</p>
                            </a>
                        </li>
                        <li id="idcancellation" style="display:none;">
                            <a href="/idcancellation">
                                <p>ID Cancellation</p>
                            </a>
                        </li>
                        <li id="changepwd" style="display:none;">
                            <a href="/chkpwd">
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li id="signout" style="display:none;">
                            <a href="#" onclick="signout()">
                                <p>Sign Out</p>
                            </a>
                            <script>
                                function signout() {
                                    var data = {
                                        status : "sign-out"
                                    }
                                    $.ajax({
                                        type: "POST",
                                        url: "/signout",
                                        data: JSON.stringify(data),

                                        success: function (response) {

                                            var res = JSON.parse(response);

                                            if (res['status'] == true) {
                                                window.location = '/';
                                            }
                                            else
                                                alert(res['message']);
                                        }
                                    });
                                }
                            </script>
                        </li>
                    </ul>
                    <script type="text/javascript">
                        <?php
                        if(!(isset($_SESSION['status']))) {
                            $_SESSION['status'] = "not sign-in";
                            $_SESSION['dsn'] = "zero";
                        }

                        if ($_SESSION['status'] == "not sign-in") { ?>
                        document.getElementById('signup').style.display = "block";
                        document.getElementById('signin').style.display = "block";
                        document.getElementById("profile").style.display = "none";
                        document.getElementById("idcancellation").style.display = "none";
                        document.getElementById("changepwd").style.display = "none";
                        document.getElementById("signout").style.display = "none";
                        <?php }
                        else { ?>
                        document.getElementById('signup').style.display = "none";
                        document.getElementById('signin').style.display = "none";
                        document.getElementById("profile").style.display = "block";
                        document.getElementById("idcancellation").style.display = "block";
                        document.getElementById("changepwd").style.display = "block";
                        document.getElementById('signout').style.display = "block";
                        <?php } ?>
                    </script>
                    <script>
                        function Patientpage() {
                            if("<?echo $_SESSION['status'] ?>" == "not sign-in") {
                                alert("You need to sign in");
                            }
                            else {
                                window.location="/patientlist";
                            }
                        }
                    </script>
                </div>
            </div>
        </nav>