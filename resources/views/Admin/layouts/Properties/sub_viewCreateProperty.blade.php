<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@if(empty($property)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
          <form class="form-horizontal" action="{{url('admin/sub_createProperty')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="id" value="@if(!empty($property)) {{$property->id}} @endif">
              <input type="hidden" name="prop_id" value="@if(!empty($property)) {{$property->prop_id}} @else {{Request('propId')}} @endif">

              <div class="form-group">

                  @if(!empty(Request('propId')) && !empty(\App\Models\Property::find(Request('propId'))))

                    @if(\App\Models\Property::find(Request('propId'))->type == 'color')
                      <label for="propertyName" class="col-sm-2 control-label">
                      @lang('leftsidebar.propertyName')</label>
                      <div class="col-sm-4">
                          <input type="color" name="propertyName" class="form-control" id="propertyName" placeholder="@lang('leftsidebar.propertyName')" value="@if(!empty($property)){{$property->propertyName}}@endif" required>
                      </div>
                    
                      <label for="propertyNameAr" class="col-sm-2 control-label">@lang('leftsidebar.propertyNameAr')</label>
                      <div class="col-sm-4">
                          <input type="color" name="propertyNameAr" class="form-control" placeholder="@lang('leftsidebar.propertyNameAr')" value="@if(!empty($property)){{$property->propertyNameAr}}@endif" required id="propertyNameAr">
                      </div>
                    @else
                      <label for="propertyName" class="col-sm-2 control-label">
                      @lang('leftsidebar.propertyName')</label>
                      <div class="col-sm-4">
                          <input type="text" name="propertyName" class="form-control" id="propertyName" placeholder="@lang('leftsidebar.propertyName')" value="@if(!empty($property)){{$property->propertyName}}@endif" required>
                      </div>
                    
                      <label for="propertyNameAr" class="col-sm-2 control-label">@lang('leftsidebar.propertyNameAr')</label>
                      <div class="col-sm-4">
                          <input type="text" name="propertyNameAr" class="form-control" placeholder="@lang('leftsidebar.propertyNameAr')" value="@if(!empty($property)){{$property->propertyNameAr}}@endif" required id="propertyNameAr">
                      </div>
                    @endif
                  @endif

              </div>

            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-info" value="@if(empty($property)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>