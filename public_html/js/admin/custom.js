$(document).ready(function(){
	if($('#map').length > 0){
		var iframe = $('#map').find('iframe').get(0);
		
		if(iframe.length > 0){
			iframe.attr('width', '100%');
		}
			
	}

	$('#logout-button').on('click', function(e){
		$('#logout-form').submit();
	});
	
});