<div class="remodal" data-remodal-id="delete-work-experience-{{ $work_experience->id }}" role="dialog" aria-labelledby="Delete Work Experience" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.work-experience.delete', ['id' => $work_experience->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Delete Work Experience ?</h2>
  
        
        <br>
        
        <button type="submit" class="btn green pull-right">Delete</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>