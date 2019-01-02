<div class="remodal" data-remodal-id="edit-award-{{ $award->id }}" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.award.update', ['id' => $award->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Edit Award</h2>
        
        <div class="row">
          <div class="col-sm-6">
            <div class="input-field">
              <label for="name-{{ $award->id }}">Award</label>
              <input type="text" name="name" id="name-{{ $award->id }}" value="{{ $award->name }}">
            </div> 
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="year-{{ $award->id }}">Year</label>
              <input type="number" name="year" id="year-{{ $award->id }}" value="{{ $award->year }}" min="1900" max="{{ date('Y') }}">
            </div>
          </div>
        </div>
          

        
        <br>
        
        <button type="submit" class="btn green pull-right">Update</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>