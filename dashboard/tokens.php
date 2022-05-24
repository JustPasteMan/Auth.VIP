<?php
require '../functions/includes.php';

require '../session.php';

session::check();

$c_con = get_connection();

$username = session::username();

$app_to_manage = session::program_key();

if(!$app_to_manage)
    header('Location: index.php');

if(isset($_POST['create_token'])) {
    $token_resp = api\admin\gen_token($c_con, $app_to_manage, $_POST['token_amount'], $_POST['token_days'], $_POST['token_level'], $_POST['token_type'], $_POST['custom_mask'] ?? null);

    switch ($token_resp) {
        case 'maximum_tokens_reached':
            functions::box('Maximum tokens reached', 3);
            break;

        case 'only_500_tokens_per_time':
            functions::box('You can gen only 500 tokens per time ( 75 if you\'re free )', 3);
            break;

        case 'mask_issue':
            functions::box('No X found in the mask', 3);
            break;

        default:
            functions::box('Created tokens', 2);
    }
}

if(isset($_POST['delete_token'])) {
    $token_to_delete = encryption::static_decrypt($_POST['delete_token']);

    api\admin\delete_token($c_con, $app_to_manage, $token_to_delete);

    functions::box('Deleted token', 2);
}

if(isset($_POST['purge_all_tokens'])) {
    api\admin\delete_token($c_con, $app_to_manage, '', true);

    functions::box('Tokens purged', 2);
}

$query = static function($arg) { return "DELETE FROM c_program_tokens WHERE c_program=? AND c_used='{$arg}'"; };

if(isset($_POST['purge_used_tokens'])) {
    $c_con->query($query(1), [$app_to_manage]);

    functions::box('Tokens purged', 2);
}

if(isset($_POST['purge_unused_tokens'])) {
    $c_con->query($query(0), [$app_to_manage]);

    functions::box('Tokens purged', 2);
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
                                        <div class="card-header bg-transparent">
                                            <h3 class="card-title">Token creation form: </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                    <p class="text-muted card-sub-title">This is the form with which you can create tokens for user registration/activation</p> 
                                        <div class="form-group">
                                            <label for="token_amount" class="form-label">Tokens Amount</label>
                                            <input type="number" class="form-control" id="token_amount" name="token_amount" placeholder="Tokens Amount">
                                        </div>
                                        <div class="form-group">
                                            <label for="token_days" class="form-label">Token Days</label>
                                            <input type="number" class="form-control" id="token_days" name="token_days" placeholder="Token Days">
                                        </div>
                                        <div class="form-group">
                                            <label for="token_level" class="form-label">Token Level</label>
                                            <input type="number" class="form-control" id="token_level" name="token_level" placeholder="Token Level">
                                        </div>
                                        <div class="form-group">
                                            <label for="token_type" class="form-label">Token Type</label>
                                            <select class="form-control form-select select2" id="token_type" name="token_type" onchange="if(this.options[this.selectedIndex].value == '4'){ custom_mask.disabled=false; custom_mask.style.display='inline'; } else { custom_mask.disabled = true; custom_mask.style.display='none'; }">
                                                <option value="1" selected> Normal ( XXXXX-XXXXX-XXXXX-XXXXX )</option>
                                                <option value="2"> Big Normal ( XXXXX-XXXXX-XXXXX-XXXXX-XXXXX-XXXXX )</option>
                                                <option value="3"> GUID ( XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX )</option>
                                                <option value="4"> Custom Mask ( X = random char )</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="custom_mask" placeholder="The custom mask" value="XXXX-XXXX-XXXX-XXXX" name="custom_mask" style="display:none;" disabled="disabled">
                                        </div>
                                        <button type="submit" name="create_token" class="btn btn-primary text-uppercase">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form method="post">
                        <div class="row">
                            <div class="col-xl-12 col-sm-10 col-1">
                                <div class="card">
                                    <div class="dt-card__header">
                                        <div class="card-header">
                                            <h3 class="card-title">Token purge: </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
									<p class="mg-b-20 mg-sm-b-40">This will purge tokens, be careful.</p>
                                    <div class="col-lg">
                                        <button type="submit" name="purge_all_tokens" class="btn btn-primary text-uppercase">Purge all tokens</button>
                                    </div><br>
                                    <div class="col-lg">
                                        <button type="submit" name="purge_used_tokens" class="btn btn-primary text-uppercase">Purge used tokens</button>
                                    </div><br>
                                    <div class="col-lg">
                                        <button type="submit" name="purge_unused_tokens" class="btn btn-primary text-uppercase">Purge unused tokens</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form style="display: inline;" method="post">
                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <div class="card custom-card">
                                    <div><div class="card-body" style="overflow-y:hidden;">
                                        <div>
                                        <h3 class="card-title mb-1">Token management : </h3>
                                        <p class="text-muted card-sub-title">In this form, all the program's tokens are listed and can be managed.</h5>
                                    </div>
                                            <div class="table-responsive export-table"> <!-- style="height:400px; width:950px;" !-->
                                                <table class="table border text-nowrap text-md-nowrap table-bordered border-bottom w-100" id="file-datatable">
                                                    <thead>
                                                    <tr>
                                                        <th>Token</th>
                                                        <th>Days</th>
                                                        <th>Rank</th>
                                                        <th>Used</th>
                                                        <th>Used by</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                <?php
                                                $all_t_values = api\fetch\fetch_all_tokens($c_con, $app_to_manage);
                                                foreach($all_t_values as $t_value){ ?>
                                                <tr>
                                                    <td><?php echo $t_value['c_token']; ?></td>
                                                    <td><?php echo $t_value['c_days']; ?></td>
                                                    <td><?php echo $t_value['c_rank']; ?></td>
                                                    <td><?php echo $t_value['c_used'] ? 'true' : 'false'; ?></td>
                                                    <td><?php echo $t_value['c_used_by']; ?></td>
                                                    <td><button class="btn btn-primary text-uppercase" name="delete_token" value="<?php echo encryption::static_encrypt($t_value['c_token']); ?>"> Delete</button></td>
                                                </tr>
                                                <?php } ?> 
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /tables -->

                                        </div>
                                    </div>
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
