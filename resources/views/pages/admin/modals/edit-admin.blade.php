<div id="edit-admin-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.info.update') }}" method="POST" class="form-materialize">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">{{ $admin->name }}</h4> 
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-12" for="name">Name
                        </label>
                        <div class="col-md-12">
                            <input id="name" name="name" class="form-control" placeholder="name" value = "{{ $admin->name }}" type="text" required=""> </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="username">Username
                        </label>
                        <div class="col-md-12">
                            <input id="username" name="username" class="form-control" placeholder="username" value = "{{ $admin->username }}" type="text" required=""> </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="email">Email
                        </label>
                        <div class="col-md-12">
                            <input id="email" name="email" class="form-control" placeholder="email" type="email" value = "{{ $admin->email }}" required=""> </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="country">Country
                        </label>

                        <div class="col-md-12">
                            <select id="country" name="country_code" class="form-control" required="">
                                <option value=""> --Select Country-- </option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->code }}"{{ $country->code == $admin->country_code ? ' selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect">Update Info</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>