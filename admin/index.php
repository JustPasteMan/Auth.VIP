<?php
require '../functions/includes.php';

require '../session.php';

session::check();

if(!session::admin())
    header('Location: ../dashboard/index.php');

$c_con = get_connection();

$username = session::username();

if(isset($_POST['generate'])){
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);

	$days = filter_var($_POST['days'], FILTER_SANITIZE_NUMBER_INT);

    for($i = 0; $i < $amount; $i++){
        $rand_str = functions::random_string(19);

        $c_con->query('INSERT INTO c_tokens(c_token, c_used, c_used_by, c_days) VALUES(?, ?, ?, ?)', [$rand_str, 0, '', $days]);
    }

}

if(isset($_POST['delete'])){
    $token_to_delete = encryption::static_decrypt($_POST['delete']);

    $c_con->query('DELETE FROM c_tokens WHERE c_token=?', [$token_to_delete]);

    functions::box('Deleted the token successfully', 2);
}

?>
<!doctype html>
<html lang="en" dir="ltr">
	<head>

		<!-- META DATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Auth.vip">

		<!-- FAVICON -->
		<link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/favicon.ico" />

		<!-- TITLE -->
		<title>Auth.vip</title>

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
                if(!sessionStorage.hasOwnProperty('darkmode')){
                    sessionStorage.setItem('darkmode', 'false');
                }
                
                var dark = sessionStorage.getItem('darkmode');

                var bodlist = document.getElementById('bod').classList;

                if(dark === 'true') {
                    bodlist.remove('light-mode');
                    bodlist.add('dark-mode');
                } else {
                    bodlist.remove('dark-mode');
                    bodlist.add('light-mode');
                }
            });
            
        </script>

	<body id="bod" class="app sidebar-mini ltr light-mode">

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
											<div class="dropdown d-md-flex">
												<a class="nav-link icon theme-layout nav-link-bg layout-setting" >
													<span class="dark-layout"><i class="fe fe-moon"></i></span>
													<span class="light-layout"> <i class="fe fe-sun"></i></span>
												</a>
											</div>
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
                                    <a class="side-menu__item" data-bs-toggle="slide" href="../dashboard/index.php"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                                </li> 
                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><i class="side-menu__icon fe fe-package"></i><span class="side-menu__label">Classes</span><i class="angle fa fa-angle-right"></i></a>
									<ul class="slide-menu">
										<?php functions::display_classes();?>
									</ul>

                                </li> 
                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="google.com"><i class="side-menu__icon fe fe-clipboard"></i><span class="side-menu__label">Help</span></a>
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

		<form method="POST">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Generate a Token</h3>
            </div>
            <div class="card-body">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" aria-describedby="amount_help" placeholder="Amount">
                        <small id="amount_help" class="form-text">Note: the amount of tokens you want to generate</small>
                    </div> 
					<div class="form-group">
                        <label for="days">Days</label>
                        <input type="number" class="form-control" id="days" name="days" aria-describedby="days_help" placeholder="Days">
                        <small id="days_help" class="form-text">Note: the subscription expiry date. </small>
                    </div>
                    <button type="submit" name="generate" class="btn btn-primary text-uppercase">Generate</button>
            </div>
        </div>
		</form>
                    
<form method="post">
<div class="row">
    <!-- Grid Item -->
    <div class="col-lg-12">
        <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Premium tokens : </h3>
                </div>
                <div class="card-body">
					<p class="text-muted card-sub-title">All available premium tokens.</p>
                    <div class="table-responsive export-table">
                        <table id="file-datatable" class="table border text-nowrap text-md-nowrap table-bordered border-bottom w-100"> 
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Token</th>
                                <th>Used</th>
                                <th>Used by</th>
								<th>Days</th>
                                <th>Delete </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query_result = $c_con->query('SELECT * FROM c_tokens');

                            $rows = $query_result->fetch_all(1);

                            foreach($rows as $row){ ?>
                            <tr>
                                <th scope="row"><?php echo $row['c_id']; ?></th>
                                <td><?php echo functions::xss_clean($row['c_token']); ?></td>
                                <td><?php echo $row['c_used'] ? 'true' : 'false'; ?></td>
                                <td><?php echo functions::xss_clean($row['c_used_by']); ?></td>
								<td><?php echo $row['c_days']; ?></td>
                                <td><button type="submit" name="delete" class="btn btn-primary text-uppercase" value="<?php echo encryption::static_encrypt($row['c_token']); ?>">Delete</button></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /tables -->

            </div>
            <!-- /bard body -->

        </div>
        <!-- /card -->

    </div>
    <!-- /grid item -->


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
							 Copyright ?? 2022 <a href="javascript:void(0);"> Auth.vip </a>. All rights reserved
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
