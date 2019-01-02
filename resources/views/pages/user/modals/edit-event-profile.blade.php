<div class="remodal" data-remodal-id="edit-event-profile" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.event-profile.update') }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Edit Profile</h2>
        
        <div class="input-field">
          <label for="name_of_company">Company</label>
          <input type="text" name="name_of_company" id="name_of_company" required="" class = "form-control" value = "{{ $user->name_of_company }}">
        </div> 

        <div class="input-field">
          <label for="position-1">Position</label>
          <input type="text" name="position" id="position-1" required="" class = "form-control" value = "{{ $user->position }}">
        </div> 
        
        <br>
        
        <button type="submit" class="btn green pull-right">Update Profile</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>