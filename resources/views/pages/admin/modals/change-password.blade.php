<div id="change-password-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.password.update') }}" method="POST" class="form-materialize">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">CHANGE PASSWORD</h4> 
                </div>

                <div class="modal-body">
                    

                    <div class="form-group">
                        <label class="col-md-12" for="old_password">Old Password
                        </label>
                        <div class="col-md-12">
                            <input id="old_password" name="old_password" class="form-control" placeholder="old password" type="password" required=""> </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="password">New Password
                        </label>
                        <div class="col-md-12">
                            <input id="password" name="password" class="form-control" placeholder="new password" type="password"  required=""> </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="password_confirmation">Repeat Password
                        </label>
                        <div class="col-md-12">
                            <input id="password_confirmation" name="password_confirmation" class="form-control" placeholder="repeat password" type="password" required=""> </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect">Update Password</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>