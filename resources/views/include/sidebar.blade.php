            <!--左邊導航列[Start]-->
            <div class="col-md-3 left_col">

                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="/index" class="site_title"><i class="fa fa-paw"></i> <span>{{webInfo()->get('WebName')}}</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- 使用者資訊欄 -->
                    <div class="profile">
                        <div class="profile_pic">
                        {!! Html::image(getUserimg(getUserID()),'...',array('class' => 'img-circle profile_img')) !!}
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ getUserName() }}</h2>
                        </div>
                    </div>
                    <!-- /使用者資訊欄 -->

                    <!-- 導航欄 -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    @if(Sentinel::inRole('SuperAdmin') || Sentinel::inRole('Admin'))
                        <div class="menu_section">
                            <h3>管理選單</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> 系統管理 <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="{{ route('manage.account') }}">{{trans('manage.account')}}</a>
                                        </li>
                                        <li><a href="{{ route('manage.categories') }}">{{trans('manage.categories')}}</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @endif
                        <div class="menu_section">
                            <h3>Live On</h3>
                            {!! getForumList() !!}
                        </div>

                    </div>
                    <!-- /導航欄 -->

                    <!-- /底部導航按鈕 -->
                    <div class="sidebar-footer hidden-small">
                        <a href="{{route('profile.index')}}" data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a href="{{route('auth.logout')}}" data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /底部導航按鈕 -->
                </div>
            </div>

            <!-- 上方導航欄 -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <!--使用者資訊-->
                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    {!! Html::image(getUserimg(getUserID()),'...',array('class' => '')) !!}
                                    {{ getUserName() }}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="{{route('profile.index')}}">  Profile</a>
                                    </li>
                                    <li><a href="{{route('auth.logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!--/使用者資訊-->
                    </nav>
                        <!--導航列-->
                        <ol class="breadcrumb" style="margin-bottom:0px !important;">
                        {!! breadcrumbs() !!}
                        </ol>
                        <!--/導航列-->
                </div>

            </div>
            <!-- /上方導航欄 -->