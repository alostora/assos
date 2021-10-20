<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@if(empty($cat)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
          <form class="form-horizontal" action="{{url('admin/createcategory')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="id" value="@if(!empty($cat)) {{$cat->id}} @endif">

              <div class="form-group">

                  <label for="categoryName" class="col-sm-2 control-label">@lang('leftsidebar.categoryName')</label>
                  <div class="col-sm-4">
                      <input type="text" name="categoryName" class="form-control" id="categoryName" placeholder="@lang('leftsidebar.categoryName')" value="@if(!empty($admin)) {{$admin->categoryName}} @endif" required>
                  </div>
                
                  <label for="categoryNameAr" class="col-sm-2 control-label">@lang('leftsidebar.categoryNameAr')</label>
                  <div class="col-sm-4">
                      <input type="text" name="categoryNameAr" class="form-control" placeholder="@lang('leftsidebar.categoryNameAr')" value="@if(!empty($cat)) {{$cat->categoryNameAr}} @endif" required id="categoryNameAr">
                  </div>

              </div>

              <div class="form-group">

                  <label for="categoryDesc" class="col-sm-2 control-label">@lang('leftsidebar.categoryDesc')</label>
                  <div class="col-sm-4">
                      <textarea name="categoryDesc" class="form-control" id="categoryDesc" placeholder="@lang('leftsidebar.categoryDesc')" required>@if(!empty($admin)) {{$admin->categoryDesc}} @endif</textarea>
                  </div>
                
                  <label for="categoryDescAr" class="col-sm-2 control-label">@lang('leftsidebar.categoryDescAr')</label>
                  <div class="col-sm-4">
                      <textarea name="categoryDescAr" class="form-control" placeholder="@lang('leftsidebar.categoryDescAr')" required id="categoryDescAr">@if(!empty($cat)) {{$cat->categoryDescAr}} @endif</textarea>
                  </div>
              </div>

              <div class="form-group">
                  <label for="categoryImage" class="col-sm-2 control-label">@lang('leftsidebar.categoryImage')</label>
                  <div class="col-sm-4">
                      <input type="file" name="categoryImage" class="form-control" placeholder="@lang('leftsidebar.categoryImage')" value="@if(!empty($cat)) {{$cat->categoryImage}} @endif" required id="categoryImage">
                  </div>
              </div>

            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-info" value="@if(empty($cat)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>