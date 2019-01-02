<div id="close-account-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.user.close', ['username' => $user->username]) }}" method="POST" class="form-materialize">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Close Account</h4> 
                </div>

                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="close-reason">Reason for closing account</label>
                        <textarea name="reason" id="close-reason" rows="8" class="form-control"></textarea>
                    </div>

                    
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect">Yes, Close Account</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>