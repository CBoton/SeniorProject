



<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>OT | Account Settings</title>

	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../AdminLTE/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="../AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../AdminLTE/dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="container-fluid" style="height: auto;">
	<!-- Navbar -->
	<nav class="navbar navbar-expand navbar-white navbar-light">
		<!-- Logo -->
		<a class="navbar-brand" href="#">
			<img src="https://via.placeholder.com/45x45.png?text=OT">
		</a>
		<!-- Logout Button -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item d-none d-sm-inline-block">
				<a class="nav-link" href="../../front/index.html">Logout</a>
			</li>
		</ul>
	</nav>
	<!-- The rest below the header bar -->
	<div class="wrapper">
		<!-- Sidebar -->
		<aside class="main-sidebar sidebar-light-primary elevation-4">
			<span class="brand-text font-weight-bold ml-4">Account Settings</span>
			<div class="sidebar">
				<ul class="nav nav-pills nav-sidebar flex-column" role="menu">
					<!-- Sidebar Entry -->
					<li class="nav-item">
						<a class="nav-link" href="edit_profile.php">
							<i class="nav-icon fas fa-user"></i>
							<p>Edit Profile</p>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="change_password.php">
							<i class="nav-icon fas fa-key"></i>
							<p>Change Password</p>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="my_plan.php">
							<i class="nav-icon fas fa-dollar-sign"></i>
							<p>My Plan</p>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="delete_account.php">
							<i class="nav-icon fas fa-bomb"></i>
							<p>Delete Account</p>
						</a>
					</li>
				</ul>
			</div>
		</aside>

		<!-- Content -->
		<div class="content-wrapper">
			<!-- Head -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row">
						<h1>Delete Account</h1>
					</div>
				</div>
			</section>
			<!-- Main Body -->
			<div class="card ml-3 mr-3">
				<div class="card-body">
					<!-- Input Row -->
					<div class="form-group row">
						<div class="input-group">
							<!-- Label -->
							<label class="col-sm-0 col-form-label-fluid" for="confirm">You are attempting to
							delete your account. Your plan and future recurring payments will be cancelled.
							All data will be permanently deleted immediately and this specific account will be lost. Are you for sure?

							</label>

							<!-- Input box -->

							<!--<div class="col-sm-4">
								<input class="form-control" id="first_name" placeholder="First Name"/>
							</div>-->

							<div class="col-sm-4-fluid">
							    <white-space>
                                <break>
								<input class="form-control" id="pass_word" placeholder="Current Password"/>
							</div>
                        <break>

					    <button type="button" class="btn btn-block btn-danger disabled">Delete</button></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>