<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<?php   $this->load->view("admin/layouts/header");?>
  <script>
function goBack() {
    window.history.back();
}
</script>
<style type="text/css">
	.logo-header{
		display: table;
		margin:10% auto 30px;
	}
	.text-title{
		font-size: 15rem;
		color: #fff200;
		text-align: center;
		font-weight: bold;
		margin:0 0 10px;
	}
	a, .btn{
		transition: .5s ease;
	}
	.btn-white{
		background: #fff;
		color: #04adf0 !important;
		font-weight: bold;
	}
	.btn-white:hover, .btn-white:focus, .btn-white:active{
		background-color: #0685b8;
		color: #fff !important;
	}
	.btn-outline{
		border:1px solid #fff;
		color: #fff;
		background: transparent;
	}
	.btn-outline:hover, .btn-outline:focus, .btn-outline:active{
		background-color: #0685b8;
		color: #fff !important;
	}
	.button-group{
		display: table;
		margin:15px auto;
	}
	.button-group .btn{
		margin:0 10px;
	}
	.mb-30{
		margin-bottom: 30px;
	}
	html{
		height: 100%;
	}
	.bg-city{
		background:#04adf0;
		height: 100%;
		min-height: 100%;
	}
	.text-white{
		color: #fff;
	}
	.img-city{
		width: 100%;
		display: table;
		margin:auto;
	}
</style>
<body class="bg-city"> 
	<div class="container">
		<img src="assets/images/frontend/logo-white.png" class="logo-header">
		<h1 class="text-title">Page Restrict</h1>
		<p class="text-white text-center mb-30">Sorry you cannot access this page</p>
		<div class="button-group">
			<a href="#" class="btn btn-white btn-shadow">Back to Home</a>
			<a href="#" class="btn btn-outline btn-shadow">Previous Page</a>
		</div>
		<img src="assets/images/frontend/bg-city.png" class="img-city">
	</div>
</body>
</html>