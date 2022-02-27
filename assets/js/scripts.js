$(function() {

	$("#patientSection").modal('show');
	
	$("#attachmentSection").modal('show');

    $("#printingSection").modal('show');
    
    $("#sendingSection").modal('show');

    $("#assigningSection").modal('show');

    $("#directProcessingSection").modal('show');

    $("#paymentSection").modal('show');

	//$("#load-patient-link").css('display', 'none');

    $('#close_asign').click(function(e) {

        e.preventDefault();
        
        $("#assigningSection").modal('hide');

    });
    
    $('#close_send').click(function(e) {

        e.preventDefault();
        
        $("#sendingSection").modal('hide');

    });

    $('#close_print').click(function(e) {

        e.preventDefault();
        
        $("#printingSection").modal('hide');

    });

    $('#close_direct').click(function(e) {

        e.preventDefault();
        
        $("#directProcessingSection").modal('hide');

    });

	var location = window.location.href;

	if(location.search('order') > 0) {

		$('#order-menu-link').addClass('active');

	} else if(location.search('patient') > 0) {

        $('#patient-menu-link').addClass('active');

    } else if(location.search('report') > 0) {

        $('#report-menu-link').addClass('active');

    } else {

		$('#lists-menu-link').addClass('active');

	}

	$('.input-group.date').datepicker({

	    format: "mm-dd-yyyy",
		orientation: "auto left",
	    autoclose: true,
	    todayHighlight: true,
	    toggleActive: true

	});

	$('.input-daterange').each(function() {

	    $(this).datepicker({

		    format: "mm-dd-yyyy",
		    orientation: "auto left",
		    autoclose: true,
		    toggleActive: true

		});

	});

	$("#modal-search-link").click(function(e) {

        e.preventDefault();
        
        var pid = $("#query_pid").val();

        var apiUrl = $("#api_url").val() + pid;

        $.get(apiUrl, function(data, status){

        	var response = JSON.parse(data);

            if(response.resultCount > 0) {

            	$('#firstNameRes').val(response.patient.firstName);
            	$('#lastNameRes').val(response.patient.lastName);
            	$('#dobRes').val(response.patient.dob);
            	$('#pidRes').val(response.patient.PID);
            	$('#financialClassRes').val(response.patient.financialClass);

                var content = '<div class="row">' + response.patient.firstName + ' ' + response.patient.lastName + ' ( PID: ' + response.patient.PID + ') ' + '  <a id="load-patient-link" href="" class="btn btn-xs btn-info">LOAD PATIENT</a></div>';

                $('#search-result').html(content);

            	//$("#load-patient-link").css('display', 'block');

            	$('#query-response').html('Patient Does EXIST!');

                $("#load-patient-link").click(function(e) {

                    e.preventDefault();

                    $('#pidF').val($('#pidRes').val());
                    $('#lastNameF').val($('#lastNameRes').val());
                    $('#firstNameF').val($('#firstNameRes').val());
                    $('#dobF').val($('#dobRes').val());
                    $('#financialClassF').val($('#financialClassRes').val());

                    $('#search-result').html('');

                    $('#query-response').html('<b>Patient LOADED!</b>');
                    $('#query-response').css('color', 'green');

                });

            } else {

                //$("#load-patient-link").css('display', 'none');

                $('#search-result').html('No Patient Found');

            	$('#query-response').html('Patient Does Not EXIST!');

            }

        });


    });

    $("#modal-search-link-ln").click(function(e) {

        e.preventDefault();
        
        var ln = $("#query_ln").val();

        var apiUrl = $("#ln_api_url").val() + ln;

        $.get(apiUrl, function(data, status){

            var response = JSON.parse(data);

            //alert(data + ' ' + response);

            if(response.resultCount > 0) {

                var content = '';

                /*$('#firstNameRes').val(response.patient.firstName);
                $('#lastNameRes').val(response.patient.lastName);
                $('#dobRes').val(response.patient.dob);
                $('#pidRes').val(response.patient.PID);
                $('#financialClassRes').val(response.patient.financialClass);*/

                var patients = response.patients;
                var pCount = response.resultCount;


                //content = pCount + ' ' + patients + ' ' + patients.length;

                var i;

                for(i = 0; i < pCount; i++) {

                    //var pData = {PID: response.patients[i].PID, firstName: response.patients[i].firstName, lastName: response.patients[i].lastName, dob: response.patients[i].dob, financialClass: response.patients[i].financialClass};

                    var partialContent = '<div class="row">' + patients[i].firstName + ' ' + patients[i].lastName + ' ( PID: ' + patients[i].PID + ') ' + ' <a class="load-patient-link-ln" value="' + patients[i].PID + ',' + patients[i].lastName + ',' + patients[i].firstName + ',' + patients[i].dob + ',' + patients[i].financialClass + '" href="" class="btn btn-xs btn-info">LOAD PATIENT</a></div>';
                    //var partialContent = '<div class="row">' + patients[i].firstName + ' ' + patients[i].lastName + ' ( PID: ' + patients[i].PID + ') ' + ' <a class="load-patient-link-ln" onclick="loadPatient(' + String(patients[i].PID) + ', ' + String(patients[i].firstName) + ', ' + String(patients[i].lastName) + ', ' + String(patients[i].dob) + ', ' + String(patients[i].financialClass) + ')" href="" class="btn btn-xs btn-info">LOAD PATIENT</a></div>';
                    //var partialContent = '<div class="row">' + patients[i].firstName + ' ' + patients[i].lastName + ' ( PID: ' + patients[i].PID + ') ' + ' <a class="load-patient-link-ln" onclick="loadPatient(' + String(patients[i].PID + ', ' + patients[i].firstName + ', ' + patients[i].lastName + ', ' + patients[i].dob + ', ' + patients[i].financialClass) + ')" href="" class="btn btn-xs btn-info">LOAD PATIENT</a></div>';


                    content = content + partialContent;

                }

                /*for (var i = 0; i < Things.length; i++) {
                    Things[i]
                }*/

                //for (var i = patients.length - 1; i >= 0; i--) {

                    //var partialContent = '<div class="row">' + patients[i].firstName + ' ' + patients[i].lastName + ' ( PID: ' + patients[i].PID + ') ' + '  <a class="load-patient-link-ln" href="" class="btn btn-xs btn-info">LOAD PATIENT</a></div>';
                    //var partialContent = '<div class="row">' + patients[0] + '</div>';

                    //content = content + partialContent;

                //}


                $('#search-result').html(content);

                $('#ln-query-response').html(response.resultCount + ' Patient(s) Exist(s).');



                $(".load-patient-link-ln").click(function(e) {
                    e.preventDefault();
                    var patientValue = $(this).attr('value');
                    //alert(pid);
                    //alert('hii');
                    //loadPatient();
                    var patient = patientValue.split(',');

                    $('#pidF').val(patient[0]);
                    $('#lastNameF').val(patient[1]);
                    $('#firstNameF').val(patient[2]);
                    $('#dobF').val(patient[3]);
                    $('#financialClassF').val(patient[4]);

                    $('#search-result').html('');

                    $('#ln-query-response').html('<b>Patient LOADED!</b>');
                    $('#ln-query-response').css('color', 'green');


                });

            } else {

                $('#ln-query-response').html('No Patient Exists.');
                $('#search-result').html('No Patient Found');

            }

        });


    });

    /*$("#load-patient-link").click(function(e) {

        e.preventDefault();

        $('#pidF').val($('#pidRes').val());
        $('#lastNameF').val($('#lastNameRes').val());
        $('#firstNameF').val($('#firstNameRes').val());
        $('#dobF').val($('#dobRes').val());
        $('#financialClassF').val($('#financialClassRes').val());

        $("#load-patient-link").css('display', 'none');

        $('#query-response').html('<b>Patient LOADED!</b>');
        $('#query-response').css('color', 'green');

    });*/

    $("#select-all-link-p").click(function(e) {

        e.preventDefault();

        $('#optP1').prop('checked', true);
        $('#optP2').prop('checked', true);
        $('#optP3').prop('checked', true);
        $('#optP4').prop('checked', true);

    });

    $("#select-all-link-s").click(function(e) {

        e.preventDefault();

        $('#optS1').prop('checked', true);
        $('#optS2').prop('checked', true);
        $('#optS3').prop('checked', true);
        $('#optS4').prop('checked', true);

    });

    $("#select-all-link-d").click(function(e) {

        e.preventDefault();

        $('#optD1').prop('checked', true);
        $('#optD2').prop('checked', true);
        $('#optD3').prop('checked', true);
        $('#optD4').prop('checked', true);

    });

    /*var loadPatient = function(pid) {

        alert('PID: ' + pid);

    };*/



    

});

