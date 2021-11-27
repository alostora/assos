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
                            <h3 class="box-title">
                                @lang('leftsidebar.offerItems')
                            </h3>
                        </div>
                        <a href="{{url('admin/viewCreateOfferItem/'.Request('offer_id'))}}" class="btn btn-primary col-xs-6">
                            <i class="fa fa-plus"></i>
                            @lang('leftsidebar.Add')
                        </a>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>@lang('leftsidebar.itemName')</th>
                                <th>@lang('leftsidebar.itemNameAr')</th>
                                <th>@lang('leftsidebar.itemImage')</th>
                                <th>@lang('leftsidebar.Operations')</th>
                            </tr>
                            @if(!empty($items))
                                @foreach($items as $key=>$item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->itemName}}</td>
                                        <td>{{$item->itemNameAr}}</td>
                                        <td>
                                            <img src="{{url('uploads/itemImages/'.$item->itemImage)}}" style="height: 100px;width:100px">
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-danger" href="{{url('admin/deleteItemOffer/'.$item->id.'/'.Request('offer_id'))}}">
                                                    <i class="fa fa-info"></i>
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