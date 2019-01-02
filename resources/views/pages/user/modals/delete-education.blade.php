<div class="remodal" data-remodal-id="delete-education-{{ $education->id }}" role="dialog" aria-labelledby="Add Education" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.education.delete', ['id' => $education->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Delete {{ $education->school }} ?</h2>
       
        <br>

        <button type="submit" class="btn green pull-right">YES, DELETE</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>