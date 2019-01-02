<div class="remodal" data-remodal-id="delete-achievment-{{ $career_interest->id }}" role="dialog" aria-labelledby="Delete Career Interest" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.achievment.delete', ['id' => $career_interest->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Delete {{ $career_interest->name }}</h2>
  
        
        <br>
        
        <button type="submit" class="btn green pull-right">Delete</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>