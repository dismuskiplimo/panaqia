$(document).ready(function(){
	var conversation_route = $('#conversation-route').val();


	$('#compose-form').on('submit', function(e){
		e.preventDefault();

		var that = $(this);

		$.ajax({
			url: conversation_route,
			method: 'POST',
			data: that.serialize(),
			success: function(data){
				


				var str = 	'<span class = "row message">';
				str += 			'<div class="speech right text-right">';             
				str += 				'<div class="text-left">' +
		                                $('#message-content').val() + '<br>' +    
		                            '</div>' +
		                            
		                            '<small>now</small>' +
		                        '</div>' +
		                     '</span>';

		        $('#message-content').val('');

		        $('#message-content').trigger('autoresize');

		        var first = $('.message:last');

		        if(first.hasClass('first')){
		        	$('.message:last').hide();
		        }

				$('.message:last').after(str);

				var messages = $(".messages");

				messages.scrollTop(100000000);

			},

			error: function(xhr,status,error){

			},

			done: function(){

			}
		});
	});

	setInterval(function(){
		$.ajax({
			url: conversation_route,
			method: 'GET',
			datatype: 'JSON',
			success: function(data){

				if(data.messages.length > 0){
					$.each(data.messages, function(index, value){
						var str = '<span class = "message row">';

						if(value.owner == 'me'){
							str += 	'<div class="speech right text-right">';             
						}else{
							str += 	'<div class="speech left">';                   
						}


						str += 			'<div class="text-left">' +
	                                    	value.message + '<br>' +    
	                                	'</div>' +
	                                
	                                	'<small>' + value.time + '</small>' +
	                            	'</div>' +
	                            '</span>';

						 

						$('.message:last').after(str);

						$.snackbar({
							content:'new message received, scroll down to view',
							timeout: 5000,
							style:'toast,'
						});
					});

					$('.mini-messages-wrapper').getNiceScroll().resize();
				}
				
			},
			error: function(xhr,status,error){

			},

			done: function(){

			}
		});
	},10000);



});


