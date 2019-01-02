        @if($nav !='home')
        <footer class="footer footer-four">
            <div class="primary-footer brand-bg text-center">
                <div class="container">

                  <a href="#top" class="page-scroll btn-floating btn-large pink back-top waves-effect waves-light tt-animate btt" data-section="#top">
                    <i class="material-icons">&#xE316;</i>
                  </a>

                  <ul class="social-link tt-animate ltr mt-20">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                  </ul>

                  <hr class="mt-15">

                  <div class="row">
                    <div class="col-md-12">
                          <div class="footer-logo">
                            <img src="{{ my_asset('img/black-logo.png') }}" class = "size-100" title="{{ config('app.name') }}" alt="{{ config('app.name') }} Logo">
                          </div>

                          <span class="copy-text">Copyright &copy; {{ date('Y') }} <a href="{{ route('home') }}">{{ config('app.name') }}</a> &nbsp; | &nbsp;  All Rights Reserved. <a href="{{ route('privacy-policy') }}">Privacy Policy</a> </span> <br>
                          {{-- <div class="footer-intro">
                            <p>Penatibus tristique velit vestibulum adipiscing habitant aenean feugiat at condimentum aptent odio orci vulputate hac mollis a.Vestibulum adipiscing gravida justo a ac euismod vitae.</p>
                          </div> --}}
                    </div><!-- /.col-md-12 -->
                  </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.primary-footer -->

            <div class="secondary-footer brand-bg darken-2 text-center">
                <div class="container">
                    <ul>
                      <li><a href="{{ route('home') }}">Home</a></li>
                      <li><a href="{{ route('about-us') }}">About us</a></li>
                      <li><a href="{{ route('contact-us') }}">Contact us</a></li>
                      <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    </ul>
                </div><!-- /.container -->
            </div><!-- /.secondary-footer -->
        </footer>

        @endif

        
        <!-- Preloader -->
        <div id="preloader">
          <div class="preloader-position"> 
            <img src="{{ my_asset('img/blue-logo.png') }}" class="size-100" alt="logo" >
            <div class="progress">
              <div class="indeterminate"></div>
            </div>
          </div>
        </div>
        <!-- End Preloader -->
        
        <input type="hidden" id="message-count-url" value = "{{ route('user.messages.count') }}">
        <input type="hidden" id="notifications-url" value = "{{ route('user.notifications.count') }}">
        
        <script src="{{ my_asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ my_asset('js/user/materialize.min.js') }}"></script>
        <script src="{{ my_asset('js/menuzord.js') }}"></script>
        <script src="{{ my_asset('js/bootstrap-tabcollapse.min.js') }}"></script>
        <script src="{{ my_asset('js/jquery.easing.min.js') }}"></script>
        <script src="{{ my_asset('js/jquery.sticky.min.js') }}"></script>
        <script src="{{ my_asset('js/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ my_asset('js/smoothscroll.min.js') }}"></script>
        <script src="{{ my_asset('js/jquery.stellar.min.js') }}"></script>
        <script src="{{ my_asset('js/jquery.inview.min.js') }}"></script>
        <script src="{{ my_asset('js/user/owl.carousel.min.js') }}"></script>
        <script src="{{ my_asset('js/user/jquery.flexslider-min.js') }}"></script>
        <script src="{{ my_asset('js/user/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ my_asset('js/user/remodal.min.js') }}"></script>
        <script src="{{ my_asset('js/user/moment.js') }}"></script>
        <script src="{{ my_asset('js/user/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ my_asset('js/user/jquery.imagereader-1.1.0.min.js') }}"></script>
        <script src="{{ my_asset('js/user/matchHeight-min.js') }}"></script>
        <script src="{{ my_asset('js/user/isotope.pkgd.min.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSP_Qb8ksJsCdZcggTbMS6ZEtRdfwB4KM"></script>
        <script src="{{ my_asset('js/user/scripts.js') }}"></script>
        <script src="{{ my_asset('js/sweetalert.min.js') }}"></script>

        <script src="{{ my_asset('js/user/custom.js') }}"></script>
        @if(Auth::check())
          <input type="hidden" id="update-user" value="{{ route('user.last-seen.update') }}">
          <script src="{{ my_asset('js/user/user.js') }}"></script>
        @endif

        @if($nav == 'events')
            <script src="{{ my_asset('js/user/event.js') }}"></script>
        @endif
    </body>
  
</html>