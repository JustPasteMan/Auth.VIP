<?php
require '../functions/includes.php';

require '../session.php';

session::check();

$c_con = get_connection();

$username = session::username();

$app_to_manage = session::program_key();

if(!$app_to_manage)
    header('Location: index.php');

if(isset($_POST['update_settings'])){
    $expiration_minutes = (!empty($_POST['session_expiry_minutes']) && $_POST['session_expiry_minutes'] <= 50)
        ? $_POST['session_expiry_minutes'] : null;

    api\admin\update_program_data($c_con, array(
        'program_key' => $app_to_manage,
        'api_key' => $_POST['enc_key'] ?? null,
        'expiration_minutes' => $expiration_minutes,
        'version' => $_POST['version'] ?? null,
        'download_link' => $_POST['download_link'] ?? null,
        'killswitch' => $_POST['killswitch_enabled'] ?? null,
        'hwid' => $_POST['hwid_enabled'] ?? null
    ));

    functions::box('Settings updated', 2);
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
		<link id="style" href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

		<!-- STYLE CSS -->
		<link href="../assets/css/style.css" rel="stylesheet"/>
		<link href="../assets/css/dark-style.css" rel="stylesheet"/>
        <link href="../assets/css/skin-modes.css" rel="stylesheet" />
        <link href="../assets/css/transparent-style.css" rel="stylesheet" />

		<!--- FONT-ICONS CSS -->
		<link href="../assets/css/icons.css" rel="stylesheet"/>

		<!-- COLOR SKIN CSS -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="../assets/colors/color1.css" />

	</head>

        <script>
            function mode_onclick(){
                var dark = document.getElementById('bod').classList.contains("dark-mode");

                sessionStorage.setItem('darkmode', dark.toString());
            }
            
            document.addEventListener("DOMContentLoaded", function(event){
                bodlist.remove('light-mode');
                bodlist.add('dark-mode');
            });
            
        </script>

	<body id="bod" class="app sidebar-mini ltr dark-mode">

		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /GLOBAL-LOADER -->

		<!-- PAGE -->
		<div class="page">
			<div class="page-main">

				<!-- app-Header -->
				<div class="app-header header sticky">
					<div class="container-fluid main-container">
						<div class="d-flex align-items-center">
							<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0);"></a>
							<div class="responsive-logo">
								<a href="index.php" class="header-logo">
									<img src="../assets/images/brand/logo-3.png" class="mobile-logo logo-1" alt="logo">
									<img src="../assets/images/brand/logo.png" class="mobile-logo dark-logo-1" alt="logo">
								</a>
							</div>
							<!-- sidebar-toggle-->
							<a class="logo-horizontal " href="index.php">
								<img src="../assets/images/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
								<img src="../assets/images/brand/logo-3.png" class="header-brand-img light-logo1"
									alt="logo">
							</a>
							<!-- LOGO -->
							<div class="d-flex order-lg-2 ms-auto header-right-icons">
								<!-- SEARCH -->
								<button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
										<span class="navbar-toggler-icon fe fe-more-vertical text-dark"></span>
									</button>
								<div class="navbar navbar-collapse responsive-navbar p-0">
									<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
										<div class="d-flex order-lg-2" onclick="mode_onclick()">
											<!-- FULL-SCREEN -->
											<div class="dropdown d-md-flex notifications">
												<a class="nav-link icon" data-bs-toggle="dropdown"><i class="fe fe-bell"></i><span></span>
													</a>
												<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow ">
													<div class="drop-heading border-bottom">
														<div class="d-flex">
															<h6 class="mt-1 mb-0 fs-16 fw-semibold">News menu</h6>
															<!-- <div class="ms-auto">
																<span class="badge bg-success rounded-pill">3</span>
															</div> -->
														</div>
													</div>
													<div class="notifications-menu">
                                                        <?php functions::display_news(); ?>
													</div>
													<div class="dropdown-divider m-0"></div>
												</div>
											</div>
											<!-- NOTIFICATIONS -->
											<!-- MESSAGE-BOX -->
											<div class="dropdown d-md-flex profile-1">
												<a href="javascript:void(0);" data-bs-toggle="dropdown" class="nav-link leading-none d-flex px-1">
													<span>
															<img src="../assets/images/users/8.jpg" alt="profile-user" class="avatar  profile-user brround cover-image">
														</span>
												</a>
                                                <?php functions::display_user_data($username, session::premium(), session::admin()); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /app-Header -->

                <!--APP-SIDEBAR-->
                <div class="sticky">
                    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
                    <aside class="app-sidebar">
                        <div class="side-header">
                            <a class="header-brand1" href="index.php">
                                <img src="../assets/images/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
                                <img src="../assets/images/brand/logo-1.png" class="header-brand-img toggle-logo" alt="logo">
                                <img src="../assets/images/brand/logo-2.png" class="header-brand-img light-logo" alt="logo">
                                <img src="../assets/images/brand/logo-3.png" class="header-brand-img light-logo1" alt="logo">
                            </a>
                            <!-- LOGO -->
                        </div>
                        <div class="main-sidemenu">
                            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                                    fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                                </svg></div>
                            <ul class="side-menu">
                                <li class="sub-category">
                                    <h3>Main</h3>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="index.php"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                                </li> 
                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><i class="side-menu__icon fe fe-package"></i><span class="side-menu__label">Classes</span><i class="angle fa fa-angle-right"></i></a>
									<ul class="slide-menu">
										<?php functions::display_classes();?>
									</ul>

                                </li> 
								<li class="sub-category">
                                    <h3>Management</h3>
                                </li>
								<li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="users.php"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Users</span></a>
								</li>
								<li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="tokens.php"><i class="side-menu__icon fe fe-crop"></i><span class="side-menu__label">Tokens</span></a>
								<li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="vars.php"><i class="side-menu__icon fe fe-database"></i><span class="side-menu__label">Vars</span></a>
                                </li>
								<li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="files.php"><i class="side-menu__icon fe fe-folder"></i><span class="side-menu__label">Files</span></a>
                                </li>
								<li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="logs.php"><i class="side-menu__icon fe fe-briefcase"></i><span class="side-menu__label">Logs</span></a>
                                </li>
								<li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="settings.php"><i class="side-menu__icon fe fe-settings"></i><span class="side-menu__label">Settings</span></a>
                                </li>
                            </ul>
                            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                    width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                                </svg></div>
                        </div>
                    </aside>
                </div>
                <!--/APP-SIDEBAR-->

				<!--app-content open-->
				<div class="main-content app-content mt-0">
					<div class="side-app">

						<!-- CONTAINER -->
						<div class="main-container container-fluid">

							<!-- PAGE-HEADER -->
							<div class="page-header">
								<div>
									<h1 class="page-title">Dashboard</h1>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Management</li>
									</ol>
								</div>
							</div>
							<!-- PAGE-HEADER END -->

                            
                    <form method="post">
                        <div class="row">
                            <div class="col-xl-10 col-sm-10 col-2">
                                <div class="card">
                                    <div class="dt-card__header">
                                        <div class="card-header">
                                            <h3 class="card-title">Update Settings : </h3>
                                        </div>
                                    </div>
                                    <?php
                                    $program_data = api\fetch\fetch_program($c_con, $app_to_manage, false);

                                    if(is_array($program_data)){
                                    ?>
                                            <div class="card-body">
                                            <p class="text-muted card-sub-title">With this form you can change your program's settings.</p>
                                                <div class="form-group">
                                                    <label for="enc_key">API/Encryption key</label>
                                                    <input type="text" class="form-control" id="enc_key" name="enc_key" aria-describedby="help_enc"
                                                           value="<?php echo $program_data["c_encryption_key"]; ?>"
                                                           placeholder="API/Encryption key">
                                                    <small id="help_enc" class="form-text">This is the API/Encryption key of your requests.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="version">Version</label>
                                                    <input type="text" class="form-control" id="version" name="version" aria-describedby="help_version"
                                                           value="<?php echo sprintf("%.1f", $program_data["c_version"]); ?>"
                                                           placeholder="Version">
                                                    <small id="help_version" class="form-text">This is the version of the application you're managing</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="download_link">Download link</label>
                                                    <input type="text" class="form-control" id="download_link" name="download_link" aria-describedby="help_dl"
                                                           value="<?php echo $program_data['c_dl']; ?>"
                                                           placeholder="Download link">
                                                    <small id="help_dl" class="form-text">This is the link that will be opened if the version is wrong</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="session_expiry_minutes">Session expiration minutes</label>
                                                    <input type="number" max="50" class="form-control" id="session_expiry_minutes" name="session_expiry_minutes" aria-describedby="help_sem"
                                                           value="<?php echo $program_data['c_sem']; ?>"
                                                           placeholder="Session expiration minutes">
                                                    <small id="help_sem" class="form-text">This is the number of minutes that the session will last ( maximum value is 50 minutes )</small>
                                                </div>
                                                <div class="form-group custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" aria-describedby="help_kills"
                                                        <?php if($program_data['c_killswitch']) echo 'checked="checked"'; ?>
                                                           id="killswitch_enabled" name="killswitch_enabled">
                                                    <label class="custom-control-label" for="killswitch_enabled">KillSwitch enabled</label>
                                                    <small id="help_kills" class="form-text">if this option is enabled, the API functions for the program you're managing will be disabled</small>
                                                </div>
                                                <div class="form-group custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" aria-describedby="help_hwide"
                                                           <?php if($program_data['c_hwide']) echo 'checked="checked"'; ?>
                                                           id="hwid_enabled" name="hwid_enabled">
                                                    <label class="custom-control-label" for="hwid_enabled">Hardware ID
                                                        checks enabled</label>
                                                    <small id="help_hwide" class="form-text">the option to disable or enable the HWID checks</small>
                                                </div>
                                                <button type="submit" name="update_settings"
                                                        class="btn btn-primary text-uppercase">Update
                                                </button>
                                            </div>
                                    <?php } else echo $program_data; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                    
							<!--End  Row -->
                             
						</div>
					</div>
				</div>
				<!-- CONTAINER CLOSED -->
			</div>

			<!-- FOOTER -->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-md-12 col-sm-12 text-center">
							 Copyright © 2022 <a href="javascript:void(0);"> Auth.VIP </a>. All rights reserved
						</div>
					</div>
				</div>
			</footer>
			<!-- FOOTER CLOSED -->
		</div>

		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

		<!-- JQUERY JS -->
		<script src="../assets/js/jquery.min.js"></script>

		<!-- BOOTSTRAP JS -->
		<script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!-- SPARKLINE JS-->
		<script src="../assets/js/jquery.sparkline.min.js"></script>

		<!-- CHART-CIRCLE JS-->
		<script src="../assets/js/circle-progress.min.js"></script>

		<!-- C3 CHART JS-->
		<script src="../assets/plugins/charts-c3/d3.v5.min.js"></script>
		<script src="../assets/plugins/charts-c3/c3-chart.js"></script>

		<!-- INPUT MASK JS-->
		<script src="../assets/plugins/input-mask/jquery.mask.min.js"></script>

        <!-- SIDE-MENU JS -->
        <script src="../assets/plugins/sidemenu/sidemenu.js"></script>

        <!-- Sticky js -->
        <script src="../assets/js/sticky.js"></script>

		<!-- SIDEBAR JS -->
		<script src="../assets/plugins/sidebar/sidebar.js"></script>

		<!-- Perfect SCROLLBAR JS-->
		<script src="../assets/plugins/p-scroll/perfect-scrollbar.js"></script>
		<script src="../assets/plugins/p-scroll/pscroll.js"></script>
		<script src="../assets/plugins/p-scroll/pscroll-1.js"></script>

        <!-- Color Theme js -->
        <script src="../assets/js/themeColors.js"></script>

        <!-- CUSTOM JS -->
        <script src="../assets/js/custom.js"></script>

        <!-- DATATABLE -->
		<script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
		<script src="../assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="../assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
		<script src="../assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.print.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.colVis.min.js"></script>
		<script src="../assets/plugins/datatable/dataTables.responsive.min.js"></script>
		<script src="../assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
		<script src="../assets/js/table-data.js"></script>

	</body>
</html>

