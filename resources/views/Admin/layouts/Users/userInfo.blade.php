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
                        <div class="col-xs-6">
                            <h3 class="box-title">@lang('leftsidebar.Admin Info')</h3>
                        </div>
                        <a href="{{url('admin/viewCreateAdmin')}}" class="btn btn-primary col-xs-6">
                            <i class="fa fa-plus"></i>
                            <i class="fa fa-user"></i>
                            @lang('leftsidebar.Add')
                        </a>
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>@lang('leftsidebar.Name')</th>
                                <th>@lang('leftsidebar.Email')</th>
                                <th>@lang('leftsidebar.Created_at')</th>
                                <th>@lang('leftsidebar.Updated_at')</th>
                            </tr>
                            @if(!empty($users))
                                @foreach($users as $key=>$user)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->created_at}}</td>
                                        <td>{{$user->updated_at}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
