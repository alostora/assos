<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@if(empty($reason)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
          <form class="form-horizontal" action="{{url('admin/createitemBackReason')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="id" value="@if(!empty($reason)) {{$reason->id}} @endif">

              <div class="form-group">

                  <label for="backReasonName" class="col-sm-2 control-label">@lang('leftsidebar.backReasonName')</label>
                  <div class="col-sm-4">
                      <input type="text" name="backReasonName" class="form-control" id="backReasonName" placeholder="@lang('leftsidebar.backReasonName')" value="@if(!empty($reason)) {{$reason->backReasonName}} @endif" required>
                  </div>
                
                  <label for="backReasonArName" class="col-sm-2 control-label">@lang('leftsidebar.backReasonArName')</label>
                  <div class="col-sm-4">
                      <input type="text" name="backReasonArName" class="form-control" placeholder="@lang('leftsidebar.backReasonArName')" value="@if(!empty($reason)) {{$reason->backReasonArName}} @endif" required id="backReasonArName">
                  </div>

              </div>

              </div>

            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-info" value="@if(empty($reason)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>