$(function() {
	$("#admin_fromdatepicker").datetimepicker({
  		datepicker:true,
  		format: 'd/m/Y H:i',
  		scrollInput: false,
  		scrollMonth: false,
  		dayOfWeekStart: 1,
  		closeOnDateSelect: true
	});

	$("#admin_todatepicker").datetimepicker({
  		datepicker:true,
  		format: 'd/m/Y H:i',
  		scrollInput: false,
  		scrollMonth: false,
  		dayOfWeekStart: 1,
  		closeOnDateSelect: true
	});
})