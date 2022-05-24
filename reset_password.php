<?php
require 'functions/includes.php';

$c_con = get_connection();

$code = $_GET['code'] ?? null;

if(isset($_POST['submit_email'])) {
    $reset_result = api\main\send_reset_email($c_con, $_POST['username']);

	functions::box($reset_result, ($reset_result === responses::success) ? 3 : 2);
}

if(isset($_POST['reset_pass'])) {
    $reset_result = api\main\reset_password_with_code($c_con, $code, $_POST['new_password']);

    if ($reset_result !== responses::success)
        functions::box($reset_result, 3);
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
		<meta name="description" content="Auth.VIP">

		<!-- FAVICON -->
		<link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/favicon.ico" />

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
			<!-- End GLOABAL LOADER -->

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
						<div class="row">
							<div class="col col-login mx-auto">
								<form class="card shadow-none" method="post">
								<?php if($code === null) { ?>
									<div class="card-body">
										<div class="text-center">
											<span class="login100-form-title">
												Forgot Password
											</span>
											<p class="text-muted">Enter the username of your account</p>
										</div>
										<div class="pt-3" id="forgot">
											<div class="form-group">
												<label class="form-label">Username</label>
												<input class="form-control" placeholder="Enter your username" type="username">
											</div>
											<div class="submit">
												<button type="submit" name="submit_email" class="btn btn-primary d-grid">Submit</button>
											</div>
											<div class="text-center mt-4">
												<p class="text-dark mb-0"><a class="text-primary ms-1" href="login.php">Go back</a></p>
											</div>
										</div>
									</div> 
								<?php } else { ?>
								<div class="card-body">
										<div class="text-center">
											<span class="login100-form-title">
												Forgot Password
											</span>
											<p class="text-muted">Submit and change your password</p>
										</div>
										<div class="pt-3" id="forgot">
											<div class="form-group">
												<label class="form-label">New password</label>
												<input class="form-control" placeholder="Enter your new password" type="password" name="new_password">
											</div>
											<div class="submit">
												<button type="submit" name="reset_pass" class="btn btn-primary d-grid">Reset</button>
											</div>
										</div>
									</div>
								<?php } ?>
								</form>
							</div>
						</div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
			<!--END PAGE -->

		</div>
		<!-- BACKGROUND-IMAGE CLOSED -->

		<!-- JQUERY JS -->
		<script src="assets/js/jquery.min.js"></script>

		<!-- BOOTSTRAP JS -->
		<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!-- SPARKLINE JS-->
		<script src="assets/js/jquery.sparkline.min.js"></script>

		<!-- CHART-CIRCLE JS-->
		<script src="assets/js/circle-progress.min.js"></script>

		<!-- Perfect SCROLLBAR JS-->
		<script src="assets/plugins/p-scroll/perfect-scrollbar.js"></script>

		<!-- INPUT MASK JS-->
		<script src="assets/plugins/input-mask/jquery.mask.min.js"></script>

        <!-- Color Theme js -->
        <script src="assets/js/themeColors.js"></script>

        <!-- CUSTOM JS -->
        <script src="assets/js/custom.js"></script>

	</body>
</html>
