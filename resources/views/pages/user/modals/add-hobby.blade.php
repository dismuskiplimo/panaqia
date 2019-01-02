<div class="remodal" data-remodal-id="add-hobby" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.hobby.add') }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Add Hobby</h2>
        
        <div class="row">
          <div class="col-sm-12">
            <div class="input-field">
              <label for="hobby-1">Hobby</label>
              <input type = "text" name="name" id="hobby-1" required="" />
            </div>
          </div>
          
        </div>
        

         

        
        <br>
        
        <button type="submit" class="btn green pull-right">ADD HOBBY</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
      </div>
      
    </form>
</div>