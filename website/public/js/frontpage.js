$(function() {
	$("#hourpicker").datetimepicker({
  		datepicker:false,
  		format:'H',
  		formatTime: 'H'
	});

	$("#minutepicker").datetimepicker({
  		datepicker:false,
  		format:'i',
  		step: 5,
  		roundTime: 'ceil',
  		minTime: '00',
  		maxTime: '55',
  		formatTime: 'i'
	});

	$("#datepicker").datetimepicker({
  		datepicker:true,
  		formatDate: 'd/m/Y',
  		timepicker: false,
  		minDate: 0,
  		maxDate: '+7/1/1970',
  		scrollInput: false,
  		scrollMonth: false
	});
})