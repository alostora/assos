<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@if(empty($copon)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
          <form class="form-horizontal" action="{{url('admin/createCopon')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="id" value="@if(!empty($copon)) {{$copon->id}} @endif">

              <div class="form-group">
                  <label for="dateFrom" class="col-sm-2 control-label">@lang('leftsidebar.dateFrom')</label>
                  <div class="col-sm-4">
                      <input type="date" name="dateFrom" class="form-control" placeholder="@lang('leftsidebar.dateFrom')" value="@if(!empty($copon)){{$copon->dateFrom}}@endif">
                  </div>
              </div>
              <div class="form-group">
                  <label for="dateTo" class="col-sm-2 control-label">@lang('leftsidebar.dateTo')</label>
                  <div class="col-sm-4">
                      <input type="date" name="dateTo" class="form-control" placeholder="@lang('leftsidebar.dateTo')" value="@if(!empty($copon)){{$copon->dateTo}}@endif">
                  </div>
              </div>
              <div class="form-group">
                  <label for="discountValue" class="col-sm-2 control-label">@lang('leftsidebar.discountValue')</label>
                  <div class="col-sm-4">
                      <input type="number" name="discountValue" class="form-control" placeholder="@lang('leftsidebar.discountValue')" value="@if(!empty($copon)){{$copon->discountValue}}@endif">
                  </div>
              </div>

            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-info" value="@if(empty($ad)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>