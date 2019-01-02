<div class="remodal" data-remodal-id="delete-reference-{{ $reference->id }}" role="dialog" aria-labelledby="Delete Reference" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.reference.delete', ['id' => $reference->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Delete Reference ?</h2>
  
        
        <br>
        
        <button type="submit" class="btn green pull-right">Delete</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>