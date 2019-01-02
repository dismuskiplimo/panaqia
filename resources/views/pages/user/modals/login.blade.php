<div class="remodal" data-remodal-id="login" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.login') }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Please login to continue</h2>
        
        <div class="row">
          <div class="col-sm-6">
            <div class="input-field">
              <label for="username-1">Email/Username</label>
              <input type = "text" name="username" id="username-1" required="" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="password-1">Password</label>
              <input type = "password" name="password" id="password-1" required="" />
            </div>
          </div>

          <div class="col-sm-6">
            <input type="checkbox" name="remember" id="remember" />
            <label for="remember">Remember Me</label>
          </div>


        </div>
        

         

        
        <br>

        <button type="submit" class="btn green pull-right">LOGIN</button>
        <button data-remodal-action="cancel" class="btn red">CANCEL</button>
        
      </div>
      
    </form>
</div>