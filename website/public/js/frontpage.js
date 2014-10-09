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
  		maxDate: '+7/1/1970',
  		scrollInput: false,
  		scrollMonth: false,
  		dayOfWeekStart: 1
	});
})