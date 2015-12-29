<!DOCTYPE html>
<html>
    <!--標頭-->
    @include('include.header')
<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            <!--導航列-->
          @include('include.sidebar')

            <!-- 網頁內容 -->
            <div class="right_col" role="main">

                @yield('content')

                <!--標頭-->
                @include('include.footer')

            </div>
            <!-- /網頁內容 -->
            
        </div>
    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

</body>
</html>