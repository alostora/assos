<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{url('dashboard_admin_panel/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                @if(Auth::guard('admin')->check())
                    <p>{{Auth::guard('admin')->user()->name}}</p>            
                @elseif(Auth::guard('vendor')->check())
                    <p>{{Auth::guard('vendor')->user()->vendor_name}}</p>
                @endif
                <i class="fa fa-circle text-success"></i> @lang('leftsidebar.online')
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
                    @if(Auth::guard('admin')->check())
                        <li>
                            <a href="{{url('admin/adminInfo')}}">
                                <i class="fa fa-user"></i>@lang('leftsidebar.Admins')
                            </a>
                        </li>

                        <!-- products -->
                        <li class="treeview" style="height: auto;">
                            <a href="#">
                                <i class="fa fa-pie-chart"></i>
                                <span>@lang('leftsidebar.Products')</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li>
                                    <a href="{{url('admin/categoriesInfo')}}">
                                        <i class="fa fa-align-justify"></i>@lang('leftsidebar.categories')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('admin/propertiesInfo')}}">
                                        <i class="fa fa-cogs"></i>@lang('leftsidebar.propertiesInfo')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('admin/vendorsInfo')}}">
                                        <i class="fa fa-users"></i>@lang('leftsidebar.vendors')
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- sliders -->
                        <li class="treeview" style="height: auto;">
                            <a href="#">
                                <i class="fa fa-sliders"></i>
                                <span>@lang('leftsidebar.sliders')</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li>
                                    <a href="{{url('admin/sliderInfo/home')}}">
                                        <i class="fa fa-home"></i>@lang('leftsidebar.sliderInfohome')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('admin/sliderInfo/category')}}">
                                        <i class="fa fa-align-justify"></i>@lang('leftsidebar.sliderInfocategory')
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <!-- offers -->
                        <li class="treeview" style="height: auto;">
                            <a href="#">
                                <i class="fa fa-hourglass-start"></i>
                                <span>@lang('leftsidebar.Offers')</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li>
                                    <a href="{{url('admin/offersInfo')}}">
                                        <i class="fa fa-bookmark"></i>@lang('leftsidebar.offersInfo')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('admin/adsInfo')}}">
                                        <i class="fa fa-thumbs-up"></i>@lang('leftsidebar.ads Info')
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <!-- orders -->
                        <li class="treeview" style="height: auto;">
                            <a href="#">
                                <i class="fa fa-send"></i>
                                <span>@lang('leftsidebar.orders')</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li>
                                    <a href="{{url('admin/ordersInfo')}}">
                                        <i class="fa fa-opencart"></i>@lang('leftsidebar.Sales info')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('admin/orderSettings')}}">
                                        <i class="fa fa-cogs"></i>@lang('leftsidebar.orderSettings')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('admin/itemBackReasonsInfo')}}">
                                        <i class="fa fa-mail-reply-all"></i>@lang('leftsidebar.Item back reason')
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{url('admin/privacyInfo')}}">
                                <i class="fa fa-info-circle"></i>@lang('leftsidebar.Privacy & Policies')
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/contactUs')}}">
                                <i class="fa fa-circle-o"></i>@lang('leftsidebar.contactUs')
                            </a>
                        </li>
                        

                    @elseif(Auth::guard('vendor')->check())
                        <li>
                            <a href="{{url('vendor/itemsInfo')}}">
                                <i class="fa fa-plus"></i> @lang('leftsidebar.items')
                            </a>
                        </li>
                        <li>
                            <a href="{{url('vendor/viewCreateItem')}}">
                                <i class="fa fa-plus"></i> @lang('leftsidebar.viewCreateItem')
                            </a>
                        </li>
                        <li>
                            <a href="{{url('vendor/sliderVendorInfo')}}">
                                <i class="fa fa-plus"></i> @lang('leftsidebar.sliders')
                            </a>
                        </li>

                        <li>
                            <a href="{{url('vendor/coponsInfo')}}">
                                <i class="fa fa-circle-o"></i>@lang('leftsidebar.coponsInfo')
                            </a>
                        </li>
                    @endif
                </ul>
            </li> 
        </ul>
    </section>
</aside>