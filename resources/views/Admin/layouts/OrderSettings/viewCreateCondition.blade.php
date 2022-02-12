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
              <form class="form-horizontal" action="{{url('admin/createCondition')}}" method="post" enctype="multipart/form-data">
                  <div class="box-body">
                        @csrf
                        <input type="hidden" name="id" value="@if(!empty($condition)) {{$condition->id}} @endif">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">@lang('leftsidebar.shippingConditions')</label>
                            <div class="col-sm-4">
                                <input type="text" name="shippingConditions" class="form-control" id="shippingConditions" placeholder="@lang('leftsidebar.shippingConditions')" value="@if(!empty($condition)) {{$condition->shippingConditions}} @endif">
                            </div>

                            <label for="name" class="col-sm-2 control-label">@lang('leftsidebar.shippingConditionsAr')</label>
                            <div class="col-sm-4">
                                <input type="text" name="shippingConditionsAr" class="form-control" id="shippingConditionsAr" placeholder="@lang('leftsidebar.shippingConditionsAr')" value="@if(!empty($condition)) {{$condition->shippingConditionsAr}} @endif" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image" class="col-sm-2 control-label">@lang('leftsidebar.image')</label>
                            <div class="col-sm-4">
                                <input type="file" name="image" class="form-control" placeholder="@lang('leftsidebar.image')" >
                                @if(!empty($condition) && !empty($condition->image)) 
                                  <img src="{{url('Admin_uploads/conditions/'.$condition->image)}}" style="height:200px;width:200px"> 
                                @endif
                            </div>
                        </div>
                   


                  </div>
                  <div class="box-footer">
                      <input type="submit" class="btn btn-info" value="@if(empty($condition)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
                  </div>

              </form>
            </div>
          </div>
        </div>
  </section>
</div>