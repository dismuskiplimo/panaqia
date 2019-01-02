<div class="remodal" data-remodal-id="add-social-link" role="dialog" aria-labelledby="Ass Social Link" aria-describedby="modal1Desc">
    
    <form action="{{ route('social-link.add', ['slug' => $event->slug]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Add Social Link</h2>
        
        <div class="row">
          <div class="col-sm-12">
            <div class="input-field">
              <p>Icon</p>
              
              <select name="icon" id="icon" required="">
                <option value="">--Select Icon---</option>

                @foreach($icons as $icon)
                  <option value="{{ $icon->name }}">{{ $icon->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="award-1">Social Site (e.g Facebook, Twitter)</label>
              <input type = "text" name="name" id="award-1" required="" />
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-field">
              <label for="link">Link</label>
              <input type = "text" name="link" id="link" required="" />
            </div> 
          </div>
        </div>
        

         

        
        <br>
        
        <button type="submit" class="btn green pull-right">ADD LINK</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>