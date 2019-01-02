$(document).ready(function(){

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	var message_count_url = $('#message-count-url').val();
	var notifications_url = $('#notifications-url').val();

	function calculateFeaturedPrice(){
		var price = $('#featured_price').val();
		var days  = $('#days-1').val();

		var total = (price*days).toLocaleString();

		$('#featured_total').html(total);
	};

	if($('#featured_total').length > 0){
		calculateFeaturedPrice();
	}

	$('#days-1').on('change', function(){
		calculateFeaturedPrice();

		if($(this).val() > 0){
			$('#feature_button').attr('disabled', false);
		}else{
			$('#feature_button').attr('disabled', true);
		}
		
	});

	$('#logout-button').on('click', function(e){
		$('#logout-form').submit();
	});

	$('select').material_select();


	$('.file-button').on('click', function(){
		$(this).siblings('.file-input').click();
	});

	$('.file-input').on('change', function(e){
		$(this).parent().submit();
	});


	$('.start-date, .end-date').datetimepicker({
		format : 'YYYY-MM-DD',
		minDate: new Date(),
	});


	$('.start-time, .end-time').datetimepicker({
		format : 'HH:mm',
	});

	$('.full-time').datetimepicker({
		format : 'YYYY-MM-DD HH:mm:ss',
	});

	

	$('.print').on('click', function(e){
		window.print();
	});

	if($('.drop-photo').length > 0){
		$('.drop-photo').imageReader();
	}

	if($('.chats-wrapper').length > 0){
		$('.chats-wrapper').niceScroll({
			grabcursorenabled: false,
		});
	}

	if($('.mini-messages-wrapper').length > 0){
		// $('.mini-messages-wrapper').niceScroll({
		// 	grabcursorenabled: false,
		// 	autohidemode: false,
		// });

		// $('.mini-messages-wrapper').getNiceScroll(0).doScrollTop($('.messages').height());

		var messages = $(".messages");

		messages.scrollTop(messages.prop("scrollHeight"));
	}


	if($('.discussions-wrapper').length > 0){
		$('.discussions-wrapper').niceScroll({
			grabcursorenabled: false,
		});

		$('.discussions-wrapper').getNiceScroll(0).doScrollTop($('.discussions').height());
	}

	

	// $('.datepicker').pickadate({
	// 	selectMonths: true, // Creates a dropdown to control month
	// 	selectYears: 15, // Creates a dropdown of 15 years to control year,
	// 	today: 'Today',
	// 	clear: 'Clear',
	// 	close: 'Ok',
	// 	closeOnSelect: false // Close upon selecting a date,
	// });

	// $('.timepicker').pickatime({
	//     default: 'now', // Set default time: 'now', '1:30AM', '16:30'
	//     fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
	//     twelvehour: false, // Use AM/PM or 24-hour format
	//     donetext: 'OK', // text for done-button
	//     cleartext: 'Clear', // text for clear-button
	//     canceltext: 'Cancel', // Text for cancel-button
	//     autoclose: false, // automatic close timepicker
	//     ampmclickable: true, // make AM PM clickable
	//     aftershow: function(){} //Function for after opening timepicker
 //  	});


 if($('.hero-box').length > 0){
 	$('.hero-box').css('height', $(window).height() + 'px')
 }


 if($('.match-height').length > 0){
 	$('.match-height').matchHeight();
 }

 $('#featured-carousel').on('mouseenter', function(){
 	$(this).carousel('pause');
 });

 $('#featured-carousel').on('mouseleave', function(){
 	$(this).carousel('cycle');
 });


 setInterval(function(){
 	$.ajax({
 		url: notifications_url,
		method: 'GET',
		datatype: 'JSON',
		success : function(data){
			if(data.count == 0){
				$('#notification-count').html('');
			}else{
				$('#notification-count').html(data.count);
			}
			
		},
		error: function(xhr,status,error){
			console.log(xhr.responseText);
		}
	});


	$.ajax({
 		url: message_count_url,
		method: 'GET',
		datatype: 'JSON',
		success : function(data){
			if(data.count == 0){
				$('#message-count').html('');
			}else{
				$('#message-count').html(data.count);
			}
			
		},
		error: function(xhr,status,error){
			console.log(xhr.responseText);
		}
	});

 },10000);


 $('#discussion-form').on('submit', function(e){
 	e.preventDefault();

 	var that = $(this);

 	$.ajax({
 		url: 	that.attr('action'),
 		method: that.attr('method'),
 		data: 	that.serialize(),
 		datatype: 'JSON',
 		success: function(data){
 			if(data.status == 200){
 				var str = 	'<div class="discussion">' +
                  				'<img src="' + data.user.avatar + '" class="responsive-img circle" alt="im">' +
                        		'<span>' +
		                            '<strong><a href="' + data.user.url + '">' + data.user.name + '</a></strong><br>' + 
		                            data.user.position + '<br>'+
		                            
		                            data.user.message + ' <br>' +

		                            '<span class="right"><strong>' + data.user.time + '</strong></span>' +  
                        		'</span>' +
                    		'</div>';


 				$('.discussion:last').after(str);

 				$('#message-content').val('');

 				$('.discussions-wrapper').getNiceScroll().resize();

				$('.discussions-wrapper').getNiceScroll(0).doScrollTop($('.discussions').height());

				
 			}
 		},
 		error: function(){

 		}
 	});
 });

 if($('.grid').length > 0){
 	var qsRegex;

	var $grid = $('.grid').isotope({
		// options
		itemSelector: '.grid-item',
		layoutMode: 'fitRows',
		filter: function() {
			return qsRegex ? $(this).text().match( qsRegex ) : true;
		}
	});

	// use value of search field to filter
	var $quicksearch = $('.quicksearch').keyup( debounce( function() {
		qsRegex = new RegExp( $quicksearch.val(), 'gi' );
		$grid.isotope();
	}, 200 ) );

	// debounce so filtering doesn't happen every millisecond
	function debounce( fn, threshold ) {
		var timeout;
		
		threshold = threshold || 100;
		
		return function debounced() {
			clearTimeout( timeout );
			var args = arguments;
			var _this = this;
			function delayed() {
				fn.apply( _this, args );
			}

			timeout = setTimeout( delayed, threshold );
		}
	}
 }


});