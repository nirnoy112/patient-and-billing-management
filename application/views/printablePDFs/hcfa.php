<?php

	/*****
	*
	* @File: 'views/printablePDFs/hcfa.php'.
	* @Author: NASID.
	* @CreatedOn: 22 MAY, 2017.
	* @LastUpdatedOn: 23 MAY, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');


?>
	<h5>HEALTH INSURANCE CLAIM FORM</h5>
	<table style="width: 100%; border: 2px solid black; border-collapse: none;">
		<tr class="oddrow">
			<td  colspan="2" style="width: 65%; border-right: 1px solid black;">1. PATIENT'S FINANCIAL CLASS / PATIENT'S HEALTH PROGRAM</td>
			<td style="width: 35%;">1A. INSURED'S ID NUMBER (For the item in 1)</td>
		</tr>
		<tr class="evenrow">
			<td colspan="2" style="width: 65%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="finalcialClass" value="MEDICARE" <?php if($patient->financialClass == 'MEDICARE') { echo 'checked = "checked"'; } ?> />&nbsp;MEDICARE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="finalcialClass" value="ORTHOMEDICS" <?php if($patient->financialClass == 'ORTHOMEDICS') { echo 'checked = "checked"'; } ?> />&nbsp;ORTHOMEDICS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="finalcialClass" value="PIWC" <?php if($patient->financialClass == 'PIWC') { echo 'checked = "checked"'; } ?> />&nbsp;PIWC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="finalcialClass" value="PPO" <?php if($patient->financialClass == 'PPO') { echo 'checked = "checked"'; } ?> />&nbsp;PPO
			</td>
			<td style="width: 35%;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->insuredId; ?></td>
		</tr>
		<tr class="oddrow">
			<td style="width: 35%; border-right: 1px solid black;">2. PATIENT'S NAME<br />&nbsp;&nbsp;&nbsp;&nbsp;(Last Name, First Name)</td>
			<td style="width: 30%; border-right: 1px solid black;">3. PATIENT'S BIRTH DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SEX<br />&nbsp;&nbsp;&nbsp;&nbsp;MM-DD-YY</td>
			<td style="width: 35%;">4. INSURED'S NAME<br />&nbsp;&nbsp;&nbsp;&nbsp;(Last Name, First Name)</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->lastName . ' ' . $patient->firstName; ?></td>
			<td style="width: 30%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php if($patient->dob == null || $patient->dob == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->dob; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="sex" value="M" <?php if($patient->patientSex == 'Male') { echo 'checked = "checked"'; } ?> />&nbsp;M&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="sex" value="F" <?php if($patient->patientSex == 'Female') { echo 'checked = "checked"'; } ?> />&nbsp;F
			</td>
			<td style="width: 35%;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->insuredName; ?></td>
		</tr>
		<tr class="oddrow">
			<td style="width: 30%; border-right: 1px solid black;">5. PATIENT'S ADDRESS (STREET NUMBER)</td>
			<td style="width: 30%; border-right: 1px solid black;">6. PATIENT-INSURED RELATION</td>
			<td style="width: 35%;">7. INSURED'S ADDRESS (STREET NUMBER)</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->streetNoP; ?></td>
			<td style="width: 30%; border-right: 1px solid black;">
				<input type="checkbox" name="insuredRelationId" value="1" <?php if($patient->insuredRelationId == 1) { echo 'checked = "checked"'; } ?> />Self&nbsp;&nbsp;<input type="checkbox" name="insuredRelationId" value="2" <?php if($patient->insuredRelationId == 2) { echo 'checked = "checked"'; } ?> />Spouse&nbsp;&nbsp;<input type="checkbox" name="insuredRelationId" value="3" <?php if($patient->insuredRelationId == 3) { echo 'checked = "checked"'; } ?> />Child&nbsp;&nbsp;<input type="checkbox" name="insuredRelationId" value="4" <?php if($patient->insuredRelationId == 4) { echo 'checked = "checked"'; } ?> />Other
			</td>
			<td style="width: 35%;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->streetNoI; ?></td>
		</tr>
		<tr class="oddrow">
			<td style="width: 30%; border-right: 1px solid black;">
				CITY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STATE
			</td>
			<td style="width: 30%; border-right: 1px solid black;">8. PATIENT'S STATUS</td>
			<td style="width: 35%;">
				CITY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STATE
			</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php if($patient->cityP == null || $patient->cityP == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->cityP; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->stateP; ?>
			</td>
			<td rowspan="3" style="width: 30%; border-right: 1px solid black;">
				<input type="checkbox" name="patientStatusId" value="1" <?php if($patient->patientStatusId == 1) { echo 'checked = "checked"'; } ?> />&nbsp;Single&nbsp;&nbsp;<input type="checkbox" name="patientStatusId" value="2" <?php if($patient->patientStatusId == 2) { echo 'checked = "checked"'; } ?> />&nbsp;Married&nbsp;&nbsp;<input type="checkbox" name="patientStatusId" value="3" <?php if($patient->patientStatusId == 3) { echo 'checked = "checked"'; } ?> />&nbsp;Other<br /><input type="checkbox" name="patientStatusId" value="4" <?php if($patient->patientStatusId == 4) { echo 'checked = "checked"'; } ?> />&nbsp;Employed&nbsp;&nbsp;<input type="checkbox" name="patientStatusId" value="5" <?php if($patient->patientStatusId == 5) { echo 'checked = "checked"'; } ?> />&nbsp;Full-Time Student&nbsp;&nbsp;<input type="checkbox" name="patientStatusId" value="6" <?php if($patient->patientStatusId == 6) { echo 'checked = "checked"'; } ?> />&nbsp;Part-Time Student<br /><br />
			</td>
			<td style="width: 35%;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php if($patient->cityI == null || $patient->cityI == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->cityI; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->stateI; ?>
			</td>
		</tr>
		<tr class="oddrow">
			<td style="width: 30%; border-right: 1px solid black;">ZIP CODE</td>
			<td style="width: 35%;">ZIP CODE</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->zipCodeP; ?></td>
			<td style="width: 35%;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->zipCodeI; ?></td>
		</tr>
		<tr class="oddrow">
			<td style="width: 35%; border-right: 1px solid black;">9. OTHER INSURED'S NAME<br />&nbsp;&nbsp;&nbsp;&nbsp;(Last Name, First Name)</td>
			<td style="width: 30%; border-right: 1px solid black;">10. IS PATIENT'S CONDITION <br />RELATED TO</td>
			<td style="width: 35%;">11. INSURED'S POLICY GROUP / FECA NUMBER</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->nameOI; ?></td>
			<td rowspan="7" style="width: 30%; border-right: 1px solid black;">
				A. EMPLOYMENT?<br>(Current/Previous)
				<br>
				&nbsp;&nbsp;<input type="checkbox" name="isEmployment" value="YES" <?php if($patient->isEmployment == 'YES') { echo 'checked = "checked"'; } ?> />&nbsp;YES&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="isEmployment" value="NO" <?php if($patient->isEmployment == 'NO') { echo 'checked = "checked"'; } ?> />&nbsp;NO
				<br><br>
				B. AUTO ACCIDENT?&nbsp;|&nbsp;STATE
				<br>
				&nbsp;&nbsp;<input type="checkbox" name="isAutoAccident" value="YES" <?php if($patient->isAutoAccident == 'YES') { echo 'checked = "checked"'; } ?> />&nbsp;YES&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="isAutoAccident" value="NO" <?php if($patient->isAutoAccident == 'NO') { echo 'checked = "checked"'; } ?> />&nbsp;NO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $patient->stateOfAutoAccident; ?>
				<br><br>
				C. OTHER ACCIDENT?
				<br>
				&nbsp;&nbsp;<input type="checkbox" name="isOtherAccident" value="YES" <?php if($patient->isOtherAccident == 'YES') { echo 'checked = "checked"'; } ?> />&nbsp;YES&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="isOtherAccident" value="NO" <?php if($patient->isOtherAccident == 'NO') { echo 'checked = "checked"'; } ?> />&nbsp;NO
			</td>
			<td style="width: 35%;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->fecaOrIPGNo; ?></td>
		</tr>
		<tr class="oddrow">
			<td style="width: 30%; border-right: 1px solid black;">9A. OTHER INSURED'S PLOICY GROUP / FECA NUMBER</td>
			<td style="width: 35%;">11A. INSURED'S BIRTH DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SEX<br />&nbsp;&nbsp;&nbsp;&nbsp;MM-DD-YY</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->policyOrGroupNoOI; ?></td>
			<td style="width: 35%;">&nbsp;&nbsp;&nbsp;&nbsp;<?php if($patient->insuredDOB == null || $patient->insuredDOB == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->insuredDOB; } ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="sex" value="M" <?php if($patient->insuredSex == 'Male') { echo 'checked = "checked"'; } ?> />&nbsp;M&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="sex" value="F" <?php if($patient->insuredSex == 'Female') { echo 'checked = "checked"'; } ?> />&nbsp;F
			</td>
		</tr>
		<tr class="oddrow">
			<td style="width: 30%; border-right: 1px solid black;">9B. OTHER INSURED'S DOB&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SEX<br />&nbsp;&nbsp;&nbsp;&nbsp;MM-DD-YY</td>
			<td style="width: 35%;">11B. EMPLOYER'S NAME / SCHOOL NAME</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php if($patient->dobOI == null || $patient->dobOI == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->dobOI; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="sex" value="M" <?php if($patient->sexOI == 'Male') { echo 'checked = "checked"'; } ?> />&nbsp;M&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="sex" value="F" <?php if($patient->sexOI == 'Female') { echo 'checked = "checked"'; } ?> />&nbsp;F
			</td>
			<td style="width: 35%;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->employerOrSchool; ?>
			</td>
		</tr>
		<tr class="oddrow">
			<td style="width: 30%; border-right: 1px solid black;">9C. EMPLOYER'S NAME / SCHOOL NAME</td>
			<td style="width: 35%;">11C. INSURANCE PLAN / PROGRAM NAME</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->OIemployerOrSchool; ?>
			</td>
			<td style="width: 35%;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->insurancePlanName; ?>
			</td>
		</tr>
		<tr class="oddrow">
			<td style="width: 35%; border-right: 1px solid black;">9D. INSURANCE PLAN / PROGRAM NAME</td>
			<td style="width: 30%; border-right: 1px solid black;">10D.RESERVE FOR LOCAL USE</td>
			<td style="width: 35%;">11D. HAVE ANOTHER HEALTH BENEFIT PLAN?</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->OIinsurancePlanName; ?>
			</td>
			<td style="width: 30%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->reserved1; ?>
			</td>
			<td style="width: 35%;">
				<input type="checkbox" name="haveAnotherPlan" value="YES" <?php if($patient->haveAnotherPlan == 'YES') { echo 'checked = "checked"'; } ?> />&nbsp;YES&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="haveAnotherPlan" value="NO" <?php if($patient->haveAnotherPlan == 'NO') { echo 'checked = "checked"'; } ?> />&nbsp;NO&nbsp;&nbsp;If YES, Complete Item 9 A-D.
			</td>
		</tr>
		<tr class="oddrow">
			<td  colspan="2" style="width: 65%; border-right: 1px solid black;">12. PATIENT'S  / AUTHORIZED PERSON'S SIGNATURE</td>
			<td style="width: 35%;">13. INSURED'S  / AUTHORIZED PERSON'S SIGNATURE</td>
		</tr>
		<tr class="evenrow">
			<td colspan="2" style="width: 65%; border-right: 1px solid black;">
				SIGNED BY:&nbsp;&nbsp;_____________________________________&nbsp;&nbsp;&nbsp;&nbsp;DATE:&nbsp;&nbsp;_______________
			</td>
			<td style="width: 35%;">SIGNED BY:&nbsp;&nbsp;_________________________</td>
		</tr>
		<tr class="oddrow">
			<td style="width: 35%; border-right: 1px solid black;">14. DATE OF CURRENT ILLNESS / INJURY / PREGNANCY<br />&nbsp;&nbsp;&nbsp;&nbsp;MM-DD-YY</td>
			<td style="width: 30%; border-right: 1px solid black;">15. IF THE PATIENT HAD SIMILAR ILLNESS, GIVE THE FIRST DATE<br />&nbsp;&nbsp;&nbsp;&nbsp;MM-DD-YY</td>
			<td style="width: 35%;">16. DATES PATIENT UNABLE TO WORK IN CURRENT OCCUPATION<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MM-DD-YY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MM-DD-YY</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->dateOfCurrentIllness; ?>
			</td>
			<td style="width: 30%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->similarIllnessFirstDate; ?>
			</td>
			<td style="width: 35%;">
				FROM&nbsp;&nbsp;&nbsp;<?php if($patient->inabilitySratingDate == null || $patient->inabilitySratingDate == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->inabilitySratingDate; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->inabilityEndingDate; ?>
			</td>
		</tr>
		<tr class="oddrow">
			<td style="width: 35%; border-right: 1px solid black;">17. NAME OF REFERRING PHYSICIAN / OTHER SOURCE</td>
			<td style="width: 30%; border-right: 1px solid black;">17A. I.D. NUMBER OF REFERRING PHYSICIAN</td>
			<td style="width: 35%;">18. HOSPITALIZATION DATES RELATED TO CURRENT SERVICES<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MM-DD-YY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MM-DD-YY</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->nameOfRPorOS; ?>
			</td>
			<td style="width: 30%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->seventeenA; ?>
			</td>
			<td style="width: 35%;">
				FROM&nbsp;&nbsp;&nbsp;<?php if($patient->hospitalizationStartingDate == null || $patient->hospitalizationStartingDate == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->hospitalizationStartingDate; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->hospitalizationEndingDate; ?>
			</td>
		</tr>
		<tr class="oddrow">
			<td  colspan="2" style="width: 65%; border-right: 1px solid black;">19. RESERVED FOR LOCAL USE</td>
			<td style="width: 35%;">20. OUTSIDE LAB?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CHARGES</td>
		</tr>
		<tr class="evenrow">
			<td colspan="2" style="width: 65%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->reserved2; ?>
			</td>
			<td style="width: 35%;">
				<input type="checkbox" name="outsideLab" value="YES" <?php if($patient->outsideLab == 'YES') { echo 'checked = "checked"'; } ?> />&nbsp;YES&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="outsideLab" value="NO" <?php if($patient->outsideLab == 'NO') { echo 'checked = "checked"'; } ?> />&nbsp;NO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$&nbsp;<?php echo $patient->outsideLabCharges; ?>
			</td>
		</tr>
		<tr class="oddrow">
			<td  colspan="2" style="width: 65%; border-right: 1px solid black;">21. DIAGNOSIS OR NATURE OF ILLNESS OR INJURY (Related Items 1, 2, 3, 4 to Item 24E by line)</td>
			<td style="width: 35%;">22. MEDICAID SUBMISSION <br>&nbsp;&nbsp;&nbsp;&nbsp;CODE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ORIGINAL REF. NO.</td>
		</tr>
		<tr class="evenrow">
			<td colspan="2" rowspan="3" style="width: 65%; border-right: 1px solid black;">
				&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp;&nbsp;&nbsp;<?php if($patient->natureOfIllness01 == null || $patient->natureOfIllness01 == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->natureOfIllness01; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.&nbsp;&nbsp;&nbsp;<?php if($patient->natureOfIllness03 == null || $patient->natureOfIllness03 == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->natureOfIllness03; } ?><br><br>&nbsp;&nbsp;&nbsp;&nbsp;2.&nbsp;&nbsp;&nbsp;<?php if($patient->natureOfIllness02 == null || $patient->natureOfIllness02 == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->natureOfIllness02; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.&nbsp;&nbsp;&nbsp;<?php if($patient->natureOfIllness04 == null || $patient->natureOfIllness04 == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->natureOfIllness04; } ?>
			</td>
			<td style="width: 35%;">
				&nbsp;&nbsp;&nbsp;&nbsp;<?php if($patient->medResubmissionCode == null || $patient->medResubmissionCode == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->medResubmissionCode; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->originalRefNo; ?>
			</td>
		</tr>
		<tr class="oddrow">
			<td style="width: 35%;">23. PRIOR AUTHORIZATION NUMBER</td>
		</tr>
		<tr class="evenrow">
			<td style="width: 35%;">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $patient->prioprAuthNo; ?>
			</td>
		</tr>
	</table>
	<table style="width: 100%; border: 2px solid black; border-collapse: none;">
		<tr class="oddrow">
			<th style="width: 6%; border-right: 1px solid black;">24.</th>
			<th style="width: 13%; border-right: 1px solid black;">A</th>
			<th style="width: 16%; border-right: 1px solid black;">B</th>
			<th style="width: 16%; border-right: 1px solid black;">C</th>
			<th style="width: 16%; border-right: 1px solid black;">D</th>
			<th style="width: 11%; border-right: 1px solid black;">E</th>
			<th style="width: 8%; border-right: 1px solid black;">F</th>
			<th style="width: 11%; border-right: 1px solid black;">G</th>
			<th style="width: 6%; border-right: 1px solid black;">H</th>
			<th style="width: 6%; border-right: 1px solid black;">I</th>
			<th style="width: 13%">J</th>
		</tr>
		<tr class="oddrow">
			<td style="width: 6%; border-right: 1px solid black;">#</td>
			<td style="width: 13%; border-right: 1px solid black;">CPT CODE</td>
			<td style="width: 16%; border-right: 1px solid black;">ANATOMICAL POSITION</td>
			<td style="width: 16%; border-right: 1px solid black;">ICD CODE</td>
			<td style="width: 16%; border-right: 1px solid black;">DIAGNOSTIC DEFINITIVE</td>
			<td style="width: 11%; border-right: 1px solid black;">$ CHARGES</td>
			<td style="width: 8%; border-right: 1px solid black;">DAYS/ UNITS</td>
			<td style="width: 11%; border-right: 1px solid black;">EBSDT Pamily Plan</td>
			<td style="width: 6%; border-right: 1px solid black;">EMG</td>
			<td style="width: 6%; border-right: 1px solid black;">COB</td>
			<td style="width: 13%">RESERVED FOR LOCAL USE</td>
		</tr>
		<?php
			for($counter = 0; $counter < 6; $counter++) {

				$pCptcode = '';

				foreach($all_cptcodes as $cptcode) {

					if($cptcode['id'] == $procedures[$counter]['cptId']) {
						$pCptcode = $cptcode['code'];
					}

				}

				$pIcdcode = '';

				foreach($all_icdcodes as $icdcode){

					if($icdcode['id'] ==  $procedures[$counter]['icdId']) {
						$pIcdcode = $icdcode['code'];
					}

				}

				$pDefinitive = '';

				foreach($all_definitives as $definitive) {

					if($definitive['id'] == $procedures[$counter]['definitiveId']) {
						$pDefinitive = $definitive['value'];
					}

				}
		?>

		<tr class="procedure-row">
			<td style="width: 6%; border-right: 1px solid black;"><?= $counter + 1; ?></td>
			<td style="width: 13%; border-right: 1px solid black;"><?= $pCptcode; ?></td>
			<td style="width: 16%; border-right: 1px solid black;"><?php if($procedures[$counter]['anatomicalPosition'] == 'NONE' || $procedures[$counter]['anatomicalPosition'] == '' || $procedures[$counter]['anatomicalPosition'] == null) {} else { echo $procedures[$counter]['anatomicalPosition']; } ?></td>
			<td style="width: 16%; border-right: 1px solid black;"><?= $pIcdcode; ?></td>
			<td style="width: 16%; border-right: 1px solid black;"><?= $pDefinitive; ?></td>
			<td style="width: 11%; border-right: 1px solid black;"></td>
			<td style="width: 8%; border-right: 1px solid black;"></td>
			<td style="width: 11%; border-right: 1px solid black;"></td>
			<td style="width: 6%; border-right: 1px solid black;"></td>
			<td style="width: 6%; border-right: 1px solid black;"></td>
			<td style="width: 13%"></td>
		</tr>
		<?php
			}
		?>
		<tr class="oddrow">
			<td colspan="3" style="width: 35%; border-right: 1px solid black;">25. FEDERAL TAX I.D. NO.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SSN&nbsp;&nbsp;&nbsp;&nbsp;EIN</td>
			<td style="width: 16%; border-right: 1px solid black;">26. PATIENT ACCOUNT NO.</td>
			<td style="width: 16%; border-right: 1px solid black;">27. ACCEPT ASSIGNMENT?</td>
			<td colspan="2" style="width: 19%; border-right: 1px solid black;">28. TOTAL CHARGES</td>
			<td colspan="2" style="width: 17%; border-right: 1px solid black;">29. AMOUNT PAID</td>
			<td colspan="2" style="width: 19%">30. BALANCE DUE</td>
		</tr>
		<tr class="procedure-row">
			<td colspan="3" style="width: 35%; border-right: 1px solid black;">
				&nbsp;&nbsp;<?php if($patient->federalTaxID == null || $patient->federalTaxID == '') { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } else { echo $patient->federalTaxID; } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="isSSN" value="YES" <?php if($patient->isSSN == 'YES') { echo 'checked = "checked"'; } ?> />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="isEIN" value="YES" <?php if($patient->isEIN == 'YES') { echo 'checked = "checked"'; } ?> />
			</td>
			<td style="width: 16%; border-right: 1px solid black;">
				<?= $patient->patientAccNo; ?>
			</td>
			<td style="width: 16%; border-right: 1px solid black;"><input type="checkbox" name="doesAcceptAssignment" value="YES" <?php if($patient->doesAcceptAssignment == 'YES') { echo 'checked = "checked"'; } ?> />&nbsp;YES&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="doesAcceptAssignment" value="NO" <?php if($patient->doesAcceptAssignment == 'NO') { echo 'checked = "checked"'; } ?> />&nbsp;NO</td>
			<td colspan="2" style="width: 19%; border-right: 1px solid black;">&nbsp;$&nbsp;<?= $patient->totalCharges; ?></td>
			<td colspan="2" style="width: 17%; border-right: 1px solid black;">&nbsp;$&nbsp;<?= $patient->amountPaid; ?></td>
			<td colspan="2" style="width: 19%">&nbsp;$&nbsp;<?= $patient->totalDue; ?></td>
		</tr>
	</table>