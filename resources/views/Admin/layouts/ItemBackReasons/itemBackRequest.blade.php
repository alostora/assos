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
			                  	<th>@lang('leftsidebar.order_id')</th>
			                  	<th>@lang('leftsidebar.order_item_id')</th>
			                  	<th>@lang('leftsidebar.user_id')</th>
			                  	<th>@lang('leftsidebar.status')</th>
			                  	<th>@lang('leftsidebar.count')</th>
			                  	<th>@lang('leftsidebar.reason_id')</th>
			                  	<th>@lang('leftsidebar.Operations')</th>
			                </tr>
							@if(!empty($itemRequests))
								@foreach($itemRequests as $key=>$r_item)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<td>{{$r_item->order_id}}</td>
							          	<td>{{$r_item->order_item_id}}</td>
							          	<td>{{$r_item->user_id}}</td>
							          	<td>{{$r_item->status}}</td>
							          	<td>{{$r_item->item_back_count}}</td>
							          	<td>{{$r_item->reason_id}}</td>
							          	<td>
								          	<div class="btn-group">
								          		<a class="btn btn-success" href="{{url('admin/viewCreateitemBackReason/'.$r_item->id)}}">
								          			<i class="fa fa-edit"></i>
								          		</a>
							          	 		<a class="btn btn-danger" href="{{url('admin/deleteitemBackReason/'.$r_item->id)}}" onclick="return confirm('Are you sure?');" >
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
