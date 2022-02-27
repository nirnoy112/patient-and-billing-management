<?php

	/*****
	*
	* @File: 'views/printablePDFs/order.php'.
	* @Author: NASID.
	* @CreatedOn: 05 JUNE, 2017.
	* @LastUpdatedOn: 06 JUNE, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');


?>

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
					<u>ORDER REPORT</u><br>
					&nbsp;
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<table style="width:100%; border: 0px solid black; border-collapse: none;">
			<!-- <tr style="height: 0px; display: none;">
				<td style="width: 10%;">0</td>
				<td style="width: 10%;">1</td>
				<td style="width: 10%;">2</td>
				<td style="width: 10%;">3</td>
				<td style="width: 10%;">4</td>
				<td style="width: 10%;">5</td>
				<td style="width: 10%;">6</td>
				<td style="width: 10%;">7</td>
				<td style="width: 10%;">8</td>
				<td style="width: 10%;">9</td>
			</tr> -->
			<tr style="border: 1px solid black;">
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">PATIENT'S NAME:</b>&nbsp;<small style="font-size: 9px;"><?= $patient->lastName . ' ' . $patient->firstName . ' ' . $patient->middleName; ?></small></td>
				<td colspan="2" style="width: 20%; border-right: 1px solid black;"><b style="font-size: 10px;">PATIENT'S ID:</b>&nbsp;<small style="font-size: 9px;"><?= $patient->PID; ?></small></td>
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">DATE OF BIRTH:</b>&nbsp;<small style="font-size: 9px;"><?= $patient->dob; ?></small></td>
				<td colspan="1" style="width: 10%; border-right: 1px solid black;"><b style="font-size: 10px;">SEX:</b>&nbsp;<small style="font-size: 9px;"><?= $patient->patientSex; ?></small></td>
				<td style="width: 10%; border-right: 1px solid black;"></td>
			</tr>
			<tr style="border: 1px solid black;">
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">ADDRESS:</b>&nbsp;<small style="font-size: 9px;"><?= $patient->streetNoP; ?></small></td>
				<td colspan="4" style="width: 40%; border-right: 1px solid black;"><b style="font-size: 10px;">CITY, STATE &amp; ZIP:</b>&nbsp;<small style="font-size: 9px;"><?= $patient->cityP . ', ' . $patient->stateP . ', ' . $patient->zipCodeP; ?></small></td>
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">PHONE NO:</b>&nbsp;<small style="font-size: 9px;"><?= $patient->telephoneP; ?></small></td>
			</tr>
			<tr style="border: 1px solid black;">
				<td colspan="5" style="width: 50%; border-right: 1px solid black;"><b style="font-size: 10px;">ORDERING FACILITY:</b>&nbsp;<small style="font-size: 9px;"><?= $facility->name; ?></small></td>
				<td colspan="5" style="width: 50%; border-right: 1px solid black;"><b style="font-size: 10px;">ADDRESS:</b>&nbsp;<small style="font-size: 9px;"><?= $facility->address; ?></small></td>
			</tr>
			<tr style="border: 1px solid black;">
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">CITY, STATE &amp; ZIP:</b>&nbsp;<small style="font-size: 9px;"><?= $facility->city . ', ' . $facility->state . ', ' . $facility->zip; ?></small></td>
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">PHONE NO:</b>&nbsp;<small style="font-size: 9px;"><?= $facility->phone; ?></small></td>
				<td colspan="2" style="width: 20%; border-right: 1px solid black;"><b style="font-size: 10px;">FAX:</b>&nbsp;<small style="font-size: 9px;"><?= $facility->fax; ?></small></td>
				<td colspan="2" style="width: 20%; border-right: 1px solid black;"><b style="font-size: 10px;">NPI:</b>&nbsp;<small style="font-size: 9px;"><?= ' '; ?></small></td>
			</tr>
			<tr style="border: 1px solid black;">
				<td colspan="4" style="width: 40%; border-right: 1px solid black;"><b style="font-size: 10px;">REQUESTED DATE/TIME OF SERVICE:</b>&nbsp;<small style="font-size: 9px;"><?= $scheduledTime; ?></small></td>
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"></td>
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">TECHNOLOGIST:</b>&nbsp;<small style="font-size: 9px;"><?= $tech->title; ?></small></td>
			</tr>
			<tr style="border: 1px solid black;">
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">REFERRING DR'S NAME:</b>&nbsp;<small style="font-size: 9px;"><?= $referringPhysician->name; ?></small></td>
				<td colspan="2" style="width: 20%; border-right: 1px solid black;"><b style="font-size: 10px;">NPI:</b>&nbsp;<small style="font-size: 9px;"><?= ' '; ?></small></td>
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">PHONE NO:</b>&nbsp;<small style="font-size: 9px;"><?= ' '; ?></small></td>
				<td colspan="2" style="width: 20%; border-right: 1px solid black;"><b style="font-size: 10px;">FAX:</b>&nbsp;<small style="font-size: 9px;"><?= ' '; ?></small></td>
			</tr>
			<tr><td colspan="10"><br></td></tr>
			<tr><td colspan="10"><br></td></tr>
			<tr><td colspan="10"><br></td></tr>
			<tr style="border: 1px solid black;">
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">CPT CODE #1:</b>&nbsp;<small style="font-size: 9px;"><?= $cpt1->code; ?></small></td>
				<td colspan="5" style="width: 50%; border-right: 1px solid black;"><b style="font-size: 10px;">PROCEDURE #1:</b>&nbsp;<small style="font-size: 9px;"><?= $cpt1->description; ?></small></td>
				<td colspan="2" style="width: 20%; border-right: 1px solid black;"></td>
			</tr>
			<tr style="border: 1px solid black;">
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">CPT CODE #2:</b>&nbsp;<small style="font-size: 9px;"><?= $cpt2->code; ?></small></td>
				<td colspan="5" style="width: 50%; border-right: 1px solid black;"><b style="font-size: 10px;">PROCEDURE #2:</b>&nbsp;<small style="font-size: 9px;"><?= $cpt2->description; ?></small></td>
				<td colspan="2" style="width: 20%; border-right: 1px solid black;"></td>
			</tr><tr><td colspan="10"><br></td></tr>
			<tr><td colspan="10"><br></td></tr>
			<tr><td colspan="10"><br></td></tr>
			<tr><td colspan="10">SYMPTOMS:</td></tr>
			<tr style="border: 1px solid black;">
				<td colspan="2" style="width: 20%; border-right: 1px solid black;"><b style="font-size: 10px;">MEDICARE #:</b>&nbsp;<small style="font-size: 9px;"><?= ' '; ?></small></td>
				<td colspan="2" style="width: 20%; border-right: 1px solid black;"><b style="font-size: 10px;">MEDICAID #:</b>&nbsp;<small style="font-size: 9px;"><?= ' '; ?></small></td>
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">INSURANCE CO. :</b>&nbsp;<small style="font-size: 9px;"><?= $patient->insurancePlanName; ?></small></td>
				<td colspan="3" style="width: 30%; border-right: 1px solid black;"><b style="font-size: 10px;">POLICY GROUP/FECA #:</b>&nbsp;<small style="font-size: 9px;"><?= $patient->fecaOrIPGNo; ?></small></td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		PHYSICIAN'S SIGNATURE:&nbsp;&nbsp;&nbsp;_______________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;&nbsp;____/____/________

	</body>

</html>