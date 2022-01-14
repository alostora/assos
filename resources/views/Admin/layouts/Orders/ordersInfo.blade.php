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
                                @lang('leftsidebar.Sales info')
                            </h3>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('leftsidebar.orderCode')</th>
                                    <th>@lang('leftsidebar.status')</th>
                                    <th>@lang('leftsidebar.shippingType')</th>
                                    <th>@lang('leftsidebar.paymentMethod')</th>
                                    <th>@lang('leftsidebar.total_price')</th>
                                    <th>@lang('leftsidebar.discountCopon')</th>
                                    <th>@lang('leftsidebar.addedTax')</th>
                                    <th>@lang('leftsidebar.sub_total')</th>
                                    <th>@lang('leftsidebar.total')</th>
                                    <th>@lang('leftsidebar.shippingValue')</th>
                                    <th>@lang('leftsidebar.shippingAddress_id')</th>
                                    <th>@lang('leftsidebar.clientName')</th>
                                    
                                    <th>@lang('leftsidebar.items')</th>
                                    <th>@lang('leftsidebar.Operations')</th>
                                </tr>
                            </thead>
                            @if(!empty($orders))
                                @foreach($orders as $key=>$order)
                                    <tr data-toggle="collapse" data-target="#items{{$order->id}}" class="accordion-toggle">
                                        <td>{{$key+1}}</td>
                                        <td>{{$order->orderCode}}</td>
                                        <td>{{Lang::get('leftsidebar.'.$order->status)}}</td>
                                        <td>{{$order->shippingType}}</td>
                                        <td>{{$order->paymentMethod}}</td>
                                        <td>{{$order->total_price}}</td>
                                        <td>{{$order->discountCopon}}</td>
                                        <td>{{$order->addedTax}}</td>
                                        <td>{{$order->sub_total}}</td>
                                        <td>{{$order->total}}</td>
                                        <td>{{$order->shippingValue}}</td>
                                        <td>{{$order->shippingAddress_id}}</td>
                                        <td>{{$order->user_id}}</td>
                                        <td>
                                            <button class="btn btn-default btn-xs">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </button>
                                        </td>
                                        <td>@lang('leftsidebar.Operations')</td>
                                    </tr>
                                    @if(count($order->order_items))
                                        @foreach($order->order_items as $item)
                                            <tr>
                                                <td colspan="15" class="hiddenRow">
                                                    <div class="accordian-body collapse" id="items{{$order->id}}"> 
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr class="info">
                                                                    <th>@lang('leftsidebar.itemName')</th>
                                                                    <th>@lang('leftsidebar.Count')</th>
                                                                    <th>@lang('leftsidebar.itemPriceAfterDis')</th>
                                                                    <th>@lang('leftsidebar.itemImage')</th>
                                                                    <th>@lang('leftsidebar.order_items_props')</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr data-toggle="collapse" class="accordion-toggle" data-target="#props{{$item->id}}">
                                                                    <td>{{$item->itemName}}</td>
                                                                    <td>{{$item->item_count}}</td>
                                                                    <td>{{$item->itemPriceAfterDis}}</td>
                                                                    <td>
                                                                        <img src="{{$item->itemImage}}" style="height:70px;width: 70px;border-radius: 30%;">
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="btn btn-default btn-sm">
                                                                            <i class="glyphicon glyphicon-cog"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                @if(count($item->order_items_props))
                                                                    <tr>
                                                                        <td colspan="12" class="hiddenRow">
                                                                            <div class="accordian-body collapse" id="props{{$item->id}}"> 
                                                                                <table class="table table-striped">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>propertyName</th>
                                                                                            <th>type</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($item->order_items_props as $orderITemProp)
                                                                                        <tr>
                                                                                            <td>
                                                                                                @if($orderITemProp->type == 'color')
                                                                                                    <div style="background-color: {{$orderITemProp->propertyName}};width: 100px;height: 50px;"></div>
                                                                                                @else
                                                                                                    {{$orderITemProp->propertyName}}
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{$orderITemProp->type}}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div> 
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div> 
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>  
</div>






