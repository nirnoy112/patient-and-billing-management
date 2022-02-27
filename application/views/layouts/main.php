<?php

	/*****
	*
	* @File: 'layouts/main.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 15 April, 2017.
	* @LastUpdatedOn: 19 April, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

	<head>
	
		<title><?= (isset($pageTitle) && $pageTitle) ? $pageTitle : 'SBP'; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

	    <!-- CSS styles -->
	    <?= link_tag(base_url('assets/css/bootstrap.css')); ?>
	    <?= link_tag(base_url('assets/css/bootstrap-datepicker.css')); ?>
	    <?= link_tag(base_url('assets/css/bootstrap-datetimepicker.css')); ?>
	    <?= link_tag(base_url('assets/css/styles.css?v=' . time())); ?>

	    <!-- JS Libs -->
	    <script src="<?php echo base_url(); ?>assets/js/jquery.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

	</head>

	<body>

		<div class="row page-content">
			
			<?php

				if(isset($pageTitle) && $pageTitle != 'Login') {
			
			?>

				<nav class="navbar navbar-inverse">
					<div class="container-fluid">
						<div class="navbar-header">
							<div><img style="padding-top: 3px;" src="<?= base_url('assets/img/codeigniter-icon.png'); ?>">&nbsp;&nbsp;&nbsp;<a class="navbar-brand" href="">SBP</a></div>
						</div>
						<ul class="nav navbar-nav">
							<?php
							if( (int)$roleId != 3) {
							?>
								<li id="order-menu-link"><a href="<?= base_url('order'); ?>">ORDERS</a></li>
							<?php
							}
							?>
							<li id="patient-menu-link"><a href="<?= base_url('patient'); ?>">PATIENTS</a></li>
							<?php
							if( (int)$roleId == 1) {
							?>
								<li id="lists-menu-link">
									<a class="dropdown-toggle" data-toggle="dropdown" href="">MANAGE LISTS</a>
							  	<ul class="dropdown-menu nav">
							  		<li><a href="<?= base_url('user'); ?>">USERS</a></li>
								    <li><a href="<?= base_url('facility'); ?>">FACILITIES</a></li>
								    <li><a href="<?= base_url('physician'); ?>">PHYSICIANS</a></li>
								    <li><a href="<?= base_url('tech'); ?>">TECHNICIANS</a></li>
								    <li><a href="<?= base_url('cptcode'); ?>">CPT CODES</a></li>
								    <li><a href="<?= base_url('attorney'); ?>">ATTORNEYS</a></li>
								    <li><a href="<?= base_url('billing_company'); ?>">BILLING COMPANIES</a></li>
							  	</ul></li>
							<?php
							}
							?>
							<?php
							if( (int)$roleId == 1) {
							?>
								<li id="report-menu-link">
									<a class="dropdown-toggle" data-toggle="dropdown" href="">REPORTS</a>
							  	<ul class="dropdown-menu nav">
							  		<li><a href="<?= base_url('report/facility'); ?>">FACILITY REPORT</a></li>
							  	</ul></li>
							<?php
							}
							?>
							<li><a href=""></a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href=""><span class="glyphicon glyphicon-user"></span> <?= $realName; ?></a></li>
							<li><a href="<?= base_url('logout'); ?>"><span class="glyphicon glyphicon-log-out"></span> LOGOUT</a></li>
						</ul>
					</div>
				</nav>

			<?php

				}

				if(isset($pageHeading) && $pageHeading) {
			
			?>

				<div class="row">
					<div class="col">
						<h2 class="page-heading"><?= $pageHeading; ?></h2>
					</div>
				</div>

			<?php

				}

				if(isset($_view) && $_view)
			    $this->load->view($_view);
				if(isset($_modal) && $_modal)
			    $this->load->view($_modal);

			?>

		</div>

		<footer>

			<p class="cr-info">SBP - Schedule Management System &copy; 2017</p>

		</footer>

		<script src="<?php echo base_url(); ?>assets/js/scripts.js?v=<?php echo time();?>"></script>

	</body>

</html>
