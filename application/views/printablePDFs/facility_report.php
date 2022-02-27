<?php

	/*****
	*
	* @File: 'views/printablePDFs/facility_report.php'.
	* @Author: NASID.
	* @CreatedOn: 24 AUGUST, 2017.
	* @LastUpdatedOn: 26 AUGUST, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');


?>
	<h3><u>SBP BILLING REPORT</u></h3>
	<hr>
<!DOCTYPE html>
<html>

	<head>
	
		<title></title>

	</head>

	<body>
		<table style="width:100%;">
			<tr>
				<td style="width:50%; float:left; text-align: left;">
					SADDLEBACK PORTABLE X-RAY<br>
					PHONE: 714.835.2915<br>
					FAX: 714.543.3114<br>
				</td>
				<td style="width:50%; float: right; text-align: right;">
					<u>RADIOLOGY</u><br>
					<u>BILLING DETAILS REPORT</u><br>
					&nbsp;
				</td>
			</tr>
		</table>
		<br>
		<br>
		<?php
			foreach ($reports as $report) {

				$facility = $report['facility'];
				$orders = $report['orders'];
		?>
		<br>
		<h5 style="text-align: center; border: 1px solid black;"><b>FACILITY:</b> <?php echo $facility['name'] . ' - ' . $facility['uCode'] . ' [ ' . $facility['address'] . ', ' . $facility['city'] . ', ' . $facility['state'] . ' ' . $facility['zip'] . ' ]'; ?></h5>
		<br>
		<?php

				if(count($orders) > 0) {
		?>
		<table style="width:100%; border-top: 2px solid gray;">
			<tr>
				<th style="width: 20%;">Date</th>
				<th style="width: 20%;">Patient Name</th>
				<th style="width: 20%;">Procedures</th>
				<th style="width: 20%;">Total Charge</th>
				<th style="width: 20%;">Due Amount</th>
			</tr>
			<?php

				foreach ($orders as $order) {

					$scheduledTime = $order['sheduledTime'];
					$patients = $order['patients'];

					if(count($patients) > 0) {

						foreach ($patients as $patient) {

			?>
			<tr>
				<td style="width: 20%; border: 1px solid black;"><?php echo date(' m-d-Y, H:i ', $scheduledTime); ?></td>
				<td style="width: 20%; border: 1px solid black;"><?php echo $patient['lastName'] . ' ' . $patient['firstName']; ?></td>
				<td style="width: 20%; border: 1px solid black;"><?php echo $ctrl->displayProcedures($patient['id']); ?></td>
				<td style="width: 20%; border: 1px solid black;"><?php echo ($patient['totalCharges'] != null) ? '$ ' . $patient['totalCharges'] : '$ ' . '0.00'; ?></td>
				<td style="width: 20%; border: 1px solid black;"><?php echo ($patient['totalDue'] != null) ? '$ ' . $patient['totalDue'] : '$ ' . '0.00'; ?></td>
			</tr>

			<?php
						}

					} else {

						echo '<h5 style="text-align: center;">NO ENLISTED PATIENTS.</h5>';
					}

				}

			?>

		</table>
		<?php
				} else {

					echo '<h5 style="text-align: center; border: 0px solid black;">NO ENLISTED PATIENTS.</h5>';

				}

				echo '<hr />';
			}
		?>
		</body>
	</body>

</html>