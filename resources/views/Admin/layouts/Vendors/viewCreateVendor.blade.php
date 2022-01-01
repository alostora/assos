<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@if(empty($vendor)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
          </div>
          @if(count($errors))
            @foreach($errors->all() as $error)
              <div class="col-sm-12">
                <div class="alert alert-danger">{{$error}}</div>
              </div>
            @endforeach
          @endif
          @if(session()->has('success'))
            <div class="alert alert-success">{{session('success')}}</div>
          @endif
          @if(session()->has('warning'))
            <div class="alert alert-warning">{{session('warning')}}</div>
          @endif
          <form class="form-horizontal" action="{{url('admin/createVendor')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="id" value="@if(!empty($vendor)) {{$vendor->id}} @endif">

              <div class="form-group">

                  <label for="vendor_name" class="col-sm-2 control-label">@lang('leftsidebar.name')</label>
                  <div class="col-sm-4">
                      <input type="text" name="vendor_name" class="form-control" id="vendor_name" placeholder="@lang('leftsidebar.name')" value="@if(!empty($vendor)) {{$vendor->vendor_name}} @endif" required>
                  </div>


                  <label for="phone" class="col-sm-2 control-label">@lang('leftsidebar.phone')</label>
                  <div class="col-sm-4">
                      <input type="text" name="phone" class="form-control" id="phone" placeholder="@lang('leftsidebar.phone')" value="@if(!empty($vendor)) {{$vendor->phone}} @endif" required>
                  </div>
              </div>

              <div class="form-group">

                   <label for="email" class="col-sm-2 control-label">@lang('leftsidebar.email')</label>
                  <div class="col-sm-4">
                      <input type="email" name="email" class="form-control" placeholder="@lang('leftsidebar.email')" value="@if(!empty($vendor)) {{$vendor->email}} @endif" required id="email">
                  </div>   

                  <label for="address" class="col-sm-2 control-label">@lang('leftsidebar.address')</label>
                  <div class="col-sm-4">
                      <input type="text" name="address" class="form-control" placeholder="@lang('leftsidebar.address')" value="@if(!empty($vendor)) {{$vendor->address}} @endif" required id="address">
                  </div>
              </div>

              <div class="form-group">

                  <label for="password" class="col-sm-2 control-label">@lang('leftsidebar.password')</label>
                  <div class="col-sm-4">
                      <input type="password" name="password" class="form-control" id="password" placeholder="@lang('leftsidebar.password')" value="" required>
                  </div>


                  <label for="confirm_password" class="col-sm-2 control-label">@lang('leftsidebar.confirmPassword')</label>
                  <div class="col-sm-4">
                      <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="@lang('leftsidebar.confirmPassword')" value="" required>
                  </div>
              </div>


              <div class="form-group">
                  <label for="vendor_image" class="col-sm-2 control-label">@lang('leftsidebar.image')</label>
                  <div class="col-sm-4">
                      <input type="file" name="vendor_image" class="form-control">
                      @if(!empty($vendor) && !empty($vendor->vendor_image)) 
                        <img src="{{url('Admin_uploads/vendors/'.$vendor->vendor_image)}}" style="height:200px;width:200px"> 
                      @endif
                  </div>

                  <label for="vendor_logo" class="col-sm-2 control-label">@lang('leftsidebar.logo')</label>
                  <div class="col-sm-4">
                      <input type="file" name="vendor_logo" class="form-control">
                      @if(!empty($vendor) && !empty($vendor->vendor_logo)) 
                        <img src="{{url('Admin_uploads/vendors/'.$vendor->vendor_logo)}}" style="height:200px;width:200px"> 
                      @endif
                  </div>
              </div>

            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-info" value="@if(empty($vendor)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>