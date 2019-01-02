<div class="col-sm-4 hoverable">
    <div class="card">
        <div class="card-image">
            <a href="{{ route('event.view', ['slug'=>$event->slug]) }}">
                <img src="{{ thumbnail($event->thumbnail, 'event') }}" alt="">
            </a>

            <span class="event-price heverable">
                @if($event->delegate_price)
                    {{ $options->currency }} {{ number_format($event->delegate_price,2) }}
                @else
                    FREE
                @endif
            </span>
                       
        </div>

        <div class="card-content match-height">
            <h4 class="mbn-5">
                <strong class="text-upper"> {{ characters($event->name,20) }}</strong> 
            </h4>
            
            <div class="mt-10">
            
                @if($event->start_date->gte($today))
                    <small class="text-upper"><i class="fa fa-calendar"></i> {{ niceDate($event->start_date) }}</small>    
                @else
                    <small class="text-upper red-text"><i class="fa fa-calendar"></i> {{ niceDate($event->start_date) }} (ALREADY HAPPENED)</small>
                @endif

                </div>
            
            <h4>
                
                <small class="mtn-20"><i class="fa fa-map-marker"></i> &nbsp; {{ words($event->venue,4) }}</small><br><br>
                
                <small class="mtn-10"><i class="fa fa-users"></i> ATTENDING 
                    <span class="blue-text">
                        {{ $event->requests()->where('paid', 1)->where('approved',1)->count() }}
                    </span>
                </small><br><br>

                <small>
                    <span class="pull-right">ID: {{ $event->id }}/{{ $event->created_at->year }}</span>
                </small>
            </h4>
            

           
            
            <div class="row"><hr></div>
            <p class="tiny">

                @if(count($event->tags))
                    @foreach($event->tags as $tag)
                        <a href="{{ route('event.tags', ['tag' => $tag->name]) }}" style="color: #2196F3;">#{{ $tag->name }}</a>  
                    @endforeach
                @else
                    &nbsp;
                @endif
            </p> 
        </div>
    </div>
</div>