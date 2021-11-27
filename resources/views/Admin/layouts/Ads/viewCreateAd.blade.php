<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@if(empty($ad)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
          <form class="form-horizontal" action="{{url('admin/createAd')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="id" value="@if(!empty($ad)) {{$ad->id}} @endif">

              <div class="form-group">

                  <label for="adLink" class="col-sm-2 control-label">@lang('leftsidebar.adLink')</label>
                  <div class="col-sm-4">
                      <input type="text" name="adLink" class="form-control" id="adLink" placeholder="@lang('leftsidebar.adLink')" value="@if(!empty($ad)) {{$ad->adLink}} @endif" required>
                  </div>
                
              </div>

              <div class="form-group">
                  <label for="adImage" class="col-sm-2 control-label">@lang('leftsidebar.adImage')</label>
                  <div class="col-sm-4">
                      <input type="file" name="adImage" class="form-control" placeholder="@lang('leftsidebar.adImage')" >
                      @if(!empty($ad) && !empty($ad->adImage)) 
                        <img src="{{url('Admin_uploads/ads/'.$ad->adImage)}}" style="height:200px;width:200px"> 
                      @endif
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