<div class="remodal" data-remodal-id="attend-event" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
      <div class = "text-left">
        @if($event->invite_only)
			<h2 id="">Request to attend <strong>{{ $event->name }}</strong> as</h2>
        @else
			<h2 id="">Attend <strong>{{ $event->name }}</strong> as</h2>
        @endif
        
        
       	<form action="{{ route('user.event.attend', ['slug' => $event->slug]) }}" method="GET">

       		<p>
       			<input name="attending_as" type="radio" id="attending-1" value = "SPEAKER" checked="checked" />
      			<label for="attending-1">SPEAKER 
					<big>
						@if($event->speaker_price)
							(KES {{ number_format($event->speaker_price, 2) }})
						@else
							(FREE)
						@endif
					</big>
      				
      			</label>	
       		</p>

       		<p>
       			<input name="attending_as" type="radio" id="attending-2" value = "DELEGATE" />
      			<label for="attending-2">DELEGATE/ATTENDEE 
					<big>
						@if($event->delegate_price)
							(KES {{ number_format($event->delegate_price, 2) }})
						@else
							(FREE)
						@endif
					</big>
      			</label>	
       		</p>

       		<p>
       			<input name="attending_as" type="radio" id="attending-3" value = "EXHIBITOR" />
      			<label for="attending-3">SHOWCASER/EXHIBITOR 
					<big>
						@if($event->exhibitor_price)
							(KES {{ number_format($event->exhibitor_price, 2) }})
						@else
							(FREE)
						@endif
					</big>
      			</label>	
       		</p>


       	
        
	        <br>
	        
	        @if($event->invite_only)
	        	<button type="submit" class="btn green waves-effect waves-light">REQUEST</button>
	        @else
				<button type="submit" class="btn green waves-effect waves-light">ATTEND</button>
	        @endif

	        <button data-remodal-action="cancel" class="btn red waves-effect waves-light right">CLOSE</button>

        </form>
        
      </div>
      
</div>