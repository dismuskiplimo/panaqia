@extends('layouts.admin')

@section('title', $title)

@section('content')
	

	<div class="row">
		<div class="col-sm-6">
			<div class="white-box">
				<h3 class="box-title">GENERAL</h3>

				<form action="{{ route('admin.general.update') }}" method = "POST" class="form-material">
					@csrf

					
					<div class="form-group">
						<label for="">Support Phone</label>

	                    <input type="text" name = "support_phone" value = "{{ $options->support_phone }}" class="form-control">
		                
					</div>

					<div class="form-group">
						<label for="">Support Email</label>

	                    <input type="email" name = "support_email" value = "{{ $options->support_email }}" class="form-control">
		               
					</div>

					<div class="form-group">
						<label for="">Paypal Email</label>

		                <input type="email" name = "paypal_email" value = "{{ $options->paypal_email }}" class="form-control">
		                
					</div>

					<div class="form-group">
						<label for="">Site Currency</label>

	                    <select name="currency" id="" class="form-control" required="">
	                    	@foreach($currencies as $currency)
								<option value="{{ $currency->code }}"{{ $options->currency == $currency->code ? ' selected' : '' }}>{{ $currency->code }}</option>
	                    	@endforeach
	                    </select>
		                
					</div>


					<div class="form-group">
						<label for="">Paypal Currency</label>

	                    <select name="paypal_currency" id="" class="form-control" required="">
	                    	@foreach($currencies as $currency)
								<option value="{{ $currency->code }}"{{ $options->paypal_currency == $currency->code ? ' selected' : '' }}>{{ $currency->code }}</option>
	                    	@endforeach
	                    </select>
		                
					</div>

					<div class="form-group">
						<label for="">Event Commission (%)</label>
						
						<div class="input-group">
							<input type="number" min="0" max="100" name = "event_commission" value = "{{ $options->event_commission }}" class="form-control" required="">
							<span class="input-group-addon">%</span>	
						</div>  
					</div>

					<div class="form-group">
						<label for="">Exchange Rate ({{ $options->currency . '-' . $options->paypal_currency }})</label>

		                <input type="number" min="1" name = "exchange_rate" value = "{{ $options->exchange_rate }}" class="form-control" required="">
		                
					</div>

					<div class="form-group">
						<label for="">Feature Cost Per Day ({{ $options->currency }})</label>

		                <input type="number" min="1" name = "featured_price" value = "{{ $options->featured_price }}" class="form-control" required="">
		                
					</div>				
					

					<button type = "submit" class="btn btn-info">Update</button>
				</form>
			</div>	


			<div class="white-box">
	        	<h3 class="box-title">EMAIL SETTINGS</h3>

	        	<form action="{{ route('admin.site-settings.emails.update') }}" method = "POST">
	        		@csrf
					
					<div class="form-group">
	            		<label for="">Email Enabled</label>
	            		<select name="mail_enabled" required="" class="form-control" id="">
	            			<option value="1"{{ $options->mail_enabled == '1' ? ' selected' : ''  }}>YES</option>
	            			<option value="0"{{ $options->mail_enabled == '0' ? ' selected' : ''  }}>NO</option>
	            			
	            		</select>
	            	</div>
					
					<div class="form-group">
	            		<label for="">Sender Name</label>
	            		<input type="text"  name="mail_user_name" required=""  value = "{{ $options->mail_user_name }}" class="form-control">
	            	</div>

	            	<div class="form-group">
	            		<label for="">Sender Email</label>
	            		<input type="text"  name="mail_user_email" required=""  value = "{{ $options->mail_user_email }}" class="form-control">
	            	</div>

	            	<div class="form-group">
	            		<label for="">Email Driver</label>
	            		<select name="mail_driver" required="" class="form-control" id="">
	            			<option value="smtp"{{ $options->mail_driver == 'smtp' ? ' selected' : ''  }}>SMTP</option>
	            			<option value="sparkpost"{{ $options->mail_driver == 'sparkpost' ? ' selected' : ''  }}>SPARKPOST</option>
	            			
	            		</select>
	            	</div>

					<div class="form-group">
	            		<label for="">Email Host</label>
	            		<input type="text"  name="mail_host" required=""  value = "{{ $options->mail_host }}" class="form-control">
	            	</div>

	            	<div class="form-group">
	            		<label for="">Email Port</label>
	            		<input type="number"  name="mail_port" required=""  value = "{{ $options->mail_port }}" class="form-control">
	            	</div>


	            	<div class="form-group">
	            		<label for="">Email Username</label>
	            		<input type="text"  name="mail_username" required=""  value = "{{ $options->mail_username }}" class="form-control">
	            	</div>

	            	<div class="form-group">
	            		<label for="">Email Password</label>
	            		<input type="text"  name="mail_password" required=""  value = "{{ $options->mail_password }}" class="form-control">
	            	</div>

	            	<div class="form-group">
	            		<label for="">Email Encryption</label>
	            		<select name="mail_encryption" required="" class="form-control" id="">
	            			<option value="ssl"{{ $options->mail_encryption == 'ssl' ? ' selected' : ''  }}>SSL</option>
	            			<option value="tls"{{ $options->mail_encryption == 'tls' ? ' selected' : ''  }}>TLS</option>
	            			<option value="none"{{ is_null($options->mail_encryption) ? ' selected' : ''  }}>NONE</option>
	            		</select>
	            	</div>

	            	<div class="form-group">
	            		<label for="">Sparkpost Secret</label>
	            		<input type="text"  name="sparkpost_secret"  value = "{{ $options->sparkpost_secret }}" class="form-control">
	            	</div>

	            	<button type = "submit" class="btn btn-info">UPDATE</button>

	        	</form>
	        </div>
	        

	    	
		</div>


		<div class="col-sm-6">
			<div class="white-box">
				<h3 class="box-title">PAYMENTS</h3>
			
				<form action="{{ route('admin.gateways.update') }}" method = "POST" class="form-material">
					@csrf
					
					<div class="form-group">
						<label for="">Paypal Mode</label>
			            
			            <select name="paypal_mode" id="" class="form-control" required="">
							
							<option value="sandbox"{{ $options->paypal_mode == 'sandbox' ? ' selected' : '' }}>
								SANDBOX
							</option>

							<option value="live"{{ $options->paypal_mode == 'live' ? ' selected' : '' }}>
								LIVE
							</option>
	                    </select>
		               
					</div>	

					<div class="form-group">
						<label for="">Paypal Client ID (sandbox)</label>

		                <input type="text" name = "paypal_client_id_sandbox" value = "{{ $options->paypal_client_id_sandbox }}" class="form-control" required="">
		               
					</div>

					<div class="form-group">
						<label for="">Paypal Secret (sandbox)</label>

		                <input type="text" name = "paypal_secret_sandbox" value = "{{ $options->paypal_secret_sandbox }}" class="form-control" required="">
		                
					</div>

					<div class="form-group">
						<label for="">Paypal Client ID (live)</label>
					
		                    <input type="text" name = "paypal_client_id_live" value = "{{ $options->paypal_client_id_live }}" class="form-control" required="">
		               
					</div>

					<div class="form-group">
						<label for="">Paypal Secret (live)</label>

		                <input type="text" name = "paypal_secret_live" value = "{{ $options->paypal_secret_live }}" class="form-control" required="">
		                
					</div>

					<h3 class="box-title">MPESA</h3>

					<div class="form-group">
						<label for="">MPESA Mode</label>
  	
	                   	<select name="mpesa_mode" id="" class="form-control" required="">
							<option value="sandbox"{{ $options->mpesa_mode == 'sandbox' ? ' selected' : '' }}>
								SANDBOX
							</option>

							<option value="live"{{ $options->mpesa_mode == 'live' ? ' selected' : '' }}>
								LIVE
							</option>
	                    </select>
		               
					</div>	

					<div class="form-group">
						<label for="">MPESA Consumer Key (sandbox)</label>

		                <input type="text" name = "mpesa_consumer_key_sandbox" value = "{{ $options->mpesa_consumer_key_sandbox }}" class="form-control" required="">
		                
					</div>

					<div class="form-group">
						<label for="">MPESA Consumer Secret (sandbox)</label>

		                <input type="text" name = "mpesa_consumer_secret_sandbox" value = "{{ $options->mpesa_consumer_secret_sandbox }}" class="form-control" required="">
					</div>

					<div class="form-group">
						<label for="">MPESA Consumer Key (live)</label>

		                <input type="text" name = "mpesa_consumer_key_live" value = "{{ $options->mpesa_consumer_key_live }}" class="form-control" required="">
		                
					</div>

					<div class="form-group">
						<label for="">MPESA Consumer Secret (live)</label>

		                <input type="text" name = "mpesa_consumer_secret_live" value = "{{ $options->mpesa_consumer_secret_live }}" class="form-control" required="">
 
					</div>

					<div class="form-group">
						<label for="">MPESA Shortcode(paybill number)</label>

		                <input type="text" name = "mpesa_shortcode" value = "{{ $options->mpesa_shortcode }}" class="form-control" required="">
 
					</div>

					<div class="form-group">
						<label for="">MPESA Passkey</label>

		                <input type="text" name = "mpesa_passkey" value = "{{ $options->mpesa_passkey }}" class="form-control" required="">
 
					</div>

					<div class="form-group">
						<label for="">MPESA Callback domain (Leave blank if on the same domain)</label>

		                <input type="text" name = "mpesa_callback_url" value = "{{ $options->mpesa_callback_url }}" class="form-control">
 
					</div>
					
					

					<button type = "submit" class="btn btn-info">Update</button>
				</form>
			</div>		
		</div>
	</div>
@endsection