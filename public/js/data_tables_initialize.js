// Create Bootstrap Data Tables - https://datatables.net/examples/styling/bootstrap.html
$(document).ready(function() {
	//$('#example').dataTable();
	//$('.esp_table').dataTable();
	
	$('.esp_table').dataTable({
		paging: false,
		'columnDefs': [ { 'targets': '_all', 'orderable': false } ],
	});
} );