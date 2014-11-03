$(function() {
	$("#admin_fromhourpicker").datetimepicker({
  		datepicker:false,
  		format:'H',
  		formatTime: 'H'
	});

	$("#admin_fromminutepicker").datetimepicker({
  		datepicker:false,
  		format: 'i',
  		formatTime: 'i',
  		step: 5,
  		onlyTime: true
	});

	$("#admin_fromdatepicker").datetimepicker({
  		datepicker:true,
  		format: 'd/m/Y',
  		formatDate: 'd/m/Y',
  		timepicker: false,
  		scrollInput: false,
  		scrollMonth: false,
  		dayOfWeekStart: 1,
  		closeOnDateSelect: true
	});
    
    $("#admin_tohourpicker").datetimepicker({
  		datepicker:false,
  		format:'H',
  		formatTime: 'H'
	});

	$("#admin_tominutepicker").datetimepicker({
  		datepicker:false,
  		format: 'i',
  		formatTime: 'i',
  		step: 5,
  		onlyTime: true
	});

	$("#admin_todatepicker").datetimepicker({
  		datepicker:true,
  		format: 'd/m/Y',
  		formatDate: 'd/m/Y',
  		timepicker: false,
  		scrollInput: false,
  		scrollMonth: false,
  		dayOfWeekStart: 1,
  		closeOnDateSelect: true
	});
})