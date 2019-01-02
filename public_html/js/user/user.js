$(document).ready(function(){
	var user_route = $('#update-user').val();

	setInterval(function(){
		$.ajax({
			url: user_route,
			method: 'GET',
			success: function(data){
				console.log(data);
			},

			error: function(){

			}
		});
	},10000);

	$('.close-account-button').on('click', function (e){
		e.preventDefault();

		swal({
			title : 'Close Account?',
			message: 'Are you Sure you wnt to close your account?',
			icon: 'error',
			dangerMode: true,
			buttons: true
			
		}).then((willDelete) => {
		  if (willDelete) {
		    $('.close-account-form').submit();
		  }
		});
	});
});