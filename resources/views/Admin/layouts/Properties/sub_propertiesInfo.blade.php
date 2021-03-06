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
				              	@lang('leftsidebar.propertiesInfo')
			              	</h3>
		              	</div>
				      	<a href="{{url('admin/sub_viewCreateProperty/'.Request('propId'))}}" class="btn btn-primary col-xs-6">
				      		<i class="fa fa-plus"></i>
				      		@lang('leftsidebar.Add')
				      	</a>
		            </div>
		            <div class="box-body table-responsive no-padding">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.propertyName')</th>
			                  	<th>@lang('leftsidebar.Operations')</th>
			                </tr>
							@if(!empty($properties))
								@foreach($properties as $key=>$property)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<?php 
							          		$propertyMain = App\Models\Property::find($property->prop_id)
							          	?>
							          	<td>
							          		@if($propertyMain->type == 'color')
							          			
							          		<div style="height: 50px;width:50px;border-radius: 50%;background-color:{{$property->propertyName}}"></div>
							          		@else
							          			{{$property->propertyName}}
							          		@endif

							          	</td>
							          	<td>
								          	<div class="btn-group">
								          		<a class="btn btn-success" href="{{url('admin/sub_viewCreateProperty/'.Request('propId').'/'.$property->id)}}">
								          			<i class="fa fa-edit"></i>
								          		</a>
								          	
							          	 		<a class="btn btn-danger" href="{{url('admin/sub_deleteProperty/'.$property->id)}}" onclick="return confirm('Are you sure?');" >
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