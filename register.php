<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>
<?php
if (isset($_COOKIE['username']) && isset($_COOKIE['password']))
{
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
    echo
    "
    <script>
        document.getElementById('taikhoan').value = '$username';
        document.getElementById('matkhau').value = '$password';
    </script>

    ";
}

?>

<html>
<head>
	<title>Welcome to Spotify!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="assets/js/register.js"></script>
	
</head>
<body>
	<?php
		if(isset($_POST['registerButton'])) {
			echo '<script>
					$(document).ready(function() {
						$("#loginForm").hide();
						$("#registerForm").show();
						$(".hasAccountText").hide();
					});
				</script>';
		}
		else {
			echo '<script>
					$(document).ready(function() {
						$("#loginForm").show();
						$("#registerForm").hide();
					});
				</script>';
		}
	?>
	
	<div class="head">
		<img src="assets\images\Spotify_Logo_RGB_Black.png" alt ="logo"/>
	</div>
	<div id="loginContainer">
		<div id="inputContainer">
			<form id="loginForm" action="register.php" method="POST">
				<h2>To continue, log in to Spotify</h2>
				<div class="input">
					<p>
						<label for="loginUsername">Username</label>
						<input id="loginUsername" name="loginUsername" id="taikhoan" type="text" size="50" value="<?php if (isset($_COOKIE['username'])) echo $_COOKIE['username'];  getInputValue('loginUsername'); ?>" required>						
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input id="loginPassword" name="loginPassword" id="matkhau" type="password" size="50" value="<?php if (isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>" required>
						<?php echo $account->getError(Constants::$loginFailed); ?>
					</p>
				</div>
				<div class="row-summit"></div>
					<div class="remember-me">
						<label><input type="checkbox" name="remember" />Remember me</label>
					</div>
					<button type="submit" name="loginButton">LOG IN</button>
				</div>
				<div class="hasAccountText">
					<span>Don't have an account?</span>
					<button id="hideLogin" type ="button">Sign up for Spotify</button>
				</div>	
			</form>
			
			<div class="register">
				<form id="registerForm" action="register.php" method="POST">
					<h2 id="signuptext">Sign up for free to start listening</h2>
					<p>					
						<label for="username">Username</label>
						<input id="username" name="username" type="text"  value="<?php getInputValue('username') ?>" size="50" required>
						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
					</p>

					<p>
						
						<label for="firstName">First name</label>
						<input id="firstName" name="firstName" type="text"  value="<?php getInputValue('firstName') ?>" size="50" required>
						<?php echo $account->getError(Constants::$firstNameCharacters); ?>
					</p>

					<p>
						
						<label for="lastName">Last name</label>
						<input id="lastName" name="lastName" type="text"  value="<?php getInputValue('lastName') ?>" size="50" required>
						<?php echo $account->getError(Constants::$lastNameCharacters); ?>
					</p>

					<p>
						
						<label for="email">Email</label>
						<input id="email" name="email" type="email"  value="<?php getInputValue('email') ?>" size="50" required>
						<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
					</p>

					<p>
						<label for="email2">Confirm email</label>
						<input id="email2" name="email2" type="email"  value="<?php getInputValue('email2') ?>" size="50" required>
					</p>

					<p>
						
						<label for="password">Password</label>
						<input id="password" name="password" type="password" size="50"  required>
						<?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
					</p>

					<p>
						<label for="password2">Confirm password</label>
						<input id="password2" name="password2" type="password" size="50"  required>
					</p>

					<button type="submit" name="registerButton">SIGN UP</button>
					
					<div class="hasAccountTextreg">
						<span >Already have an account? </span><span id="hideRegister"> Login</span>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>
