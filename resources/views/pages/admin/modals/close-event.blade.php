<div id="close-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.event.close', ['slug' => $event->slug]) }}" method="POST" class="form-materialize">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Close Event</h4> 
                </div>

                <div class="modal-body">
                    <h4 class="text-center">You Need to close the event first before issuing cash?</h4>
                    <strong>
                        <h3 class="text-center">Close event?</h3>
                    </strong>
                    

                    
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect">Yes, Close Event</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>