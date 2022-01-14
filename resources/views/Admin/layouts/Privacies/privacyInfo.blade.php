<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                @if(session()->has('warning'))
                    <div class="alert alert-warning">{{session('warning')}}</div>
                @endif
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title col-sm-6">@lang('leftsidebar.Privacy & Policies')</h3>

                       <a href="{{url('admin/viewCreatePrivacy')}}" class="btn btn-primary col-sm-6">
                            <i class="fa fa-plus"></i> @lang('leftsidebar.Privacy & Policies')
                        </a>
                        
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('leftsidebar.privacyTitle')</th>
                                    <th>@lang('leftsidebar.privacyTitleAr')</th>
                                    <th>@lang('leftsidebar.privacy')</th>
                                    <th>@lang('leftsidebar.privacyAr')</th>
                                    <th>@lang('leftsidebar.type')</th>
                                    <th>@lang('leftsidebar.Operations')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($privacies))
                                    @foreach($privacies as $key=>$priv)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$priv->privacyTitle}}</td>
                                            <td>{{$priv->privacyTitleAr}}</td>
                                            <td>{{$priv->privacy}}</td>
                                            <td>{{$priv->privacyAr}}</td>
                                            <td>{{$priv->type}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-success" href="{{url('admin/viewCreatePrivacy/'.$priv->id)}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                
                                                    <a class="btn btn-danger" href="{{url('admin/deletePrivacy/'.$priv->id)}}" onclick="return confirm('Are you sure?');" >
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>  
</div>
