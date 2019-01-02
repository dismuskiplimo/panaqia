<div class="remodal" data-remodal-id="delete-skill-{{ $skill->id }}" role="dialog" aria-labelledby="Delete Skill" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.skill.delete', ['id' => $skill->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Delete Skill ?</h2>
  
        
        <br>
        
        <button type="submit" class="btn green pull-right">Delete</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>