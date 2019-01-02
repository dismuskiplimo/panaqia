<div class="remodal" data-remodal-id="edit-achievment-{{ $career_interest->id }}" role="dialog" aria-labelledby="Edit Career Interest" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.achievment.update', ['id' => $career_interest->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Edit Achievement</h2>
        
        <div class="input-field">
          <label for="name-{{ $career_interest->id }}">Achievement</label>
          <input type="text" name="name" id="name-{{ $career_interest->id }}" value="{{ $career_interest->name }}">
        </div>  

        
        <br>
        
        <button type="submit" class="btn green pull-right">Update</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>