<div class="remodal" data-remodal-id="add-achievment" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.achievment.add') }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Add Achievement</h2>
        
        <div class="row">
          <div class="col-sm-12">
            <div class="input-field">
              <label for="career-interest-1">Achievement</label>
              <input type = "text" name="name" id="career-interest-1" required="" />
            </div>
          </div>
          
        </div>
        
        <br>
        
        <button type="submit" class="btn green pull-right">ADD Achievement</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>