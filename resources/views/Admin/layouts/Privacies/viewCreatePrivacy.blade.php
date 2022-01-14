<div class="content-wrapper">
      <section class="content">
              <div class="row">
                    <div class="col-xs-12">
                            <div class="box box-info">

                                <div class="box-header with-border">
                                    <h3 class="box-title">@if(empty($privacy)) @lang('leftsidebar.add') @else @lang('leftsidebar.edit') @endif</h3>
                                </div>

                                @if(count($errors))
                                      @foreach($errors->all() as $error)
                                          <div class="alert alert-danger">{{$error}}</div>
                                      @endforeach
                                @endif

                                @if(session()->has('success'))
                                      <div class="alert alert-success">{{session('success')}}</div>
                                @endif

                                @if(session()->has('warning'))
                                      <div class="alert alert-danger">{{session('warning')}}</div>
                                @endif

                                <form class="form-horizontal" action="{{url('admin/createPrivacy')}}" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        @csrf
                                        <input type="hidden" name="id" value="@if(!empty($privacy)){{$privacy->id}}@endif">

                                        <div class="form-group">
                                            <label for="editor1" class="col-sm-2">@lang('leftsidebar.type')</label>
                                            <div class="col-sm-4">
                                                <select type="text" name="type" class="form-control">
                                                  <option value="">@lang('leftsidebar.Choose')</option>
                                                    @if(!empty($privacy))
                                                      <option value="{{$privacy->type}}" selected>{{$privacy->type}}</option>
                                                    @endif
                                                    <option value="about">About_us</option>
                                                    <option value="privacy">Privacy</option>
                                                    <option value="policies">Policies</option>
                                                    <option value="about_app">About_app</option>
                                                    <option value="Explain">Explain</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="privacyTitle" class="col-sm-2 control-label">@lang('leftsidebar.privacyTitle')</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="privacyTitle" class="form-control" placeholder="@lang('leftsidebar.privacyTitle')" value="@if(!empty($privacy)){{$privacy->privacyTitle}}@else{{old('privacyTitle')}}@endif" required  id="privacyTitle">
                                            </div>

                                            <label for="editor1" class="col-sm-2">privacy</label>
                                            <div class="col-sm-10">
                                                <textarea id="editor1" type="text" name="privacy" class="form-control" rows="10" placeholder="privacy">@if(!empty($privacy)){{$privacy->privacy}}@endif</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="privacyTitleAr" class="col-sm-2 control-label">@lang('leftsidebar.privacyTitleAr')</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="privacyTitleAr" class="form-control" placeholder="@lang('leftsidebar.privacyTitleAr')" value="@if(!empty($privacy)){{$privacy->privacyTitleAr}}@else{{old('privacyTitleAr')}}@endif" required  id="privacyTitleAr">
                                            </div>

                                             <label for="editor1" class="col-sm-2">privacyAr</label>
                                            <div class="col-sm-10">
                                                <textarea id="editor2" type="text" name="privacyAr" class="form-control" rows="10" placeholder="privacyAr">@if(!empty($privacy)){{$privacy->privacyAr}}@endif</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-info" value="@if(empty($privacy)) @lang('leftsidebar.add') @else @lang('leftsidebar.edit') @endif">
                                    </div>
                                </form>
                          </div>
                    </div>
              </div>
      </section>
</div>