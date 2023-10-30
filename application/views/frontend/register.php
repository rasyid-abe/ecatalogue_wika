<body class="bg-login">
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="box-white m-login pad-login">
					<div class="full-width">
						<div class="img-login pull-left">
							<img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="100" height="60">
						</div>
						<p class="font-30 pull-right">REGISTER</p>
					</div>
					<form action="/action_page.php">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Fullname</label>
									<input type="text" class="form-control">
								</div>
								<div class="form-group">
									<label>Username</label>
									<input type="text" class="form-control">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control">
								</div>
								<div class="form-group">
									<label>Phone Number</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Address</label>
									<textarea class="form-control"></textarea>
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" class="form-control">
								</div>
								<div class="form-group">
									<label>Confirm Password</label>
									<input type="password" class="form-control">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group form-check">
									<label class="form-check-label">
										<input class="form-check-input" type="checkbox"> Agree with our Terms & Conditions and Privacy Policy
									</label>
								</div>
							</div>
						</div>
						<div class="center-wrapper">
							<button type="submit" class="btn btn-blue" style="width: 200px;">Register</button>
							<a class="font-blue text-center full-width mtop-15" href="<?php echo base_url() ?>userslogin">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>