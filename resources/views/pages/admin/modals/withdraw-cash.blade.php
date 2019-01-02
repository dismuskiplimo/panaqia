<div id="withdraw-cash-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.event.withdraw', ['slug' => $event->slug]) }}" method="POST" class="form-materialize">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Withdraw Cash</h4> 
                </div>

                <div class="modal-body">
                    <h4>Who is picking?</h4>
                    <div class="form-group">
                        <label for="picker_name">Name</label>
                        <input type="text" name="picker_name" id="picker_name" required="" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="picker_id">ID Number</label>
                        <input type="text" name="picker_id" id="picker_id" required="" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="picker_phone">Phone Number</label>
                        <input type="text" name="picker_phone" id="picker_phone" required="" class="form-control">
                    </div>

                    <h2>MPESA AMOUNT : {{ $options->currency }}        {{ number_format(($event->mpesa_collected - $event->mpesa_commission) ,2) }}</h2>
                    <h2>PAYPAL AMOUNT: {{ $options->paypal_currency }} {{ number_format(($event->paypal_collected - $event->paypal_commission) ,2) }}</h2>

                   

                    
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect">Mark as withdrawn</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>