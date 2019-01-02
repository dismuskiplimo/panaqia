<div class="remodal" data-remodal-id="edit-membership-{{ $membership->id }}" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.membership.update', ['id' => $membership->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Edit Membership</h2>
        
        <div class="input-field">
          <label for="name-{{ $membership->id }}">Membership</label>
          <input type="text" name="name" id="name-{{ $membership->id }}" value="{{ $membership->name }}">
        </div>  

        
        <br>
        
        <button type="submit" class="btn green pull-right">Update</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>