<body class="bg-login">
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="box-white m-login pad-login">
					<div class="full-width">
						<div class="img-login pull-left">
							<img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="100" height="60">
						</div>
						<p class="font-30 pull-right">LOGIN</p>
					</div>
					<form action="/action_page.php">
						<div class="form-group">
							<label for="email">Username</label>
							<input type="text" class="form-control" id="email">
						</div>
						<div class="form-group">
							<label for="pwd">Password</label>
							<input type="password" class="form-control" id="pwd">
						</div>
						<div class="form-group form-check">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox"> Remember me
							</label>
						</div>
						<div class="center-wrapper">
							<button type="submit" class="btn btn-blue" style="width: 200px;">Login</button>
							<p class="font-12 text-center mtop-15">Have no account<a class="font-blue" href="<?php echo base_url() ?>usersregister"> Register Now</a></p>
							<a class="font-blue text-center full-width mtop-15" href="<?php echo base_url() ?>home">Home</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>