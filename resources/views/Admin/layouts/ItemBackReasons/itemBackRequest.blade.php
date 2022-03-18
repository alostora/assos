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
			              	<h3 class="box-title">@lang('leftsidebar.Item back request')</h3>
		              	</div>
		            </div>
		            <div class="box-body table-responsive no-padding">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.orders')</th>
			                  	<th>@lang('leftsidebar.items')</th>
			                  	<th>@lang('leftsidebar.user')</th>
			                  	<th>@lang('leftsidebar.status')</th>
			                  	<th>@lang('leftsidebar.Count')</th>
			                  	<th>@lang('leftsidebar.Item back reason')</th>
			                  	<th>@lang('leftsidebar.Operations')</th>
			                </tr>
							@if(!empty($itemRequests))
								@foreach($itemRequests as $key=>$r_item)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<td>{{\App\Models\Order::find($r_item->order_id)->orderCode}}</td>
							          	<td>
							          		@if(!empty(\App\Models\Order_item::find($r_item->order_item_id)->item_id))
							          			{{\App\Models\Item::find(\App\Models\Order_item::find($r_item->order_item_id)->item_id)->itemName}}
							          		@endif
							          	</td>
							          	<td>
							          		name : {{\App\Models\User::find($r_item->user_id)->name}}
							          		<br>
							          		phone : {{\App\Models\User::find($r_item->user_id)->phone}}
							          	</td>
							          	<td>{{$r_item->status}}</td>
							          	<td>{{$r_item->item_back_count}}</td>
							          	<td>
							          		{{\App\Models\Item_back_reason::find($r_item->reason_id)->backReasonName}}
							          	</td>
							          	<td>
								          	<div class="btn-group">
							          	 		<a class="btn btn-danger" href="{{url('admin/deleteItemBackRequest/'.$r_item->id)}}" onclick="return confirm('Are you sure?');" >
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
