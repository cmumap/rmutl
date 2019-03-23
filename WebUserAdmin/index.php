<link rel="icon" href="..\img\icon.png">
<?php include "security.php"?>
<?php
session_start();

if(isset($_SESSION['administrator'])!="")
{
	header("Location: ../admin-map.php");
} elseif(isset($_SESSION['user'])!="") {
  header("Location: ../user-map.php");
}

include_once 'Connections/dbconnect.php';

//check if form is submitted
if (isset($_POST['login'])) {

  $email = mysqli_real_escape_string($con, $_POST['email']);
  $name = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$result = mysqli_query($con, "SELECT * FROM highadmin WHERE email = '" . $email. "'or name = '" . $name. "' and password = '" . md5($password) . "'");
  $row = mysqli_fetch_array($result);
	if ($row['LoginStatus']=='admin') {
    $_SESSION['administrator'] = 'admin';
    $_SESSION['user'] = 'user';
		$_SESSION['username'] = $row['name'];
		$_SESSION['userpass'] = $row['password'];
		header("Location: ../admin-map.php");
  } elseif($row['LoginStatus']=='user'){
    $_SESSION['user'] = 'user';
		$_SESSION['username'] = $row['name'];
		$_SESSION['userpass'] = $row['password'];
		header("Location: ../user-map.php");
  } else {
		$errormsg = "Incorrect Email or Password!!!";
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WebUser LOGIN</title>

<link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
<link rel="stylesheet" href="css/index.css">

</head>
<body>
<body>
<body class="align">
	<div class="site__container">
    <div class="grid__container">
    	<p class="text--style">
        <font color="#FFFFFF" size="+2"><b>WebUser</b></font>
        <br><b><font color="#999999" size="+3">CMU-GOOGLEMAP</font></b>
        <br>
        <br>
        </p>
      	<form action="index.php" method="post" name="checkForm" id="checkForm" class="form form--login">
        <div class="form__field">
        <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
        <input id="login__username" type="text" class="form__input" placeholder="User or E-mail" name="email" required autocomplete="off"/>
        </div>
        <div class="form__field">
        <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
        <input id="login__password" type="password" class="form__input" placeholder="Password" name="password" required autocomplete="off"/>
        </div>
        <div class="form__field">
        <input type="submit" name="login" value="log in">&nbsp; &nbsp; &nbsp; <input type="submit" value="Register" onclick="regis()">
        </div>
        <?php if (isset($errormsg)) { echo $errormsg; } ?>


                    <!-- <script>
              window.fbAsyncInit = function() {
                FB.init({
                  appId      : '257640861786221',
                  xfbml      : true,
                  version    : 'v3.2'
                });
                FB.AppEvents.logPageView();
              };

              (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));
            </script>
            <script>  
                FB.AppEvents.logPageView();

              };
              
              
              FB.getLoginStatus(function(response) {
                    statusChangeCallback(response);
                }); 

                            {
                status: 'connected',
                authResponse: {
                    accessToken: '...',
                    expiresIn:'...',
                    signedRequest:'...',
                    userID:'...'
                }
            } 

                      <fb:login-button 
            scope="public_profile,email"
            onlogin="checkLoginState();">
          </fb:login-button>

            </script>

<div id="fb-root"></div> -->

<!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v3.2&appId=257640861786221&autoLogAppEvents=1"></script> -->


<!-- <div class="fb-login-button" data-width="320" data-size="large" data-button-type="continue_with" data-auto-logout-link="true" data-use-continue-as="true"></div> -->
      	</form>
      	<p class="text--style">
        <br>
        <font size="-1">Copyright © 2019 CO-OP RMUTL. All rights reserved.</font>
        </p>
    </div>
	</div>

  <script>

      function regis(){
        window.location="sign.php";
      }

  </script>

</body>
</html>
