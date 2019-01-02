<div class="remodal" data-remodal-id="add-skill" role="dialog" aria-labelledby="Add Skill" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.skill.add') }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Add Skill</h2>
        
        <div class="row">
          <div class="col-sm-12">
            <div class="input-field">
              <label for="skill-1">Skill</label>
              <input type = "text" name="skill" id="skill-1" required="" />
            </div>
          </div>
          
        </div>
        
        <br>
        
        <button type="submit" class="btn green pull-right">Add Skill</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>