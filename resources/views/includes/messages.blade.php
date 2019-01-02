
@if(Session::has('success'))
	<div class="alert alert-success" role="alert">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					{{ Session::get('success') }}.
				</div>
			</div>
		</div>
	</div>
@endif


@if(Session::has('error'))
	<div class="alert alert-danger" role="alert">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<strong>Error!</strong> {{ Session::get('error') }}.
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($errors))
	<div class="alert alert-danger" role="alert">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<strong>Error!</strong>
					
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					
				</div>
			</div>
		</div>
	</div>
@endif