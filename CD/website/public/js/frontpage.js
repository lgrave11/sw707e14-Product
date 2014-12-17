$(function() {
	$("#hourpicker").datetimepicker({
  		datepicker:false,
  		format:'H',
  		formatTime: 'H'
	});

	$("#minutepicker").datetimepicker({
  		datepicker:false,
  		format: 'i',
  		formatTime: 'i',
  		step: 5,
  		onlyTime: true
	});

	$("#datepicker").datetimepicker({
  		datepicker:true,
  		format: 'd/m/Y',
  		formatDate: 'd/m/Y',
  		timepicker: false,
  		minDate: 0,
  		maxDate: '+2/1/1970',
  		scrollInput: false,
  		scrollMonth: false,
  		dayOfWeekStart: 1,
  		closeOnDateSelect: true
	});
})

$('#bookform').submit(function ( event ) {
    var errors = '';
    $('#messages').html();
    
    if ($('#stations').val() == null) {
        errors += '<div class="error">Please select a station</div>';
    }
    if ($('#datepicker').val() == '' || $('#datepicker').val().split('/').length != 3) {
        errors += '<div class="error">Incorrect date selected</div>';
    }
    if ($('#hourpicker').val() == '' || isNaN($('#hourpicker').val())) {
        errors += '<div class="error">Incorrect hour selected</div>';
    }
    if ($('#minutepicker').val() == '' || isNaN($('#minutepicker').val())) {
        errors += '<div class="error">Incorrect minute selected</div>';
    }
    
    if (errors != '') {
        $('#messages').html(errors);
        event.preventDefault();
        return false;
    } else {
        return true;
    }
});
