<div class="content-wrapper">
  <section class="content">
    <div class="row">
          <div class="col-xs-12">
              <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">@if(empty($setting)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
              <form class="form-horizontal" action="{{url('admin/createSetting')}}" method="post">
                  <div class="box-body">
                        @csrf
                        <input type="hidden" name="id" value="@if(!empty($setting)) {{$setting->id}} @endif">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">@lang('leftsidebar.settingName')</label>
                            <div class="col-sm-4">
                                <input type="text" name="settingName" class="form-control" id="settingName" placeholder="@lang('leftsidebar.settingName')" value="@if(!empty($setting)) {{$setting->settingName}} @endif" required>
                            </div>

                            <label for="name" class="col-sm-2 control-label">@lang('leftsidebar.settingNameAr')</label>
                            <div class="col-sm-4">
                                <input type="text" name="settingNameAr" class="form-control" id="settingNameAr" placeholder="@lang('leftsidebar.settingNameAr')" value="@if(!empty($setting)) {{$setting->settingNameAr}} @endif" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">@lang('leftsidebar.settingOptions')</label>
                            <div class="col-sm-4">
                                <input type="text" name="settingOptions" class="form-control" id="settingOptions" placeholder="@lang('leftsidebar.settingOptions')" value="@if(!empty($setting)) {{$setting->settingOptions}} @endif">
                            </div>

                            <label for="name" class="col-sm-2 control-label">@lang('leftsidebar.settingOptionsAr')</label>
                            <div class="col-sm-4">
                                <input type="text" name="settingOptionsAr" class="form-control" id="settingOptionsAr" placeholder="@lang('leftsidebar.settingOptionsAr')" value="@if(!empty($setting)) {{$setting->settingOptionsAr}} @endif">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">@lang('leftsidebar.settingValue')</label>
                            <div class="col-sm-4">
                                <input type="text" name="settingValue" class="form-control" id="settingValue" placeholder="@lang('leftsidebar.settingValue')" value="@if(!empty($setting)) {{$setting->settingValue}} @endif" required>
                            </div>
                        </div>
                   


                  </div>
                  <div class="box-footer">
                      <input type="submit" class="btn btn-info" value="@if(empty($setting)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
                  </div>

              </form>
            </div>
          </div>
        </div>
  </section>
</div>