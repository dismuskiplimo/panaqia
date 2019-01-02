<div class="remodal" data-remodal-id="add-card-contact" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.contact.add') }}" method="POST">
      @csrf

      <input type="hidden" name = "section" value = "CARD">
      
      <input type="hidden" name = "card_id" value = "{{ $card->id }}">

      <div class = "text-left">
        <h2 id="">Add Card Contact</h2>
        
        
        <div class="row">
          <div class="col-sm-6">
            <div class="input-field">
              <label for="contact_type"></label>
              <select name="type" id="contact_type" class = "browser-default" required="">
                @if(count($contact_types))
                  @foreach($contact_types as $contact_type)
                    <option value="{{ $contact_type->name }}">{{ strtolower($contact_type->name) }}</option>
                  @endforeach
                @else
                  <option value="">-- NO CONTACT TYPES DEFINED --</option>
                @endif
              </select>
              
            </div> 
          </div>
          
          <div class="col-sm-6">
            <div class="input-field">
              <label for="contact_1">Contact or Link</label>
              <input type="text" name="contact" id="contact_1" required="">
            </div>
          </div>
        </div>   
        
        <br>
        
        <button type="submit" class="btn green pull-right"><i class="fa fa-plus"></i> Add Contact</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
      </div>
      
    </form>
</div>