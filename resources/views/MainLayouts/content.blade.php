<div class="content-wrapper">
    <section class="content-header">
        <h1>
          @lang('leftsidebar.Molak')
          <small>@lang('leftsidebar.Control Panel')</small>  
        </h1>
    </section>

    <section class="content">
            @if(Auth::guard('admin')->check())
                <div class="row">
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$admins?$admins:0}}</h3>
                                <p>@lang('leftsidebar.admin')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{url('admin/adminInfo')}}" class="small-box-footer">
                                @lang('leftsidebar.info')<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{$vendors?$vendors:0}}</h3>
                                <p>@lang('leftsidebar.vendors')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="{{url('admin/vendorsInfo')}}" class="small-box-footer">
                                @lang('leftsidebar.info')<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-default">
                            <div class="inner">
                                <h3>{{$categories?$categories:0}}</h3>
                                <p>@lang('leftsidebar.categories')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-align-justify"></i>
                            </div>
                            <a href="{{url('admin/categoriesInfo')}}" class="small-box-footer">
                                @lang('leftsidebar.info')<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$properties?$properties:0}}</h3>
                                <p>@lang('leftsidebar.propertiesInfo')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-cogs"></i>
                            </div>
                            <a href="{{url('admin/propertiesInfo')}}" class="small-box-footer">
                                @lang('leftsidebar.info')<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$offers?$offers:0}}</h3>
                                <p>@lang('leftsidebar.offersInfo')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-bookmark"></i>
                            </div>
                            <a href="{{url('admin/offersInfo')}}" class="small-box-footer">
                                @lang('leftsidebar.info')<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$ads?$ads:0}}</h3>
                                <p>@lang('leftsidebar.ads Info')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-thumbs-up"></i>
                            </div>
                            <a href="{{url('admin/adsInfo')}}" class="small-box-footer">
                                @lang('leftsidebar.info')<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @elseif(Auth::guard('vendor')->check())
                <div class="row">
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3> {{!empty($items) ? $items : 0}}</h3>
                                <p>@lang('leftsidebar.items')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-product"></i>
                            </div>
                            <a href="{{url('vendor/itemsInfo')}}" class="small-box-footer">
                                @lang('leftsidebar.info')<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
    </section>
</div>