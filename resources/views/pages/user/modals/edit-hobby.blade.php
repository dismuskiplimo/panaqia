<div class="remodal" data-remodal-id="edit-hobby-{{ $hobby->id }}" role="dialog" aria-labelledby="Edit Hobby" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.hobby.update', ['id' => $hobby->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Edit Hobby</h2>
        
        <div class="input-field">
          <label for="name-{{ $hobby->id }}">Career Interest</label>
          <input type="text" name="name" id="name-{{ $hobby->id }}" value="{{ $hobby->name }}">
        </div>  

        
        <br>
        
        <button type="submit" class="btn green pull-right">Update</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>