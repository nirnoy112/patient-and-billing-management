<?php

	/*****
	*
	* @File: 'views/patient/hcfa.php'.
	* @Author: NASID.
	* @CreatedOn: 16 MAY, 2017.
	* @LastUpdatedOn: 17 MAY, 2017.
	*
	*****/

	defined('BASEPATH') OR exit('No direct script access allowed');


?>

<div class="row" style="text-align: center; margin-top:20px;">
	<div class="col-sm-12" >
		<p>APPROVED BY NATIONAL UNIFORM CLAIM COMMITTEE 08/05</p>
	</div>
</div>

<div id="health-form" class="row" style="margin: 10px; padding: 20px; min-height: 500px; background-color: white;">
	<form method="post" action="">
		<input type="hidden" name="pid" value="<?php echo $patient->id; ?>">
		<div class="row">
			<div class="col-sm-9">
				<h5>1. PATIENT'S HEALTH PROGRAM</h5>
				<input type="radio" name="patient[hcfainstype]" value="MEDICARE" <?php if($patient->hcfainstype == 'MEDICARE') { echo 'checked'; } ?>><label for="medicare">MEDICARE<span></span></label>
				<input type="radio" name="patient[hcfainstype]" value="MEDICAID" <?php if($patient->hcfainstype == 'MEDICAID') { echo 'checked'; } ?>><label for="medicaid">MEDICAID<span></span></label>
				<input type="radio" name="patient[hcfainstype]" value="TRICARE" <?php if($patient->hcfainstype == 'TRICARE') { echo 'checked'; } ?>><label for="tricare">TRICARE<span></span></label>
				<input type="radio" name="patient[hcfainstype]" value="CHAMPVA" <?php if($patient->hcfainstype == 'CHAMPVA') { echo 'checked'; } ?>><label for="champva">CHAMPVA<span></span></label>
				<input type="radio" name="patient[hcfainstype]" value="GROUP HEALTH" <?php if($patient->hcfainstype == 'GROUP HEALTH') { echo 'checked'; } ?>><label for="group-health">GROUP HEALTH<span></span></label>
				<input type="radio" name="patient[hcfainstype]" value="FECA" <?php if($patient->hcfainstype == 'FECA') { echo 'checked'; } ?>><label for="feca">FECA<span></span></label>
				<input type="radio" name="patient[hcfainstype]" value="OTHER" <?php if($patient->hcfainstype == 'OTHER') { echo 'checked'; } ?>><label for="other">OTHER</label>
			</div>
			<div class="col-sm-3">
				<h5># ACTIVE PAYER (From the Attorneys)</h5>
				<select name="patient[payerAID]" class="form-control">
					<option value="0">NONE</option>
					<?php 
					foreach($all_attorneys as $attorney)
					{
						$selected = ($attorney['id'] == $patient->payerAID) ? ' selected="selected"' : "";

						echo '<option value="'.$attorney['id'].'" '.$selected.'>'.$attorney['name'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-9">
				<h5>1A. PATIENT'S FINANCIAL CLASS</h5>
				<input type="radio" name="patient[financialClass]" value="MEDICARE" <?php if($patient->financialClass == 'MEDICARE') { echo 'checked'; } ?>><label for="medicare">MEDICARE<span></span></label>
				<input type="radio" name="patient[financialClass]" value="ORTHOMEDICS" <?php if($patient->financialClass == 'ORTHOMEDICS') { echo 'checked'; } ?>><label for="orthomedics">ORTHOMEDICS<span></span></label>
				<input type="radio" name="patient[financialClass]" value="PIWC" <?php if($patient->financialClass == 'PIWC') { echo 'checked'; } ?>><label for="piwc">PERSONAL INJURY WC<span></span></label>
				<input type="radio" name="patient[financialClass]" value="PPO" <?php if($patient->financialClass == 'PPO') { echo 'checked'; } ?>><label for="ppo">PRIVATE INSURANCE(PPO)<span></span></label>
				<input type="radio" name="patient[financialClass]" value="IEHP" <?php if($patient->financialClass == 'IEHP') { echo 'checked'; } ?>><label for="iehp">IEHP</label>
			</div>
			<div class="col-sm-3">
				<h5>1B. INSURED'S I.D. NUMBER</h5>
				<input type="text" name="patient[insuredId]" size="30" value="<?php echo $patient->insuredId; ?>">
			</div>
		</div>

		<div class="row">

			<div class="col-sm-4">
				<h5>2. PATIENT'S NAME (Last Name, First Name, Middle Initial)</h5>
				<input type="text" name="patientName" size="30" value="<?php echo $patient->lastName . ' ' . $patient->firstName . ' ' . $patient->middleName; ?>">
			</div>
			<div class="col-sm-5">
				<div class="col-sm-6">
					<h5>3. PATIENT'S DOB</h5>
					<div class="input-group date">
						<input type="text" name="patient[dob]" value="<?php echo $patient->dob; ?>">
						<div class="input-group-addon">
					        <span class="glyphicon glyphicon-th"></span>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<h5>PATIENT'S SEX</h5>
						<input type="radio" name="patient[patientSex]" value="Male" <?php if($patient->patientSex == 'Male') { echo 'checked'; } ?>><label for="male">MALE<span></span></label>
						<input type="radio" name="patient[patientSex]" value="Female" <?php if($patient->patientSex == 'Female') { echo 'checked'; } ?>><label for="female">FEMALE</label>
				</div>
			</div>
			<div class="col-sm-3">
				<h5>4. INSURED'S NAME (Last Name, First Name, Middle Initial)</h5>
				<input type="text" name="patient[insuredName]" size="30" value="<?php echo $patient->insuredName; ?>">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<h5>5. PATIENT'S ADDRESS (STREET NUMBER)</h5>
						<input type="text" name="patient[streetNoP]" size="30" value="<?php echo $patient->streetNoP; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<h5>CITY</h5>
						<input type="text" name="patient[cityP]" size="15" value="<?php echo $patient->cityP; ?>">
					</div>
					<div class="col-sm-4">
						<h5>STATE</h5>
						<input type="text" name="patient[stateP]" size="5" value="<?php echo $patient->stateP; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5">
						<h5>ZIP CODE</h5>
						<input type="text" name="patient[zipCodeP]" size="8" value="<?php echo $patient->zipCodeP; ?>">
					</div>
					<div class="col-sm-7">
						<h5>TELEPHONE NUMBER</h5>
						<input type="text" name="patient[telephoneP]" size="15" value="<?php echo $patient->telephoneP; ?>">
					</div>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-12">
						<h5>6. PATIENT'S RELATIONSHIP TO INSURED</h5>
						<input type="radio" name="patient[insuredRelationId]" value="1" <?php if($patient->insuredRelationId == 1) { echo 'checked'; } ?>><label for="self"><span></span>SELF</label>
						<input type="radio" name="patient[insuredRelationId]" value="2" <?php if($patient->insuredRelationId == 2) { echo 'checked'; } ?>><label for="spouse"><span></span>SPOUSE</label>
						<input type="radio" name="patient[insuredRelationId]" value="3" <?php if($patient->insuredRelationId == 3) { echo 'checked'; } ?>><label for="child"><span></span>CHILD</label>
						<input type="radio" name="patient[insuredRelationId]" value="4" <?php if($patient->insuredRelationId == 4) { echo 'checked'; } ?>><label for="other"><span></span>OTHER</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h5>8. RESERVED FOR NUCC USE</h5>
						<textarea name="patient[reserved]" style="width:80%;"><?php echo $patient->reserved; ?></textarea>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-sm-12">
						<h5>7. INSURED'S ADDRESS (STREET NUMBER)</h5>
						<input type="text" name="patient[streetNoI]" size="30" value="<?php echo $patient->streetNoI; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<h5>CITY</h5>
						<input type="text" name="patient[cityI]" size="15" value="<?php echo $patient->cityI; ?>">
					</div>
					<div class="col-sm-4">
						<h5>STATE</h5>
						<input type="text" name="patient[stateI]" size="5" value="<?php echo $patient->stateI; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5">
						<h5>ZIP CODE</h5>
						<input type="text" name="patient[zipCodeI]" size="8" value="<?php echo $patient->zipCodeI; ?>">
					</div>
					<div class="col-sm-7">
						<h5>TELEPHONE NUMBER</h5>
						<input type="text" name="patient[telephoneI]" size="15" value="<?php echo $patient->telephoneI; ?>">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<h5>9. OTHER INSURED'S NAME (Last Name, First Name, Middle Initial)</h5>
						<input type="text" name="patient[nameOI]" size="30" value="<?php echo $patient->nameOI; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h5>A. OTHER INSURED'S PLOICY GROUP OR FECA NUMBER</h5>
						<input type="text" name="patient[policyOrGroupNoOI]" size="30" value="<?php echo $patient->policyOrGroupNoOI; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h5>B. RESERVED FOR NUCC USE</h5>
						<input type="text" name="patient[reservedNUCC1]" size="30" value="<?php echo $patient->reservedNUCC1; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h5>C. RESERVED FOR NUCC USE</h5>
						<input type="text" name="patient[reservedNUCC2]" size="30" value="<?php echo $patient->reservedNUCC2; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h5>D. INSURANCE PLAN NAME OR PROGRAM NAME</h5>
						<input type="text" name="patient[OIinsurancePlanName]" size="30" value="<?php echo $patient->OIinsurancePlanName; ?>">
					</div>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-12">
						<h5>10.  IS PATIENT'S CONDITION RELATED TO</h5>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12">
						<b>A. EMPLOYMENT? (Current or Previous)</b>
						<div class="row">
							<div class="col-sm-12">
								<input type="radio" name="patient[isEmployment]" value="YES" <?php if($patient->isEmployment == 'YES') { echo 'checked'; } ?>><label for="yes">YES<span></span></label>
								<input type="radio" name="patient[isEmployment]" value="NO" <?php if($patient->isEmployment == 'NO' || $patient->isEmployment == null) { echo 'checked'; } ?>><label for="no">NO</label>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-6"><b>B. AUTO ACCIDENT?</b></div>
							<div class="col-sm-6"><b>PLACE (STATE)</b></div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<input type="radio" name="patient[isAutoAccident]" value="YES" <?php if($patient->isAutoAccident == 'YES' || $patient->isAutoAccident == null) { echo 'checked'; } ?>><label for="yes">YES<span></span></label>
								<input type="radio" name="patient[isAutoAccident]" value="NO" <?php if($patient->isAutoAccident == 'NO') { echo 'checked'; } ?>><label for="no">NO</label>
							</div>
							<div class="col-sm-6"><input type="text" name="patient[stateOfAutoAccident]" size="15" value="<?php echo ($patient->stateOfAutoAccident != null)? $patient->stateOfAutoAccident : 'CA'; ?>"></div>
						</div>
						<br>
						<b>C. OTHER ACCIDENT?</b>
						<div class="row">
							<div class="col-sm-12">
								<input type="radio" name="patient[isOtherAccident]" value="YES" <?php if($patient->isOtherAccident == 'YES') { echo 'checked'; } ?>><label for="yes">YES<span></span></label>
								<input type="radio" name="patient[isOtherAccident]" value="NO" <?php if($patient->isOtherAccident == 'NO' || $patient->isOtherAccident == null) { echo 'checked'; } ?>><label for="no">NO</label>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12">
						<h5>10D. CLAIM CODES (Designated By NUCC)</h5>
						<input type="text" size="30" name="patient[reserved1]" value="<?php echo $patient->reserved1; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-sm-12">
						<h5>11. INSURED'S POLICY GROUP / FECA NUMBER</h5>
						<input type="text" name="patient[fecaOrIPGNo]" size="30" value="<?php echo $patient->fecaOrIPGNo; ?>">
					</div>
				</div>
				<div class="row">
						<div class="col-sm-6">
							<h5>A. INSURED'S DOB</h5>
							<div class="input-group date">
								<input type="text" size="10" name="patient[insuredDOB]" value="<?php echo $patient->insuredDOB; ?>">
								<div class="input-group-addon">
							        <span class="glyphicon glyphicon-th"></span>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<h5>SEX</h5>
							<input type="radio" name="patient[insuredSex]" value="Male" <?php if($patient->insuredSex == 'Male') { echo 'checked'; } ?>><label for="male">M<span></span></label>
								<input type="radio" name="patient[insuredSex]" value="Female" <?php if($patient->insuredSex == 'Female') { echo 'checked'; } ?>><label for="female">F</label>
						</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h5>B. EMPLOYER'S NAME / SCHOOL NAME</h5>
						<input type="text" name="patient[employerOrSchool]" size="30" value="<?php echo $patient->employerOrSchool; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h5>C. INSURANCE PLAN / PROGRAM NAME</h5>
						<input type="text" name="patient[insurancePlanName]" size="30" value="<?php echo $patient->insurancePlanName; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h5>D. IS THERE ANY HEALTH BENEFIT PLAN?</h5>
						<input type="radio" name="patient[haveAnotherPlan]" value="YES" <?php if($patient->haveAnotherPlan == 'YES') { echo 'checked'; } ?>><label for="yes">YES<span></span></label>
								<input type="radio" name="patient[haveAnotherPlan]" value="NO" <?php if($patient->haveAnotherPlan == 'NO') { echo 'checked'; } ?>><label for="no">NO</label>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-9">
				<h5>12. PATIENT'S  / AUTHORIZED PERSON'S SIGNATURE</h5>
				<div class="col-sm-6">
					SIGNED BY: <input type="text" size="25" name="patient[signatureFile]" value="<?php echo $patient->signatureFile; ?>">
				</div>
				<div class="col-sm-4">
					<div class="input-group date">
						DATE: <input type="text" name="patient[signatureDate]" value="<?php echo $patient->signatureDate; ?>">
						<div class="input-group-addon">
					        <span class="glyphicon glyphicon-th"></span>
						</div>
					</div>
				</div>
				<div class="col-sm-2"></div>
			</div>
			<div class="col-sm-3">
				<h5>13. INSURED'S  / AUTHORIZED PERSON'S SIGNATURE</h5>
				SIGNED BY: <input type="text" name="patient[IoAPSignatureFile]" value="<?php echo $patient->IoAPSignatureFile; ?>">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
			<div class="row">
				<div class="col-sm-12">
					<h5>14. DATE OF CURRENT ILLNESS (First Symptom), INJURY (Accident) or PREGNANCY (LMP)</h5>
				</div>
			</div>
				
				<div class="row">
						<div class="col-sm-5">
							<div class="input-group date">
								<input type="text" size="12" name="patient[dateOfCurrentIllness]" value="<?php echo $patient->dateOfCurrentIllness; ?>">
								<div class="input-group-addon">
							        <span class="glyphicon glyphicon-th"></span>
								</div>
							</div>
						</div>
						<label class="col-sm-2">QUAL</label>
						<div class="col-sm-3">
							<input type="text" size="10" name="patient[currentQual]" value="<?php echo $patient->currentQual; ?>">
						</div>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-12">
					<h5>15. OTHER DATE</h5>
					<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="input-group date">
							<input type="text" size="12" name="patient[similarIllnessFirstDate]" value="<?php echo $patient->similarIllnessFirstDate; ?>">
							<div class="input-group-addon">
						        <span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
					</div>
					<div class="col-sm-1"></div>
					<label class="col-sm-2">QUAL</label>
					<div class="col-sm-3">
						<input type="text" size="10" name="patient[otherQual]" value="<?php echo $patient->otherQual; ?>">
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<h5>16. DATES PATIENT UNABLE TO WORK IN CURRENT OCCUPATION</h5>
				FROM <input type="text" size="10" name="patient[inabilitySratingDate]" value="<?php echo $patient->inabilitySratingDate; ?>"> TO <input type="text" size="10" name="patient[inabilityEndingDate]" value="<?php echo $patient->inabilityEndingDate; ?>">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<h5>17. NAME OF REFERRING PHYSICIAN / OTHER SOURCE</h5>
				<input type="text" name="patient[nameOfRPorOS]" size="30" value="<?php echo $patient->nameOfRPorOS; ?>">
			</div>
			<div class="col-sm-5">
				<h5>17A.     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="patient[seventeenA]" size="25" value="<?php echo $patient->seventeenA; ?>"></h5>
				<h5>17B. NPI <input type="text" name="patient[seventeenB]" size="25" value="<?php echo $patient->seventeenB; ?>"></h5>
			</div>
			<div class="col-sm-3">
				<h5>18. HOSPITALIZATION DATES RELATED TO CURRENT SERVICES</h5>
				FROM <input type="text" size="10" name="patient[hospitalizationStartingDate]" value="<?php echo $patient->hospitalizationStartingDate; ?>"> TO <input type="text" size="10" name="patient[hospitalizationEndingDate]" value="<?php echo $patient->hospitalizationEndingDate; ?>">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-9">
				<h5>19. ADDITIONAL CLAIM INFORMATION (Designated By NUCC)</h5>
				<input type="text" size="40" name="patient[reserved2]" value="<?php echo $patient->reserved2; ?>">
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-sm-6"><h5>20. OUTSIDE LAB?</h5></div>
					<div class="col-sm-6"><h5>$ CHARGES</h5></div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<input type="radio" name="patient[outsideLab]" value="YES" <?php if($patient->outsideLab == 'YES') { echo 'checked'; } ?>><label for="yes">YES<span></span></label>
								<input type="radio" name="patient[outsideLab]" value="NO" <?php if($patient->outsideLab == 'NO') { echo 'checked'; } ?>><label for="no">NO</label>
					</div>
					<div class="col-sm-6">
						<input type="text" size="10" name="patient[outsideLabCharges]" value="<?php echo $patient->outsideLabCharges; ?>">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-9">
				<h5>21. DIAGNOSIS OR NATURE OF ILLNESS OR INJURY (Related Items A, B, C, D to Item 24E by line)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ICD Ind. <input type="text" name="patient[IcdInd]" size="10" value="<?php echo $patient->IcdInd; ?>"></h5>
				<br>
				<div class="row">
					<div class="col-sm-3">
						<span>A. </span><input type="text" name="patient[natureOfIllnessA]" size="15" value="<?php echo $patient->natureOfIllnessA; ?>">
					</div>
					<div class="col-sm-3">
						<span>B. </span><input type="text" name="patient[natureOfIllnessB]" size="15" value="<?php echo $patient->natureOfIllnessB; ?>">
					</div>
					<div class="col-sm-3">
						<span>C. </span><input type="text" name="patient[natureOfIllnessC]" size="15" value="<?php echo $patient->natureOfIllnessC; ?>">
					</div>
					<div class="col-sm-3">
						<span>D. </span><input type="text" name="patient[natureOfIllnessD]" size="15" value="<?php echo $patient->natureOfIllnessD; ?>">
					</div>
				</div>
				<div style="padding-top: 5px;" class="row">
					<div class="col-sm-3">
						<span>E. </span><input type="text" name="patient[natureOfIllnessE]" size="15" value="<?php echo $patient->natureOfIllnessE; ?>">
					</div>
					<div class="col-sm-3">
						<span>F. </span><input type="text" name="patient[natureOfIllnessF]" size="15" value="<?php echo $patient->natureOfIllnessF; ?>">
					</div>
					<div class="col-sm-3">
						<span>G. </span><input type="text" name="patient[natureOfIllnessG]" size="15" value="<?php echo $patient->natureOfIllnessG; ?>">
					</div>
					<div class="col-sm-3">
						<span>H. </span><input type="text" name="patient[natureOfIllnessH]" size="15" value="<?php echo $patient->natureOfIllnessH; ?>">
					</div>
				</div>
				<div style="padding-top: 5px;" class="row">
					<div class="col-sm-3">
						<span>&nbsp;I. </span><input type="text" name="patient[natureOfIllnessI]" size="15" value="<?php echo $patient->natureOfIllnessI; ?>">
					</div>
					<div class="col-sm-3">
						<span>J. </span><input type="text" name="patient[natureOfIllnessJ]" size="15" value="<?php echo $patient->natureOfIllnessJ; ?>">
					</div>
					<div class="col-sm-3">
						<span>K. </span><input type="text" name="patient[natureOfIllnessK]" size="15" value="<?php echo $patient->natureOfIllnessK; ?>">
					</div>
					<div class="col-sm-3">
						<span>L. </span><input type="text" name="patient[natureOfIllnessL]" size="15" value="<?php echo $patient->natureOfIllnessL; ?>">
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<h5>22. RESUBMISSION</h5>
				<small>CODE </small><input type="text" name="patient[medResubmissionCode]" size="5" value="<?php echo $patient->medResubmissionCode; ?>"><small> ORIGINAL REF. NO. </small><input type="text" name="patient[originalRefNo]" size="5" value="<?php echo $patient->originalRefNo; ?>">
				<h5>23. PRIOR AUTHORIZATION NUMBER</h5>
				<input type="text" name="patient[prioprAuthNo]" size="20" value="<?php echo $patient->prioprAuthNo; ?>">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<h5>24. DETAILS OF DIAGNOSTIC PROCEDURES ORDERED BY THE PATIENT</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1"><h5>#</h5></div>
			<div class="col-sm-11">
				<h5 style="text-align: center;" class="col-sm-2">A. DATE(S) OF SERVICE</h5>
				<h5 style="text-align: center;" class="col-sm-1">B</h5>
				<h5 style="text-align: center;" class="col-sm-1">C</h5>
				<h5 style="text-align: center;" class="col-sm-2">D. PROCEDURES, SERVICES OR SUPPLIES</h5>
				<h5 style="text-align: center;" class="col-sm-1">E</h5>
				<h5 style="text-align: center;" class="col-sm-1">F</h5>
				<h5 style="text-align: center;" class="col-sm-1">G</h5>
				<h5 style="text-align: center;" class="col-sm-1">H</h5>
				<h5 style="text-align: center;" class="col-sm-1">I</h5>
				<h5 style="text-align: center;" class="col-sm-1">J</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1"><label>SERIAL NO.</label></div>
			<div class="col-sm-11">
				<label class="col-sm-1">STARTING DATE</label>
				<label class="col-sm-1">ENDING DATE</label>
				<label class="col-sm-1">PLACE OF SERVICE</label>
				<label class="col-sm-1">EMG</label>
				<label class="col-sm-1">CPT/HCPCS</label>
				<label class="col-sm-1">MODIFIER</label>
				<label class="col-sm-1">DIAGNOSIS POINTER</label>
				<label class="col-sm-1">CHARGES</label>
				<label class="col-sm-1">DAYS/UNITS</label>
				<label class="col-sm-1">EPSDT Family Plan</label>
				<label class="col-sm-1">ID. QUAL</label>
				<label class="col-sm-1">RESERVED FOR LOCAL USE</label>
			</div>
		</div>
			<?php
				for($counter = 0; $counter < 12; $counter++) {
			?>
			<div class="col-sm-1"><h5><?= $counter + 1; ?></h5></div>
			<div class="col-sm-11">
				<input type="hidden" name="ids[<?= $counter; ?>]" value="<?= $procedures[$counter]['id'] ?>">
				<input type="hidden" name="procedures[<?= $counter; ?>][patientId]" value="<?= $procedures[$counter]['patientId'] ?>">
				<div class="col-sm-1">
					<input size="7" type="text" name="procedures[<?= $counter; ?>][dateFrom]" value="<?php if($procedures[$counter]['dateFrom'] == null || $procedures[$counter]['dateFrom'] == '') { echo ''; } else { echo $procedures[$counter]['dateFrom']; } ?>">
				</div>
				<div class="col-sm-1">
					<input size="7" type="text" name="procedures[<?= $counter; ?>][dateTo]" value="<?php if($procedures[$counter]['dateTo'] == null || $procedures[$counter]['dateTo'] == '') { echo ''; } else { echo $procedures[$counter]['dateTo']; } ?>">
				</div>
				<div class="col-sm-1">
					<input size="7" type="text" name="procedures[<?= $counter; ?>][placeOfService]" value="<?php if($procedures[$counter]['placeOfService'] == null || $procedures[$counter]['placeOfService'] == '') { echo ''; } else { echo $procedures[$counter]['placeOfService']; } ?>">
				</div>
				<div class="col-sm-1">
					<input size="7" type="text" name="procedures[<?= $counter; ?>][emg]" value="<?php if($procedures[$counter]['emg'] == null || $procedures[$counter]['emg'] == '') { echo ''; } else { echo $procedures[$counter]['emg']; } ?>">
				</div>
				<div class="col-sm-1">
					<select style="width: 70px;" name="procedures[<?= $counter; ?>][cptId]">
						<option value="0">0</option>
						<?php 
						foreach($all_cptcodes as $cptcode)
						{
							$selected = ($cptcode['id'] == $procedures[$counter]['cptId']) ? ' selected="selected"' : "";

							echo '<option value="' . $cptcode['id'] . '" ' . $selected . '>' . $cptcode['code'] . '</option>';
						} 
						?>
					</select>
				</div>
				<div class="col-sm-1">
					<input size="7" type="text" name="procedures[<?= $counter; ?>][modifier]" value="<?php if($procedures[$counter]['modifier'] == null || $procedures[$counter]['modifier'] == '') { echo ''; } else { echo $procedures[$counter]['modifier']; } ?>">
				</div>
				<div class="col-sm-1">
					<input size="7" type="text" name="procedures[<?= $counter; ?>][diagnosisPointer]" value="<?php if($procedures[$counter]['diagnosisPointer'] == null || $procedures[$counter]['diagnosisPointer'] == '') { echo ''; } else { echo $procedures[$counter]['diagnosisPointer']; } ?>">
				</div>
				<div class="col-sm-1"><input size="7" type="text" name="procedures[<?= $counter; ?>][charges]" value="<?php if($procedures[$counter]['charges'] == null || $procedures[$counter]['charges'] == '') { echo ''; } else { echo sprintf("%.2f", $procedures[$counter]['charges']); } ?>"></div>
				<div class="col-sm-1"><input size="7" type="text" name="procedures[<?= $counter; ?>][daysOrUnits]" value="<?php if($procedures[$counter]['daysOrUnits'] == null || $procedures[$counter]['daysOrUnits'] == '') { echo ''; } else { echo $procedures[$counter]['daysOrUnits']; } ?>"></div>
				<div class="col-sm-1"><input size="7" type="text" name="procedures[<?= $counter; ?>][epsdt]" value="<?php if($procedures[$counter]['epsdt'] == null || $procedures[$counter]['epsdt'] == '') { echo ''; } else { echo $procedures[$counter]['epsdt']; } ?>"></div>
				<div class="col-sm-1">
					<div class="row">
						<div class="col-sm-6">
							
						</div>
						<div class="col-sm-6">
							<h5>NPI</h5>
						</div>
					</div>
				</div>
				<div class="col-sm-1"><input type="text" size="12" name="procedures[<?= $counter; ?>][reserved]" value="<?php if($procedures[$counter]['reserved'] == null || $procedures[$counter]['reserved'] == '') { echo ''; } else { echo $procedures[$counter]['reserved']; } ?>"></div>
    		</div>
    		<!-- <div class="col-sm-12" style="width: 50px;"></div> -->
			<?php
				}
			?>

			<div class="row">
				<div class="col-sm-12">
					<div class="col-sm-2">
						<h5>25. FEDERAL TAX I.D. NO.</h5>
						<input type="text" name="patient[federalTaxID]" size="15" value="<?php echo $patient->federalTaxID; ?>">
					</div>
					<div class="col-sm-1">
						<h5>SSN&nbsp;|&nbsp;EIN</h5>
						<input type="radio" name="patient[isSSN]" value="YES" <?php if($patient->isSSN == 'YES') { echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="patient[isSSN]" value="NO" <?php if($patient->isSSN == 'NO') { echo 'checked'; } ?>>
					</div>
					<div class="col-sm-2">
						<h5>26. PATIENT ACCOUNT NO.</h5>
						<input type="text" name="patient[patientAccNo]" size="15" value="<?php echo $patient->patientAccNo; ?>">
					</div>
					<div class="col-sm-2">
						<h5>27. ACCEPT ASSIGNMENT?</h5>
						<input type="radio" name="patient[doesAcceptAssignment]" value="YES" <?php if($patient->doesAcceptAssignment == 'YES') { echo 'checked'; } ?>><label for="yes">YES<span></span></label>
									<input type="radio" name="patient[doesAcceptAssignment]" value="NO" <?php if($patient->doesAcceptAssignment == 'NO') { echo 'checked'; } ?>><label for="no">NO</label>
					</div>
					<div class="col-sm-2">
						<h5>28. TOTAL CHARGES</h5>
						<input type="text" name="patient[totalCharges]" size="8" value="<?php echo sprintf("%.2f", $patient->totalCharges); ?>">
					</div>
					<div class="col-sm-2">
						<h5>29. AMOUNT PAID</h5>
						<input type="text" name="patient[amountPaid]" size="8" value="<?php echo sprintf("%.2f", $patient->amountPaid); ?>">
					</div>
					<div class="col-sm-1">
						<h5>30. DUE</h5>
						<input type="text" name="patient[totalDue]" size="8" value="<?php echo sprintf("%.2f", $patient->totalDue); ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<h5>31. SIGNATURE OF PHYSICIAN OR SUPPLIER INCLUDING DEGREE OR CREDENTIALS</h5>
					<div class="col-sm-6">
						<small>SIGNED: </small><input type="text" size="10" name="patient[PhyOrSpplrSignature]" value="<?php echo $patient->PhyOrSpplrSignature; ?>">
					</div>
					<div class="col-sm-6">
						<div class="input-group date">
							<small>DATE: </small><input type="text" size="8" name="patient[PhyOrSpplrSigDate]" value="<?php echo $patient->PhyOrSpplrSigDate; ?>">
							<div class="input-group-addon">
						        <span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<h5>32. SERVICE FACILITY LOCATION INFORMATION</h5>
					<textarea rows="3"  name="patient[SFLInfo]" style="width:100%;"><?php echo $patient->SFLInfo; ?></textarea>
					<div class="row">
						<div class="col-sm-6">
							<small>A: </small><input type="text" size="15" name="patient[SFLInfoA]" value="<?php echo $patient->SFLInfoA; ?>">
						</div>
						<div class="col-sm-6">
							<small>B: </small><input type="text" size="15" name="patient[SFLInfoB]" value="<?php echo $patient->SFLInfoB; ?>">
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<h5>33. BILLING PROVIDER INFORMATION AND PHONE NO.</h5>
					<textarea rows="3" name="patient[BillingProviderInfo]" style="width:100%;"><?php echo $patient->BillingProviderInfo; ?></textarea>
					<div class="row">
						<div class="col-sm-6">
							<small>A: </small><input type="text" size="15" name="patient[BillingProviderInfoA]" value="<?php echo $patient->BillingProviderInfoA; ?>">
						</div>
						<div class="col-sm-6">
							<small>B: </small><input type="text" size="15" name="patient[BillingProviderInfoB]" value="<?php echo $patient->BillingProviderInfoB; ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style="text-align: center; padding-top: 20px;">
				<button type="submit" name="save_hcfa" id="save_hcfa" value="save_hcfa" class="btn btn-s-lg btn-primary btn-rounded no_border">SAVE</button>&nbsp;&nbsp;&nbsp;&nbsp; OR &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel" id="cancel" value="cancel" class="btn btn-s-lg btn-warning btn-rounded no_border">CANCEL</button>
			</div>
	</form>
</div>