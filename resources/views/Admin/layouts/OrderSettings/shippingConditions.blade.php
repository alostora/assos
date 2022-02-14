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
			              	<h3 class="box-title">@lang('leftsidebar.Shipping conditions')</h3>
		              	</div>
				      	<a href="{{url('admin/viewCreateCondition')}}" class="btn btn-primary col-xs-6">
				      		<i class="fa fa-plus"></i>
				      		@lang('leftsidebar.Add')
				      	</a>
		            </div>
		            <div class="box-body table-responsive no-padding">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.shippingConditions')</th>
			                  	<th>@lang('leftsidebar.shippingConditionsAr')</th>
			                  	<th>@lang('leftsidebar.image')</th>
			                  	<th>@lang('leftsidebar.Operations')</th>
			                </tr>
							@if(!empty($conditions))
								@foreach($conditions as $key=>$cond)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<td>{{$cond->shippingConditions}}</td>
							          	<td>{{$cond->shippingConditionsAr}}</td>
							          	<td>
								          	<img src="{{url('Admin_uploads/conditions/'.$cond->image)}}" class="table-image">
								          </td>
							          	<td>
								          	<div class="btn-group">
								          		<a class="btn btn-success" href="{{url('admin/viewCreateCondition')}}">
								          			<i class="fa fa-edit"></i>
								          		</a>
							          	 		<a class="btn btn-danger" href="{{url('admin/deleteCondition')}}" onclick="return confirm('Are you sure?');" >
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
