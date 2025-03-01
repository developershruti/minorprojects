 <nav class="navbar">
				<a href="#" class="sidebar-toggler">
					<i data-feather="menu"></i>
				</a>
				<div class="navbar-content">
					<form class="search-form">
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<i data-feather="search"></i>
								</div>
							</div>
							<input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
						</div>
					</form>
					<ul class="navbar-nav">
						 
						 
						 
						<li class="nav-item dropdown nav-notifications">
							<a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i data-feather="user"></i>
								<div class="indicator">
									<div class="circle"></div>
								</div>
							</a>
							<div class="dropdown-menu" aria-labelledby="notificationDropdown">
								<div class="dropdown-header d-flex align-items-center justify-content-between">
									 
								</div>
								<div class="dropdown-body">
									<a href="<?=SITE_WS_PATH?>/register-user.php" class="dropdown-item">
										<div class="icon">
											<i data-feather="user-plus"></i>
										</div>  
										<div class="content">
											<p>New customer register </p>
											 
										</div>
									</a>
									<a href="profile_edit.php" class="dropdown-item">
										<div class="icon">
											<i data-feather="gift"></i>
										</div>
										<div class="content">
											<p>Edit Profile</p>
											 
										</div>
									</a>
									<a href="psw_edit.php" class="dropdown-item">
										<div class="icon">
											<i data-feather="alert-circle"></i>
										</div>
										<div class="content">
											<p>Change Password</p>
											 
										</div>
									</a>
									<a href="security_code_edit.php" class="dropdown-item">
										<div class="icon">
											<i data-feather="layers"></i>
										</div>
										<div class="content">
											<p>Change Transaction Password</p>
											 
										</div>
									</a>
									<a href="../logout.php" class="dropdown-item">
										<div class="icon">
											<i data-feather="download"></i>
										</div>
										<div class="content">
											<p>Logout</p>
											 
										</div>
									</a>
								</div>
								<div class="dropdown-footer d-flex align-items-center justify-content-center">
									<a href="javascript:;">View all</a>
								</div>
							</div>
						</li>
						 
					</ul>
				</div>
			</nav>