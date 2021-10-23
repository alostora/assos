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
				              	<h3 class="box-title">@lang('leftsidebar.Vendors Info')</h3>
			              	</div>
						      	<a href="{{url('admin/viewCreateVendor')}}" class="btn btn-primary col-xs-6">
						      		<i class="fa fa-plus"></i>
						      		<i class="fa fa-user"></i>
						      		@lang('leftsidebar.Add')
						      	</a>
			            </div>


			            <div class="box-body table-responsive no-padding">
			              	<table class="table table-hover">
				                <tr>
				                  	<th>#</th>
				                  	<th>@lang('leftsidebar.vendor_name')</th>
				                  	<th>@lang('leftsidebar.phone')</th>
				                  	<th>@lang('leftsidebar.email')</th>
				                  	<th>@lang('leftsidebar.vendor_image')</th>
				                  	<th>@lang('leftsidebar.address')</th>
				                  	<th>@lang('leftsidebar.Created_at')</th>
				                  	<th>@lang('leftsidebar.Updated_at')</th>
				                  	<th>@lang('leftsidebar.Operations')</th>
				                </tr>
							@if(!empty($vendors))
								@foreach($vendors as $key=>$vendor)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<td>{{$vendor->vendor_name}}</td>
							          	<td>{{$vendor->phone}}</td>
							          	<td>{{$vendor->email}}</td>
							          	<td><img src="{{url('Admin_uploads/vendors/'.$vendor->vendor_image)}}" style="height: 100px;width:100px"></td>
							          	<td>{{$vendor->address}}</td>
							          	<td>{{$vendor->created_at}}</td>
							          	<td>{{$vendor->updated_at}}</td>
							          	<td>
								          	<div class="btn-group">
								          		<a class="btn btn-success" href="{{url('admin/viewCreateVendor/'.$vendor->id)}}">
								          			<i class="fa fa-edit"></i>
								          		</a>
								          	
							          	 		<a class="btn btn-danger" href="{{url('admin/deleteAdmin/'.$vendor->id)}}" onclick="return confirm('Are you sure?');" >
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
