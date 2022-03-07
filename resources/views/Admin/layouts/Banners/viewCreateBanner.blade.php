<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@if(empty($banner)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
          <form class="form-horizontal" action="{{url('admin/createBanner')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="id" value="{{!empty($banner) ? $banner->id : 0}}">

              <div class="form-group">
                
                  <label for="image" class="col-sm-2 control-label">@lang('leftsidebar.image')</label>
                  <div class="col-sm-4">
                      <input type="file" name="image" class="form-control" required id="image">
                  </div>

                  <label for="link" class="col-sm-2 control-label">@lang('leftsidebar.link')</label>
                  <div class="col-sm-4">
                      <input type="text" name="link" class="form-control" id="link" placeholder="@lang('leftsidebar.link')" value="{{ !empty($banner) ? $banner->link : ''}}" required>
                  </div>

              </div>

            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-info" value="@if(empty($banner)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>