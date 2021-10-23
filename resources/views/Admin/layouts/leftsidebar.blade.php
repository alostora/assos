<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{url('dashboard_admin_panel/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{\Auth::guard('admin')->user()->name}}</p>
                <i class="fa fa-circle text-success"></i> متصل
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">
                @if(App::getLocale() == "ar" || App::getLocale() == "")
                    <a href="{{url('admin/lang/en')}}" style="color: #f0f0f0;">English</a>
                @else
                    <a href="{{url('admin/lang/ar')}}" style="color: #f0f0f0">عربي</a>
                @endif
            </li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>@lang('leftsidebar.Control Panel')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{url('admin/adminInfo')}}">
                            <i class="fa fa-circle-o"></i>@lang('leftsidebar.Admins')
                        </a>
                    </li>

                    <li>
                        <a href="{{url('admin/vendorInfo')}}">
                            <i class="fa fa-circle-o"></i>@lang('leftsidebar.vendor')
                        </a>
                    </li>

                    <li>
                        <a href="{{url('admin/categoriesInfo')}}">
                            <i class="fa fa-circle-o"></i>@lang('leftsidebar.categories')
                        </a>
                    </li>
                   

                </ul>
            </li> 
        </ul>
    </section>
</aside>