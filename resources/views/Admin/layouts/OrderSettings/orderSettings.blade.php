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
				      	<a href="{{url('admin/viewCreateOrderSettings')}}" class="btn btn-primary col-xs-6">
				      		<i class="fa fa-plus"></i>
				      		@lang('leftsidebar.Add')
				      	</a>
		            </div>
		            <div class="box-body table-responsive no-padding">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.settingName')</th>
			                  	<th>@lang('leftsidebar.settingNameAr')</th>
			                  	<th>@lang('leftsidebar.settingValue')</th>
			                  	<th>@lang('leftsidebar.settingOptions')</th>
			                  	<!-- <th>@lang('leftsidebar.settingOptionsAr')</th> -->
			                  	<th>@lang('leftsidebar.Operations')</th>
			                </tr>
							@if(!empty($settings))
								@foreach($settings as $key=>$setting)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<td>{{$setting->settingName}}</td>
							          	<td>{{$setting->settingNameAr}}</td>
							          	<td>{{$setting->settingValue}}</td>
							          	<td>{{$setting->settingOptions}}</td>
							          	<!-- <td>{{$setting->settingOptionsAr}}</td> -->
							          	<td>
								          	<div class="btn-group">
								          		<a class="btn btn-success" href="{{url('admin/viewCreateOrderSettings/'.$setting->id)}}">
								          			<i class="fa fa-edit"></i>
								          		</a>
							          	 		<a class="btn btn-danger" href="{{url('admin/deleteOrderSettings/'.$setting->id)}}" onclick="return confirm('Are you sure?');" >
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
