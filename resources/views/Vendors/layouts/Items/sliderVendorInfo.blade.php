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
			              		@lang('leftsidebar.sliders')
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
									@if($item->sliderVendorStatus)
										<tr>
								          	<td>{{$key+1}}</td>
								          	<td>{{$item->itemName}}</td>
								          	<td>{{$item->itemNameAr}}</td>
								          	<td>
								          		<img src="{{url('uploads/itemImages/'.$item->itemSliderImage)}}" class="table-image">
								          	</td>
								          	<td>
									          	<div class="btn-group">
									          		<a class="btn btn-{{$item->sliderVendorStatus ? 'success' : 'danger'}}" href="{{url('vendor/changeItemSliderStatus/'.$item->id)}}">
									          			<span class="text">
									          				@if($item->sliderVendorStatus)
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
									@if(!$item->sliderVendorStatus)
										<tr>
								          	<td>{{$key+1}}</td>
								          	<td>{{$item->itemName}}</td>
								          	<td>{{$item->itemNameAr}}</td>
								          	<td>
								          		<img src="{{url('uploads/itemImages/'.$item->itemSliderImage)}}" style="height: 100px;width:100px">
								          	</td>
								          	<td>
									          	<div class="btn-group">
									          		<a class="btn btn-{{$item->sliderVendorStatus ? 'success' : 'danger'}}" href="{{url('vendor/changeItemSliderStatus/'.$item->id.'/')}}">
									          			<span class="text">
									          				@if($item->sliderVendorStatus)
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