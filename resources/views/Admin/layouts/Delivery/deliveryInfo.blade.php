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
				              	<h3 class="box-title">@lang('leftsidebar.deliveryInfo')</h3>
			              	</div>
						      	<a href="{{url('admin/viewCreateDelivery')}}" class="btn btn-primary col-xs-6">
						      		<i class="fa fa-plus"></i>
						      		<i class="fa fa-user"></i>
						      		@lang('leftsidebar.Add')
						      	</a>
			            </div>

			            <div class="box-body table-responsive no-padding">
			              	<table class="table table-hover">
				                <tr>
				                  	<th>#</th>
				                  	<th>@lang('leftsidebar.image')</th>
				                  	<th>@lang('leftsidebar.name')</th>
				                  	<th>@lang('leftsidebar.email')</th>
				                  	<th>@lang('leftsidebar.phone')</th>
				                  	<th>@lang('leftsidebar.country')</th>
				                  	<th>@lang('leftsidebar.Operations')</th>
				                </tr>
								@if(!empty($deliveries))
									@foreach($deliveries as $key=>$delivery)
										<tr>
											<td>{{$key+1}}</td>
											<td>{{$delivery->image}}</td>
											<td>{{$delivery->name}}</td>
											<td>{{$delivery->email}}</td>
											<td>{{$delivery->phone}}</td>
											<td>@lang('leftsidebar.'.$delivery->country)</td>
											<td>
												<div class="btn-group">
													<a class="btn btn-success" href="{{url('admin/viewCreateDelivery/'.$delivery->id)}}">
														<i class="fa fa-edit"></i>
													</a>

													<a class="btn btn-danger" href="{{url('admin/deleteDelivery/'.$delivery->id)}}" onclick="return confirm('Are you sure?');" >
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
