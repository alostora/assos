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
			              	<h3 class="box-title">@lang('leftsidebar.bannerImage')</h3>
		              	</div>
				      	<a href="{{url('admin/viewCreateBanner')}}" class="btn btn-primary col-xs-6">
				      		<i class="fa fa-plus"></i>
				      		@lang('leftsidebar.Add')
				      	</a>
		            </div>

		            <div class="box-body table-responsive no-padding">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>@lang('leftsidebar.image')</th>
			                  	<th>@lang('leftsidebar.link')</th>
			                  	<th>@lang('leftsidebar.Operations')</th>
			                </tr>
							@if(!empty($banner))
								<tr>
						          	<td>
						          		<img src="{{url('Admin_uploads/banners/'.$banner->image)}}" class="table-image">
						          	</td>
						          	<td>{{$banner->link}}</td>
						          	<td>
							          	<div class="btn-group">
							          		<a class="btn btn-success" href="{{url('admin/viewCreateBanner')}}">
							          			<i class="fa fa-edit"></i>
							          		</a>
							          	
						          	 		<a class="btn btn-danger" href="{{url('admin/deleteBanner')}}" onclick="return confirm('Are you sure?');" >
						          	 			<i class="fa fa-trash"></i>
						          	 		</a>
					          	 		</div>
						          	</td>
						      	</tr>
							@endif
		              	</table>
		            </div>
         	 	</div>
	        </div>
     	</div>
	</section>	
</div>