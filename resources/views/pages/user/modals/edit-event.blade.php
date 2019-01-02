<div class="remodal" data-remodal-id="edit-event" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    <form action="{{ route('user.event.update', ['slug' => $event->slug]) }}" method = "POST">
      @csrf
      <div class = "text-left">
        <h2 id="">Edit <strong>{{ $event->name }}</strong></h2>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="input-field">
                    <label for="name">Event Name</label>
                    <input type="text" name="name" id="name" required="" value="{{ $event->name }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="input-field">
                    
                    <label for="start_date">Start Date</label>
                    <input type="text" name="start_date" id="start_date" class="start-date" required="" value="{{ $event->start_date }}">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="input-field">
                    <label for="end_date">End Date</label>
                    <input type="text" name="end_date" id="end_date" class="end-date" required="" value="{{ $event->end_date }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="input-field">
                    <label for="start_time">Start Time</label>
                    <input type="text" name="start_time" id="start_time" class="start-time" required="" value="{{ $event->start_time }}">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="input-field">
                    <label for="end_time">End Time</label>
                    <input type="text" name="end_time" id="end_time" class="end-time" required="" value="{{ $event->end_time }}">
                </div>
            </div>

            <div class="col-sm-6">
                <input class="with-gap" type="checkbox" name = "include_weekends" id="include-1" {{ $event->include_weekends ? 'checked=""' : '' }} />
                <label for="include-1">Include Weekends</label>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="input-field">
                            
                    <p>Timezone</p>                           

                    <select name="timezone_id" id="timezone_id" class="{{ $errors->has('timezone_id') ? ' is-invalid' : '' }} no-style" required />
                        <option value="">Select Timezone...</option>
                        
                        @foreach($timezones as $timezone)
                            <option value="{{ $timezone->id }}"{{ $event->timezone_id == $timezone->id ? ' selected' : '' }}>
                                {{ $timezone->zone }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="input-field">
                            
                    <p>Event Category</p>                           

                    <select name="event_category_id" id="event_category_id" class="{{ $errors->has('event_category_id') ? ' is-invalid' : '' }} no-style" required />
                        <option value="">Select Category....</option>
                        
                        @foreach($event_categories as $category)
                            <option value="{{ $category->id }}"{{ $event->category_id == $category->id ? ' selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="input-field">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows = "6" class="materialize-textarea" required="">{{ $event->description }}</textarea>
                </div>
            </div>

            {{-- <div class="col-sm-12">
                <div class="input-field">
                    <label>Tags</label>
                </div>
                
            </div> --}}

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="input-field">
                    <label for="venue">Venue</label>
                    <input type="text" name="venue" id="venue" required="" value="{{ $event->venue }}">
                </div>
            </div>

            <div class="col-sm-12">
                <div class="input-field">
                    <label for="map">Map (Paste google maps embed cod here) - Optional</label>
                    <textarea name="map" id="map" rows = "6" class="materialize-textarea">{{ $event->map }}</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h3 class="my-20">Attendance fee</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="input-field">
                    <label for="speaker-price">Speaker</label>
                    <input type="number" name="speaker_price" value="{{ $event->speaker_price }}" id="speaker-price" min="0">
                </div>
            </div>

            <div class="col-sm-4">
                <div class="input-field">
                    <label for="delegate-price">Delegate/Attendee</label>
                    <input type="number" name="delegate_price" value="{{ $event->delegate_price }}" id="delegate-price" min="0">
                </div>
            </div>

            <div class="col-sm-4">
                <div class="input-field">
                    <label for="exhibitor-price">Exhibitor/Showcaser</label>
                    <input type="number" name="exhibitor_price" value="{{ $event->exhibitor_price }}" id="exhibitor-price" min="0">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h3 class="my-20">Restrictions</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">      
                <input class="with-gap" name="restriction" type="radio" id="no-restriction" value = "0"  {{ $event->invite_only ? '' : 'checked' }} />
                <label for="no-restriction">No Restriction</label>        
            </div>

            <div class="col-sm-6">
                <input class="with-gap" name="restriction" type="radio" id="restriction" value = "1" {{ $event->invite_only ? 'checked' : '' }}/>
                <label for="restriction">Invite Only</label>    
            </div>
        </div>


        
        	
        
       
        
        <br>
        
        <button type="submit" class="btn waves-effect waves-light green">UPDATE EVENT</button>
        <button data-remodal-action="cancel" class="btn waves-effect waves-light red right">CLOSE</button>

      </div>
   </form>  
</div>