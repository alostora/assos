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
			              	<h3 class="box-title">@lang('leftsidebar.Offers Info')</h3>
		              	</div>
				      	<a href="{{url('admin/viewCreateOffer')}}" class="btn btn-primary col-xs-6">
				      		<i class="fa fa-plus"></i>
				      		@lang('leftsidebar.Add')
				      	</a>
		            </div>
		            <div class="box-body table-responsive no-padding">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.offerName')</th>
			                  	<th>@lang('leftsidebar.offerNameAr')</th>
			                  	<th>@lang('leftsidebar.offerImage')</th>
			                  	<th>@lang('leftsidebar.offerItems')</th>
			                  	<th>@lang('leftsidebar.Operations')</th>
			                </tr>
						@if(!empty($offers))
							@foreach($offers as $key=>$offer)
								<tr>
						          	<td>{{$key+1}}</td>
						          	<td>{{$offer->offerName}}</td>
						          	<td>{{$offer->offerNameAr}}</td>
						          	<td>
						          		<img src="{{url('Admin_uploads/offers/'.$offer->offerImage)}}" style="height: 100px;width:100px">
						          	</td>

						          	<td>
							          	<div class="btn-group">
							          		<a class="btn btn-success" href="{{url('admin/offerItems/'.$offer->id)}}">
							          			<span class="text">
								          			@lang('leftsidebar.offerItems')
								          		</span>
							          			<i class="fa fa-info"></i>
							          		</a>
					          	 		</div>
						          	</td>
						        
						          	<td>
							          	<div class="btn-group">
							          		<a class="btn btn-success" href="{{url('admin/viewCreateOffer/'.$offer->id)}}">
							          			<i class="fa fa-edit"></i>
							          		</a>
							          	
						          	 		<a class="btn btn-danger" href="{{url('admin/deleteOffer/'.$offer->id)}}" onclick="return confirm('Are you sure?');" >
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
