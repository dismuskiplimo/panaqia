<div class="remodal" data-remodal-id="add-partner" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    
    <form action="{{ route('event.sponsor.add', ['slug' => $event->slug]) }}" method="POST" enctype="multipart/form-data">
      @csrf

      <input type="hidden" name = "type" value = "PARTNER">
      
      <div class = "text-left">
        <h2 id="">Add Partner</h2>
        
        
        <div class="row">
          <div class="col-sm-6">
            <div class="input-field">
              <label for="name">Partner*</label>
              <input type="text" name="name" id="name" required="" >
              
            </div> 
          </div>
          
          <div class="col-sm-6">
            <div class="input-field">
              <label for="logo">Logo</label>
              <input type="file" name="logo" id="logo">
            </div>
          </div>
        </div>   
        
        <br>
        
        <button type="submit" class="btn green pull-right"><i class="fa fa-plus"></i> Add Partner</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
      </div>
      
    </form>
</div>