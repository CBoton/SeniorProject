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
	<nav class="navbar navbar-expand navbar-white navbar-light elevation-4">
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
						<a class="nav-link active" href="edit_profile.php">
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
						<a class="nav-link" href="delete_account.php">
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
						<h1>Edit Profile</h1>
					</div>
				</div>
			</section>
			<!-- Main Body -->
			<div class="card ml-3 mr-3">
				<div class="card-body">
					<!-- Input Row -->
					<div class="form-group">
						<div class="row">
							<div class="input-group">
								<!-- First/Last Name Label -->
								<label class="col-sm-4 col-form-label" for="first_name last_name">First & Last Name</label>
								<!-- First Name Input box -->
								<div class="col-sm-4">
									<input class="form-control" id="first_name" placeholder="First Name"/>
								</div>
								<!-- Last Name Input box -->
								<div class="col-sm-4">
									<input class="form-control" id="last_name" placeholder="Last Name"/>
								</div>
							</div>
						</div>

						<div class="row">
							<!-- Email Label -->
							<label class="col-sm-8 col-form-label" for="email_address">Email Address</label>
							<!-- Email Input box -->
							<div class="col-sm-4">
								<input class="form-control" id="email_address" placeholder="johndoe@gbox.com"/>
							</div>
						</div>

						<div class="row">
							<!-- Phone Number Label -->
							<label class="col-sm-10 col-form-label" for="phone_number">Phone Number</label>
							<!-- Phone Number Input box -->
							<div class="col-sm-2">
								<input class="form-control" id="phone_number" placeholder="+1 (123) 456 - 7890"/>
							</div>
						</div>

						<div class="row">
							<!-- Gender Label-->
							<label class="col-sm-10 col-form-label" for="gender">Gender</label>
							<!-- Gender Input Box-->
							<div class="col-sm-2">
									<select class="form-control" id="gender">
										<option>Male</option>
										<option>Female</option>
										<option>Other</option>
									</select>
							</div>
						</div>

						<div class="row">
							<!-- Date of Birth Label-->
							<label class="col-form-label col-sm-8" for="month day year">Date of Birth</label>
							<!-- Date of Birth Input Box-->
							<select class="form-control col-sm-2" id="month">
								<option>January</option>
								<option>February</option>
								<option>March</option>
								<option>April</option>
								<option>May</option>
								<option>June</option>
								<option>July</option>
								<option>August</option>
								<option>September</option>
								<option>November</option>
								<option>December</option>
							</select>
							<input class="form-control col-sm-1" id="day" placeholder="Day">
							<input class="form-control col-sm-1" id="year" placeholder="Year">
						</div>

							<!-- Save Changes -->
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</body>
</html>