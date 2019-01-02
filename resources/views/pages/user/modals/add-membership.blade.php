<div class="remodal" data-remodal-id="add-membership" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.membership.add') }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Add Membership</h2>
        
        <div class="input-field">
          <label for="membership-1">Membership</label>
          <input type = "text" name="name" id="membership-1" required="" />
        </div>  

        
        <br>
        
        <button type="submit" class="btn green pull-right">ADD MEMBERSHIP</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>