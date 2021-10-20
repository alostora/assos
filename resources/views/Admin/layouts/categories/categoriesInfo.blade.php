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
				              	<h3 class="box-title">@lang('leftsidebar.Category Info')</h3>
			              	</div>
						      	<a href="{{url('admin/viewCreateCategory')}}" class="btn btn-primary col-xs-6">
						      		<i class="fa fa-plus"></i>
						      		<i class="fa fa-user"></i>
						      		@lang('leftsidebar.Add')
						      	</a>
			            </div>


			            <div class="box-body table-responsive no-padding">
			              	<table class="table table-hover">
				                <tr>
				                  	<th>#</th>
				                  	<th>@lang('leftsidebar.categoryName')</th>
				                  	<th>@lang('leftsidebar.categoryNameAr')</th>
				                  	<th>@lang('leftsidebar.Created_at')</th>
				                  	<th>@lang('leftsidebar.Updated_at')</th>
				                  	<th>@lang('leftsidebar.Operations')</th>
				                </tr>
							@if(!empty($categories))
								@foreach($categories as $key=>$cat)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<td>{{$cat->name}}</td>
							          	<td>{{$cat->name_ar}}</td>
							          	<td>{{$cat->created_at}}</td>
							          	<td>{{$cat->updated_at}}</td>
							          	<td>
								          	<div class="btn-group">
								          		<a class="btn btn-success" href="{{url('admin/viewCreateCategory/'.$cat->id)}}">
								          			<i class="fa fa-edit"></i>
								          		</a>
								          	
							          	 		<a class="btn btn-danger" href="{{url('admin/deleteCategory/'.$cat->id)}}" onclick="return confirm('Are you sure?');" >
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