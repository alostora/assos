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
          <form class="form-horizontal" action="{{url('admin/createOfferItems')}}" method="post" enctype="multipart/form-data">
            <div class="box-body">
              @csrf
              <input type="hidden" name="offer_id" value="{{Request('offer_id')}}">

              <div class="form-group">

                
                  <label for="items" class="col-sm-2 control-label">@lang('leftsidebar.items')</label>
                  <div class="col-sm-4">
                      <select name="items[]" class="form-control" id="items" multiple>
                        @if(!empty($items))
                          @foreach($items as $item)
                            <option value="{{$item->id}}">
                              {{App::getLocale() == 'ar' ? $item->itemNameAr : $item->itemName}}
                          </option>
                          @endforeach
                        @endif
                      </select>
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