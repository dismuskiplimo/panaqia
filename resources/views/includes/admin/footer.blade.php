                @include('includes.admin.right-sidebar')

            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> {{ date('Y') }} &copy; {{ config('app.name') }} </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ my_asset('js/admin/tether.min.js') }}"></script>
    <script src="{{ my_asset('js/admin/bootstrap.min.js') }}"></script>
    <script src="{{ my_asset('js/admin/bootstrap-extension.min.js') }}"></script>
    <!-- Sidebar menu plugin JavaScript -->
    <script src="{{ my_asset('js/admin/sidebar-nav.min.js') }}"></script>
    <!--Slimscroll JavaScript For custom scroll-->
    <script src="{{ my_asset('js/admin/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ my_asset('js/admin/waves.js') }}"></script>
    <script src="{{ my_asset('js/user/moment.js') }}"></script>
    <script src="{{ my_asset('js/user/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ my_asset('js/admin/custom.min.js') }}"></script>
    <script src="{{ my_asset('js/admin/custom.js') }}"></script>
</body>

</html>