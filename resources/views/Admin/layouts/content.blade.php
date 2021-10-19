<div class="content-wrapper">
    <section class="content-header">
        <h1>
          @lang('leftsidebar.menuqr')
          <small>@lang('leftsidebar.Control Panel')</small>  
        </h1>
    </section>

    <section class="content">
        <div class="row">

            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>@if(!empty($admins)) {{$admins}} @endif</h3>
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
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3>@if(!empty($users)) {{$users}} @endif</h3>
                        <p>@lang('leftsidebar.userInfo')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{url('admin/userInfo')}}" class="small-box-footer">
                        @lang('leftsidebar.info')<i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </section>
</div>