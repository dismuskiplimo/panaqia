$(document).ready(function(){
	var discussion_route 	= $('#discussion-route');
	var discussion_count 	= $('#discussion-count');
	var discussions 		= $('.discussions');


	if($('.discussions-wrapper').length > 0){
		setInterval(function(){
			$.ajax({
				url: discussion_route.val(),
				method: 'GET',
				datatype: 'JSON',
				success(data){
					if(data.status == 200){
						if(data.count != $('#discussion-count').val()){

							var str = '';

							$('#discussion-count').val(data.count);
							
							$('.discussions').html('');

							
							$.each(data.discussions, function(index, value){
									str += 	'<div class="discussion">' +
				                  				'<img src="' + value.avatar + '" class="responsive-img circle" alt="im">' +
				                        		'<span>' +
						                            '<strong><a href="' + value.url + '">' + value.name + '</a></strong><br>' + 
						                            value.position + '<br>'+
						                            
						                            value.message + ' <br>' +

						                            '<span class="right"><strong>' + value.time + '</strong></span>' +  
				                        		'</span>' +
				                    		'</div>';


				 				
							});

							$('.discussions').html(str);

			 				$('.discussions-wrapper').getNiceScroll().resize();	

			 				

						}
					}
				},
				error: function(){

				}
			});
		},10000);
	}

});