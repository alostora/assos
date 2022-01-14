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

                  <label for="vendor_id" class="col-sm-2 control-label">@lang('leftsidebar.vendors')</label>
                  <div class="col-sm-4">
                      <select name="vendor_id" class="form-control" id="vendor_id"required>
                        @if(!empty($vendors))
                          @foreach($vendors as $vendor)
                            @if(!empty($ad) && $vendor->id == $ad->vendor_id)
                              <option value="{{$vendor->id}}" selected>{{$vendor->vendor_name}}</option>
                            @else
                              <option value="{{$vendor->id}}">{{$vendor->vendor_name}}</option>
                            @endif
                          @endforeach
                        @endif
                      </select>
                  </div>


                  <label for="cat_id" class="col-sm-2 control-label">@lang('leftsidebar.categories')</label>
                  <div class="col-sm-4">
                      <select name="cat_id" class="form-control" id="cat_id">
                        <option value="">@lang('leftsidebar.choose')</option>
                        @if(!empty($categories))
                          @foreach($categories as $cat)
                            @if(!empty($ad) && $cat->id == $ad->cat_id)
                              <option value="{{$cat->id}}" selected>{{App::getLocale() != 'ar' ? $cat->categoryName : $cat->categoryNameAr }}</option>
                            @else
                              <option value="{{$cat->id}}">{{App::getLocale() != 'ar' ? $cat->categoryName : $cat->categoryNameAr }}</option>
                            @endif
                          @endforeach
                        @endif
                      </select>
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