<?php
// login.php
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <title>Web Manager</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/asset/css/AdminLTE.min.css" />
    <link rel="stylesheet" type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/asset/css/custom-admin.css" />
    <link rel="stylesheet" type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/common.css" />
    <link rel="stylesheet" type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/reseller.css" />

    <!-- JS -->
    <script src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/jquery/jquery-2.0.3.min.js"></script>
    <script src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/js/sha1.js"></script>
    <script src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/js/jquery.mb.browser.js"></script>
</head>

<body class="login" id="page-login">
    <div class="content_top" id="mainform">
        <div class="login-main">
            <div id="header" class="header" style="display:block;"></div>

            <div class="bannerMessage">
                <div>We shall transition to a Single Sign-On (SSO) login system soon.</div>
            </div>

            <div class="centerpad">
                <div class="lform">
                    <div class="formhd">Welcome Member!</div>
                    <h2 class="auth_logo"><a href="javascript:void(0)">eDepoze&trade;</a></h2>

                    <p class="form-txt-error">
                        <span id="valLoginMsg"></span>&nbsp;
                    </p>

                    <div class="form-body-members">
                        <!-- Username Field -->
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" class="form-control" id="username" name="username" maxlength="255" placeholder="Insert Your Username" onkeyup="if (event.keyCode == 13) login();" />
                        </div>

                        <!-- Password Field -->
                        <div class="form-group pt11" id="passwordField" style="display: none;">
                            <label>Password:</label>
                            <input type="password" class="form-control" id="password" name="password" maxlength="255" onkeyup="if (event.keyCode == 13) login();" />
                            <input type="hidden" id="passauth" name="passauth" />
                        </div>

                        <!-- Timezone -->
                        <input type="hidden" id="timeZone" name="timeZone" />

                        <!-- Buttons -->
                        <div class="btn-block">
                            <button type="button" class="btn btn-log-next" id="loginButtonSubmit" style="display: none;" onclick="login();">Login</button>
                            <button type="button" class="btn btn-log-next" id="nextButtonSubmit" onclick="showPasswordField();">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer_data">
                <p class="copyright">Copyright &copy; 2025 eDepoze, LLC</p>
                <p class="poweredby"><img src="/EDEPOZE_PROJECT/sandbox.edepoze.com/logo.png" width="97" height="30" /></p>
            </div>
        </div>
    </div>

    <!-- JavaScript Login Logic -->
    <script type="text/javascript">
        function showPasswordField() {
            document.getElementById("passwordField").style.display = "block";
            const nextButton = document.getElementById("nextButtonSubmit");
            nextButton.innerText = "Login";
            nextButton.setAttribute("onclick", "login();");
        }

        function login() {
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();

            if (!username || !password) {
                document.getElementById("valLoginMsg").innerText = "Please fill in all required fields.";
                return;
            }

            const passauth = sha1(password);
            document.getElementById("passauth").value = passauth;
            document.getElementById("password").value = ""; // Clear original password
            document.getElementById("timeZone").value = new Date().getTimezoneOffset() * -1;

            fetch('/EDEPOZE_PROJECT/sandbox.edepoze.com/admin/login_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    username: username,
                    passauth: passauth,
                    timeZone: document.getElementById("timeZone").value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === true) {
                    window.location.href = data.redirect_url;
                } else {
                    document.getElementById("valLoginMsg").innerText = data.message || "Login failed. Please try again.";
                    document.getElementById("passwordField").style.display = "block";
                    document.getElementById("loginButtonSubmit").style.display = "inline-block";
                    document.getElementById("nextButtonSubmit").style.display = "none";
                }
            })
            .catch(error => {
                console.error("Login error:", error);
                document.getElementById("valLoginMsg").innerText = "An unexpected error occurred.";
            });
        }

        // Auto-adjust layout if URL path matches
        $(document).ready(function () {
            if (window.location.pathname === '/EDEPOZE_PROJECT/sandbox.edepoze.com/courts/exhibits/login') {
                $('.lform').css({ "height": "480px", "width": "460px" });
                $('#nextButtonSubmit').hide();
                $('#passwordField').show();
                $('#loginButtonSubmit').show();
            }
        });
    </script>
</body>
</html>
