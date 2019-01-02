<div class="remodal" data-remodal-id="delete-hobby-{{ $hobby->id }}" role="dialog" aria-labelledby="Delete Hobby" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.hobby.delete', ['id' => $hobby->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Delete {{ $hobby->name }}</h2>
  
        
        <br>
        
        <button type="submit" class="btn green pull-right">Delete</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>