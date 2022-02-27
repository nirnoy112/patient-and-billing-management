<?php

	/*****
	*
	* @File: 'login/index.php'.
	* @Author: Nirnoy.
	* @CreatedOn: 15 April, 2017.
	* @LastUpdatedOn: 19 April, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');
?>


	<div class="col-sm-4"></div>
	<div id="login-box" class="col-sm-4">
		<form method="post" action="<?= base_url('login/authenticate'); ?>" class="form-horizontal">
		
			<h4 class="page-info">LOG IN TO START</h4>

			<?php

				if(isset($errorMessage) && $errorMessage) {

			?>
				<h5 class="error-message"><?= $errorMessage; ?></h5>

			<?php

				}

			?>
			<div class="form-group">
				<label class="col-sm-5 control-label">ENTER USERNAME</label>
				<div class="col-sm-6">
					<input class="form-control" type="text" id="username" name="username" placeholder="your username" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label">ENTER PASSWORD</label>
				<div class="col-sm-6">
					<input class="form-control" type="password" id="password" name="password" placeholder="your password" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-5 col-sm-6">
					<button type="submit" class="btn btn-s-lg btn-success btn-rounded no_border">LOG IN</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col"></div>
