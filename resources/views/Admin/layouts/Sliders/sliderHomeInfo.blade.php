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
			              	<h3 class="box-title">@lang('leftsidebar.sliderInfo'.Request('type'))</h3>
		              	</div>
				      	<label class="col-xs-6 label label-success">
				      		@lang('leftsidebar.categories')
				      	</label>
		            </div>

		            <div class="box-body table-responsive no-padding col-xs-6">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.categoryName')</th>
			                  	<th>@lang('leftsidebar.categoryNameAr')</th>
			                  	<th>@lang('leftsidebar.categorySliderImage')</th>
			                  	<th>@lang('leftsidebar.sliderStatus')</th>
			                </tr>
							@if(!empty($categories))
								@foreach($categories as $key=>$cat)
									@if($cat->sliderHomeStatus)
										<tr>
								          	<td>{{$key+1}}</td>
								          	<td>{{$cat->categoryName}}</td>
								          	<td>{{$cat->categoryNameAr}}</td>
								          	<td>
								          		<img src="{{url('Admin_uploads/categories/'.$cat->categorySliderImage)}}" class="table-image">
								          	</td>
								          	<td>
									          	<div class="btn-group">
									          		<a class="btn btn-sm btn-{{$cat->sliderHomeStatus ? 'success' : 'danger'}}" href="{{url('admin/changeCatSliderStatus/'.$cat->id.'/'.Request('type'))}}">
									          			<span class="text">
									          				@if($cat->sliderHomeStatus)
										          				@lang('leftsidebar.active')
										          			@else
										          				@lang('leftsidebar.inActive')
										          			@endif
										          		</span>
									          			<i class="fa fa-info"></i>
									          		</a>
							          	 		</div>
								          	</td>
								      	</tr>
							      	@endif
								@endforeach
							@endif
		              	</table>
		            </div>
		            <div class="box-body table-responsive no-padding col-xs-6">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.categoryName')</th>
			                  	<th>@lang('leftsidebar.categoryNameAr')</th>
			                  	<th>@lang('leftsidebar.categorySliderImage')</th>
			                  	<th>@lang('leftsidebar.sliderStatus')</th>
			                </tr>
							@if(!empty($categories))
								@foreach($categories as $key=>$cat)
									@if(!$cat->sliderHomeStatus)
										<tr>
								          	<td>{{$key+1}}</td>
								          	<td>{{$cat->categoryName}}</td>
								          	<td>{{$cat->categoryNameAr}}</td>
								          	<td>
								          		<img src="{{url('Admin_uploads/categories/'.$cat->categorySliderImage)}}" class="table-image">
								          	</td>
								          	<td>
									          	<div class="btn-group">
									          		<a class="btn btn-sm btn-{{$cat->sliderHomeStatus ? 'success' : 'danger'}}" href="{{url('admin/changeCatSliderStatus/'.$cat->id.'/'.Request('type'))}}">
									          			<span class="text">
									          				@if($cat->sliderHomeStatus)
										          				@lang('leftsidebar.active')
										          			@else
										          				@lang('leftsidebar.inActive')
										          			@endif
										          		</span>
									          			<i class="fa fa-info"></i>
									          		</a>
							          	 		</div>
								          	</td>
								      	</tr>
							      	@endif
								@endforeach
							@endif
		              	</table>
		            </div>
         	 	</div>
	        </div>
      	</div>
      	<!-- ************************************** -->
      	<!-- ************************************** -->
      	<!-- ************************************** -->
      	<!-- ************************************** -->
      	<!-- ************************************** -->
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
			              		@lang('leftsidebar.sliderInfo'.Request('type'))
			              	</h3>
		              	</div>
				      	<label class="col-xs-6 label label-success">
				      		@lang('leftsidebar.items')
				      	</label>
		            </div>
		            <div class="box-body table-responsive no-padding  col-xs-6">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.itemName')</th>
			                  	<th>@lang('leftsidebar.itemNameAr')</th>
			                  	<th>@lang('leftsidebar.itemSliderImage')</th>
			                  	<th>@lang('leftsidebar.sliderStatus')</th>
			                </tr>
							@if(!empty($items))
								@foreach($items as $key=>$item)
									@if($item->sliderHomeStatus)
										<tr>
								          	<td>{{$key+1}}</td>
								          	<td>{{$item->itemName}}</td>
								          	<td>{{$item->itemNameAr}}</td>
								          	<td>
								          		<img src="{{url('uploads/itemImages/'.$item->itemSliderImage)}}" class="table-image">
								          	</td>
								          	<td>
									          	<div class="btn-group">
									          		<a class="btn btn-sm btn-{{$item->sliderHomeStatus ? 'success' : 'danger'}}" href="{{url('admin/changeItemSliderStatus/'.$item->id.'/'.Request('type'))}}">
									          			<span class="text">
									          				@if($item->sliderHomeStatus)
										          				@lang('leftsidebar.active')
										          			@else
										          				@lang('leftsidebar.inActive')
										          			@endif
										          		</span>
									          			<i class="fa fa-info"></i>
									          		</a>
							          	 		</div>
								          	</td>
								      	</tr>
							      	@endif
								@endforeach
							@endif
		              	</table>
		            </div>
		            <div class="box-body table-responsive no-padding  col-xs-6">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.itemName')</th>
			                  	<th>@lang('leftsidebar.itemNameAr')</th>
			                  	<th>@lang('leftsidebar.itemSliderImage')</th>
			                  	<th>@lang('leftsidebar.sliderStatus')</th>
			                </tr>
							@if(!empty($items))
								@foreach($items as $key=>$item)
									@if(!$item->sliderHomeStatus)
										<tr>
								          	<td>{{$key+1}}</td>
								          	<td>{{$item->itemName}}</td>
								          	<td>{{$item->itemNameAr}}</td>
								          	<td>
								          		<img src="{{url('uploads/itemImages/'.$item->itemSliderImage)}}" class="table-image">
								          	</td>
								          	<td>
									          	<div class="btn-group">
									          		<a class="btn btn-sm btn-{{$item->sliderHomeStatus ? 'success' : 'danger'}}" href="{{url('admin/changeItemSliderStatus/'.$item->id.'/'.Request('type'))}}">
									          			<span class="text">
									          				@if($item->sliderHomeStatus)
										          				@lang('leftsidebar.active')
										          			@else
										          				@lang('leftsidebar.inActive')
										          			@endif
										          		</span>
									          			<i class="fa fa-info"></i>
									          		</a>
							          	 		</div>
								          	</td>
								      	</tr>
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