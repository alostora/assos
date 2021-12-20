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
                            <h3 class="box-title">@lang('leftsidebar.coponsInfo')</h3>
                        </div>
                        <a href="{{url('vendor/viewCreateCopon')}}" class="btn btn-primary col-xs-6">
                            <i class="fa fa-plus"></i>
                            @lang('leftsidebar.Add')
                        </a>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>@lang('leftsidebar.code')</th>
                                <th>@lang('leftsidebar.dateFrom')</th>
                                <th>@lang('leftsidebar.dateTo')</th>
                                <th>@lang('leftsidebar.discountValue')</th>
                                <th>@lang('leftsidebar.Operations')</th>
                            </tr>
                        @if(!empty($copons))
                            @foreach($copons as $key=>$copon)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    
                                    <td>{{$copon->code}}</td>
                                    <td>{{$copon->dateFrom}}</td>
                                    <td>{{$copon->dateTo}}</td>
                                    <td>{{$copon->discountValue}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-success" href="{{url('vendor/viewCreateCopon/'.$copon->id)}}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        
                                            <a class="btn btn-danger" href="{{url('vendor/deleteCopon/'.$copon->id)}}" onclick="return confirm('Are you sure?');" >
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
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
