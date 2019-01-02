<div class="remodal" data-remodal-id="feature-event-modal" role="dialog" aria-labelledby="Feature Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.feature', ['slug' => $event->slug]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Feature {{ $event->name }}</h2>
        
        <div class="row">
          <div class="col-sm-12">
            
            <h3>RATE: {{ $options->currency }} {{ number_format($options->featured_price,2) }} / Day</h3>

            <input type="hidden" id="featured_price" value="{{ $options->featured_price }}">
            <div class="input-field">
              <label for="hobby-1">From</label>
              <input type = "text" name="featured_from" id="hobby-1" required="" class="full-time" />
            </div>

            <div class="input-field">
              <label for="days-1">Number of Days</label>
              <input type = "number" name="days" id="days-1" min="1" required="" value="1" />
            </div>

            <h2>AMOUNT DUE: {{ $options->currency }} <span id="featured_total">0.00</span></h2>
          </div>
          
        </div>
        

         

        
        <br>
        
        <button type="submit" class="btn green pull-right" id="feature_button">FEATURE EVENT</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>