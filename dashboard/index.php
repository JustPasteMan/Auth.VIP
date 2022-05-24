<?php
require '../functions/includes.php';

require '../session.php';

session::check();

$c_con = get_connection();

$username = session::username();

if(isset($_POST['create_app'])) {
    $program_resp = api\admin\create_program($c_con, $username, $_POST['app_name'], $_POST['app_enc_key']);

    switch($program_resp){
        case 'empty_data':
            functions::box('Program name or the api/enc key is empty', 3);
            break;

        case 'maximum_programs_reached':
            functions::box('Maximum programs reached', 3);
            break;

        case 'program_already_exists':
            functions::box('Program already exists', 3);
            break;

        case responses::success:
            functions::box('Created the program successfully', 2);
            break;

        default:
            functions::box('Unknown response', 3);
            break;
    }
}

if(isset($_POST['remove_app'])) {
    $app_to_remove = encryption::static_decrypt($_POST['remove_app']);

    $del_resp = api\admin\delete_program($c_con, $username, $app_to_remove);

    switch($del_resp){
        case responses::program_doesnt_exist:
            functions::box('The program you\'re trying to delete isn\'t yours');
            break;

        case responses::success:
            unset($_SESSION['app_to_manage']);
            functions::box('Removed the program successfuly', 2);
            break;
    }
}

if(isset($_POST['manage_app'])) {
    $app_to_manage = encryption::static_decrypt($_POST['manage_app']);

    if(api\validation\program_valid_under_name($c_con, $username, $app_to_manage)){
        $_SESSION['app_to_manage'] = $app_to_manage;

        header('Location: manage.php');
    }

    functions::box('The program you tried to manage is not yours', 3);
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
										<li class="breadcrumb-item active" aria-current="page">Main</li>
									</ol>
								</div>
							</div>
							<!-- PAGE-HEADER END -->

                            <form method="POST">
                            <div class="row row-sm">
								<div class="col-lg-12">
									<div class="card custom-card">
										<div class="card-body">
											<div>
												<h3 class="card-title mb-1">Program management</h3>
												<p class="text-muted card-sub-title">Create and manage your programs here.</p>
											</div>
											<div class="table-responsive">
												<table class="table border text-nowrap text-md-nowrap table-bordered mg-b-0">
													<thead>
														<tr>
															<th>ID</th>
															<th>Name</th>
															<th>Program key</th>
                                                            <th>API/Encryption key</th>
                                                            <th>Version</th>
                                                            <th>HWID enabled</th>    
                                                            <th>Manage</th>
                                                            <th>Delete</th>
														</tr>
													</thead>
													<tbody>

                            <?php
                            $all_p_values = api\fetch\fetch_all_programs($c_con, $username);
                            foreach($all_p_values as $pro_row){
                                $enc_pkey = encryption::static_encrypt($pro_row['c_program_key']);
                                ?>
                            <tr>
                                <td><?php echo $pro_row['c_id']; ?></td>
                                <td><?php echo $pro_row['c_program_name']; ?></td>
                                <td><?php echo $pro_row['c_program_key']; ?></td>
                                <td><?php echo $pro_row['c_encryption_key']; ?></td>
                                <td><?php echo sprintf('%.1f', $pro_row['c_version']);  ?></td>
                                <td><?php echo $pro_row['c_hwide'] ? 'true' : 'false'; ?></td>
                                <td><button type="submit" class="btn btn-primary" name="manage_app" value="<?php echo $enc_pkey; ?>">Manage</button></td>
                                <td><button type="submit" class="btn btn-primary" name="remove_app" value="<?php echo $enc_pkey; ?>" onclick="return confirm('Are you sure that you want to delete this program?');">Delete</button></td>
                            </tr>
                            <?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
                            </form>

							<!--End  Row -->
                            <form method="POST">
<div class="col-lg-12 col-md-12">
									<div class="card">
										<div class="card-header">
											<h4 class="card-title">Program creation</h4>
										</div>
										<div class="card-body">
											<form>
												<div class="form-group">
													<label class="col-md-3 form-label">Program name</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="app_name" placeholder="Name">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 form-label">Program api/encryption key</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="app_enc_key" value="<?php echo md5(functions::random_string());?>" placeholder="Program api/enc key">
													</div>
												</div>
                                                <div class="form-group">

                                                    <small class="form-text">Note: this must be a random string, it's used as the encryption key of your client-sided requests, it can be changed later.</small>
												    <button type="submit" class="btn btn-primary mt-4 mb-0" name="create_app">Create</button></div>
												</div> 
											</form>
										</div>
									</div>
								</div>
							</div>  
							<!-- End Row -->
                                
                            </form>
                
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

	</body>
</html>

