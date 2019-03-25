<link rel="icon" href="..\img\icon.png">

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WebUser Register</title>

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
        <br><b><font color="#999999" size="+3">REGISTER</font></b>
        <br>
        <br>
        </p>
      	<form action="regis.php" method="post" name="checkForm" id="checkForm" class="form form--login">
        <div class="form__field">
        <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
        <input id="login__username" type="text" class="form__input" placeholder="Username" name="user" autofocus required autocomplete="off"/>
        </div>
        <div class="form__field">
        <label class="fontawesome-user" for="login__email"><span class="hidden">Email</span></label>
        <input id="login__username" type="email" class="form__input" placeholder="Email" name="email" required autocomplete="off"/>
        </div>
        <div class="form__field">
        <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
        <input id="login__password" type="password" class="form__input" placeholder="Password" name="pass" required autocomplete="off"/>
        </div>
        <div class="form__field">
        <input type="submit" name="login" value="Register">
        </div>
        <?php if (isset($errormsg)) { echo $errormsg; } ?>
      	</form>
      	<p class="text--style">
        <br>
        <font size="-1">Copyright © 2019 CO-OP RMUTL. All rights reserved.</font>
        </p>
    </div>
	</div>

</body>
</html>