/*var loadPatient = function(p, fn, ln, d, fc) {

    //alert('PID: ' + p);

    $('#pidF').val(p);
    $('#lastNameF').val(fn);
    $('#firstNameF').val(ln);
    $('#dobF').val(d);
    $('#financialClassF').val(fc);

    $('#search-result').html('');

    $('#ln-query-response').html('<b>Patient LOADED!</b>');
    $('#ln-query-response').css('color', 'green');

};*/

//var loadPatient = function(p) {

    //alert('PID: ' + p);

    /*$('#pidF').val(p);
    $('#lastNameF').val(fn);
    $('#firstNameF').val(ln);
    $('#dobF').val(d);
    $('#financialClassF').val(fc);*/

    /*$('#search-result').html('');

    $('#ln-query-response').html('<b>Patient LOADED!</b>');
    $('#ln-query-response').css('color', 'green');*/

    /*$.get(apiUrl, function(data, status){

        var response = JSON.parse(data);

        if(response.resultCount > 0) {

            $('#firstNameRes').val(response.patient.firstName);
            $('#lastNameRes').val(response.patient.lastName);
            $('#dobRes').val(response.patient.dob);
            $('#pidRes').val(response.patient.PID);
            $('#financialClassRes').val(response.patient.financialClass);

            

        }

    });*/

//};

/*var loadPatient = function(pData) {

    alert('Patient Data: ' + pData.PID);
    //document.getElementById("pidF").value = "New text";

    //document.getElementById("pidF").innerHTML = pid;

};*/

var loadPatient = function(pData) {
                    console.log('yes');
                    alert('Patient Data: ' + pData);

                };