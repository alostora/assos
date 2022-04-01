<div class="content-wrapper">
  <section class="content">
    <div class="row">
          <div class="col-xs-12">
              <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">@if(empty($admin)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
              <form class="form-horizontal" action="{{url('admin/createDelivery')}}" method="post" enctype="multipart/form-data">
                  <div class="box-body">
                        @csrf
                        <input type="hidden" name="id" value="{{!empty($delivery) ? $delivery->id : ''}}">

                        <div class="form-group">

                            <label for="name" class="col-sm-2 control-label">@lang('leftsidebar.Name')</label>
                            <div class="col-sm-4">
                                <input type="text" name="name" class="form-control" id="name" placeholder="@lang('leftsidebar.Name')" value="{{!empty($delivery) ?$delivery->name : ''}}" required>
                            </div>
                          
                            <label for="email" class="col-sm-2 control-label">@lang('leftsidebar.Email')</label>
                            <div class="col-sm-4">
                                <input type="email" name="email" class="form-control" placeholder="@lang('leftsidebar.Email')" value="{{!empty($delivery) ?$delivery->email : ''}}" required id="email">
                            </div>

                        </div>

                        <div class="form-group">

                            <label for="phone" class="col-sm-2 control-label">@lang('leftsidebar.phone')</label>
                            <div class="col-sm-4">
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="@lang('leftsidebar.phone')" value="{{!empty($delivery) ?$delivery->phone : ''}}" required>
                            </div>
                          
                            <label for="country" class="col-sm-2 control-label">@lang('leftsidebar.country')</label>
                            <div class="col-sm-4">
                                <select name="country" class="form-control">
                                  @if(!empty($delivery))
                                    @if($delivery->country == 'kw')
                                      <option value="kw" selected>@lang('leftsidebar.kw')</option>
                                      <option value="sa">@lang('leftsidebar.sa')</option>
                                    @else
                                      <option value="kw">@lang('leftsidebar.kw')</option>
                                      <option value="sa"selected>@lang('leftsidebar.sa')</option>
                                    @endif
                                  @else
                                    <option value="kw">@lang('leftsidebar.kw')</option>
                                    <option value="sa">@lang('leftsidebar.sa')</option>
                                  @endif
                                </select>
                            </div>

                        </div>

                        <div class="form-group">

                            <label for="password" class="col-sm-2 control-label">@lang('leftsidebar.Password')</label>
                            <div class="col-sm-4">
                                <input type="password" name="password" class="form-control" placeholder="@lang('leftsidebar.Password')" @if(empty($delivery)) required @endif id="password">
                            </div>
                          
                            <label for="confirmPassword" class="col-sm-2 control-label">@lang('leftsidebar.Confirm Password')</label>
                            <div class="col-sm-4">
                                <input type="password" name="confirmPassword" class="form-control" placeholder="@lang('leftsidebar.Confirm Password')" @if(empty($delivery)) required @endif id="confirmPassword">
                            </div>

                        </div>


                  </div>
                  <div class="box-footer">
                      <input type="submit" class="btn btn-info" value="@if(empty($delivery)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
                  </div>

              </form>
            </div>
          </div>
        </div>
  </section>
</div>