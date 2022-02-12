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
			              	<h3 class="box-title">@lang('leftsidebar.offersInfo')</h3>
		              	</div>
				      	<a href="{{url('admin/viewCreateitemBackReason')}}" class="btn btn-primary col-xs-6">
				      		<i class="fa fa-plus"></i>
				      		@lang('leftsidebar.Add')
				      	</a>
		            </div>
		            <div class="box-body table-responsive no-padding">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.backReasonName')</th>
			                  	<th>@lang('leftsidebar.backReasonArName')</th>
			                  	<th>@lang('leftsidebar.Operations')</th>
			                </tr>
							@if(!empty($reasons))
								@foreach($reasons as $key=>$reason)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<td>{{$reason->backReasonName}}</td>
							          	<td>{{$reason->backReasonArName}}</td>
							          	
							          	<td>
								          	<div class="btn-group">
								          		<a class="btn btn-success" href="{{url('admin/viewCreateitemBackReason/'.$reason->id)}}">
								          			<i class="fa fa-edit"></i>
								          		</a>
							          	 		<a class="btn btn-danger" href="{{url('admin/deleteitemBackReason/'.$reason->id)}}" onclick="return confirm('Are you sure?');" >
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
