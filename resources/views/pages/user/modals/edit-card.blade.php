<div class="remodal" data-remodal-id="edit-card-modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.card.update', ['id' => $card->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Edit Card</h2>
        
        <div class="input-field">
          <label for="company">Company</label>
          <input type="text" name="company" id="company" required="" class = "form-control" value = "{{ $card->company }}">
        </div> 

        <div class="input-field">
          <label for="position">Position</label>
          <input type="text" name="position" id="position" required="" class = "form-control" value = "{{ $card->position }}">
        </div> 

         <div class="input-field">
          <label for="bio">About</label>
          <textarea name="description" id="bio" rows="4" class="materialize-textarea">{{ $card->description }}</textarea>
        </div>  

        
        <br>
        
        <button type="submit" class="btn green pull-right">Update</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>