<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@if(empty($sub_cat)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif</h3>
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
          <form class="form-horizontal" action="{{url('admin/sub_createCategory')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="id" value="@if(!empty($sub_cat)) {{$sub_cat->id}} @endif">
              <input type="hidden" name="cat_id" value="@if(!empty(Request('cat_id'))) {{Request('cat_id')}} @endif">

              <div class="form-group">

                  <label for="s_categoryName" class="col-sm-2 control-label">@lang('leftsidebar.categoryName')</label>
                  <div class="col-sm-4">
                      <input type="text" name="s_categoryName" class="form-control" id="s_categoryName" placeholder="@lang('leftsidebar.categoryName')" value="@if(!empty($sub_cat)) {{$sub_cat->s_categoryName}} @endif" required>
                  </div>
                
                  <label for="s_categoryNameAr" class="col-sm-2 control-label">@lang('leftsidebar.categoryNameAr')</label>
                  <div class="col-sm-4">
                      <input type="text" name="s_categoryNameAr" class="form-control" placeholder="@lang('leftsidebar.categoryNameAr')" value="@if(!empty($sub_cat)) {{$sub_cat->s_categoryNameAr}} @endif" required id="s_categoryNameAr">
                  </div>

              </div>

              <div class="form-group">
                  <label for="s_categoryImage" class="col-sm-2 control-label">@lang('leftsidebar.categoryImage')</label>
                  <div class="col-sm-4">
                      <input type="file" name="s_categoryImage" class="form-control" placeholder="@lang('leftsidebar.categoryImage')" >
                      @if(!empty($sub_cat) && !empty($sub_cat->s_categoryImage)) 
                        <img src="{{url('Admin_uploads/categories/subCategory/'.$sub_cat->s_categoryImage)}}" style="height:200px;width:200px"> 
                      @endif
                  </div>
              </div>

            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-info" value="@if(empty($sub_cat)) @lang('leftsidebar.Add') @else @lang('leftsidebar.Edit') @endif">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>