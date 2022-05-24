<?php
require 'functions/includes.php';

if(isset($_POST['signup'])) {
        $register_result = api\main\register(get_connection(), $_POST['username'], $_POST['email'], $_POST['password']);

        if ($register_result !== responses::success)
            functions::box($register_result, 3);
        else
            header('Location: login.php');
}
?>
<!doctype html>
<html lang="en" dir="ltr">
  <head>

		<!-- META DATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- FAVICON -->
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/brand/favicon.ico" />

		<!-- TITLE -->
		<title>Auth.VIP</title>

		<!-- BOOTSTRAP CSS -->
		<link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

		<!-- STYLE CSS -->
		<link href="assets/css/style.css" rel="stylesheet"/>
		<link href="assets/css/dark-style.css" rel="stylesheet"/>
        <link href="assets/css/skin-modes.css" rel="stylesheet" />
        <link href="assets/css/transparent-style.css" rel="stylesheet" />

		<!--- FONT-ICONS CSS -->
		<link href="assets/css/icons.css" rel="stylesheet"/>

		<!-- COLOR SKIN CSS -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/colors/color1.css" />

	</head>

	<body>

		<!-- BACKGROUND-IMAGE -->
		<div class="login-img">

			<!-- GLOABAL LOADER -->
			<div id="global-loader">
				<img src="assets/images/loader.svg" class="loader-img" alt="Loader">
			</div>
			<!-- /GLOABAL LOADER -->

			<!-- PAGE -->
			<div class="page">
				<div class="">

				    <!-- CONTAINER OPEN -->
					<div class="col col-login mx-auto">
						<div class="text-center">
							<img src="assets/images/brand/logo.png" class="header-brand-img" alt="">
						</div>
					</div>
					<div class="container-login100">
						<div class="wrap-login100 p-0">
							<div class="card-body">
								<form class="login100-form validate-form" method="POST">
									<span class="login100-form-title">
										Registration
									</span>
									<div class="wrap-input100 validate-input" data-bs-validate = "Valid username is required: name">
										<input class="input100" type="text" name="username" placeholder="Username">
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="mdi mdi-account" aria-hidden="true"></i>
										</span>
									</div>
									<div class="wrap-input100 validate-input" data-bs-validate = "Valid email is required: ex@abc.xyz">
										<input class="input100" type="text" name="email" placeholder="Email">
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="zmdi zmdi-email" aria-hidden="true"></i>
										</span>
									</div>
									<div class="wrap-input100 validate-input" data-bs-validate = "Password is required">
										<input class="input100" type="password" name="password" placeholder="Password">
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="zmdi zmdi-lock" aria-hidden="true"></i>
										</span>
									</div>
									<!-- <label class="custom-control custom-checkbox mt-4">
										<input type="checkbox" class="custom-control-input">
										<span class="custom-control-label">Agree with the <a href="terms.html">terms and policy</a></span>
									</label> -->
									<div class="container-login100-form-btn">
										<button type="submit" name="signup" class="login100-form-btn btn-primary">
											Register
										</button>
									</div>
									<div class="text-center pt-3">
										<p class="text-dark mb-0">Already have an account?<a href="login.php" class="text-primary ms-1">Sign In</a></p>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
			<!-- END PAGE -->

		</div>
		<!-- BACKGROUND-IMAGE CLOSED -->

		<!-- JQUERY JS -->
		<script src="assets/js/jquery.min.js"></script>

		<!-- BOOTSTRAP JS -->
		<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!-- CHART-CIRCLE JS -->
		<script src="assets/js/circle-progress.min.js"></script>

		<!-- Perfect SCROLLBAR JS-->
		<script src="assets/plugins/p-scroll/perfect-scrollbar.js"></script>

		<!-- INPUT MASK JS -->
		<script src="assets/plugins/input-mask/jquery.mask.min.js"></script>

        <!-- Color Theme js -->
        <script src="assets/js/themeColors.js"></script>

        <!-- CUSTOM JS -->
        <script src="assets/js/custom.js"></script>

	</body>
</html>
