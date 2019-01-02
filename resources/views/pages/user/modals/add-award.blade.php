<div class="remodal" data-remodal-id="add-award" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.award.add') }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Add Award</h2>
        
        <div class="row">
          <div class="col-sm-6">
            <div class="input-field">
              <label for="award-1">Award</label>
              <input type = "text" name="name" id="award-1" required="" />
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-field">
              <label for="year-1">Year</label>
              <input type = "number" name="year" id="year-1" required="" min="1900" max="{{ date('Y') }}" />
            </div> 
          </div>
        </div>
        

         

        
        <br>
        
        <button type="submit" class="btn green pull-right">ADD AWARD</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>