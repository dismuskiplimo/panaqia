<div class="remodal" data-remodal-id="edit-profile-bio" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.profile-bio.update') }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Edit</h2>
        
        <div class="input-field">
          <label for="bio-1">About Me</label>
          <textarea name="bio" id="bio-1" rows="4" class="materialize-textarea">{{ $user->bio }}</textarea>
        </div>  

        
        <br>
        
        <button type="submit" class="btn green pull-right">Update</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>