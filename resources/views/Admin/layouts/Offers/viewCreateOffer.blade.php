<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@if(empty($offer)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
          <form class="form-horizontal" action="{{url('admin/createOffer')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="id" value="@if(!empty($offer)) {{$offer->id}} @endif">

              <div class="form-group">

                  <label for="offerName" class="col-sm-2 control-label">@lang('leftsidebar.offerName')</label>
                  <div class="col-sm-4">
                      <input type="text" name="offerName" class="form-control" id="offerName" placeholder="@lang('leftsidebar.offerName')" value="@if(!empty($offer)) {{$offer->offerName}} @endif" required>
                  </div>
                
                  <label for="offerNameAr" class="col-sm-2 control-label">@lang('leftsidebar.offerNameAr')</label>
                  <div class="col-sm-4">
                      <input type="text" name="offerNameAr" class="form-control" placeholder="@lang('leftsidebar.offerNameAr')" value="@if(!empty($offer)) {{$offer->offerNameAr}} @endif" required id="offerNameAr">
                  </div>

              </div>

              <div class="form-group">
                  <label for="offerImage" class="col-sm-2 control-label">@lang('leftsidebar.offerImage')</label>
                  <div class="col-sm-4">
                      <input type="file" name="offerImage" class="form-control" placeholder="@lang('leftsidebar.offerImage')" >
                      @if(!empty($offer) && !empty($offer->offerImage)) 
                        <img src="{{url('Admin_uploads/offers/'.$offer->offerImage)}}" style="height:200px;width:200px"> 
                      @endif
                  </div>


              </div>

            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-info" value="@if(empty($offer)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>