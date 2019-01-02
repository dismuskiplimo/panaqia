<div class="remodal" data-remodal-id="delete-award-{{ $award->id }}" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.award.delete', ['id' => $award->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Delete {{ $award->name }}</h2>
  
        
        <br>
        
        <button type="submit" class="btn green pull-right">Delete</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>