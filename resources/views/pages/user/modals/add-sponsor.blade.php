<div class="remodal" data-remodal-id="add-sponsor" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    
    <form action="{{ route('event.sponsor.add', ['slug' => $event->slug]) }}" method="POST" enctype="multipart/form-data">
      @csrf

      <input type="hidden" name = "type" value = "SPONSOR">
      
      <div class = "text-left">
        <h2 id="">Add Sponsor</h2>
        
        
        <div class="row">
          <div class="col-sm-6">
            <div class="input-field">
              <label for="name">Sponsor*</label>
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
        
        <button type="submit" class="btn green pull-right"><i class="fa fa-plus"></i> Add Sponsor</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
      </div>
      
    </form>
</div>