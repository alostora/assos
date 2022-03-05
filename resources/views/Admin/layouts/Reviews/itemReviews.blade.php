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
			              	<h3 class="box-title">@lang('leftsidebar.Comments')</h3>
		              	</div>
		            </div>
		            <div class="box-body table-responsive no-padding">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.Comments')</th>
			                  	<th>@lang('leftsidebar.Rates')</th>
			                  	<th>@lang('leftsidebar.status')</th>
			                  	<th>@lang('leftsidebar.Operations')</th>
			                </tr>
							@if(!empty($reviews))
								@foreach($reviews as $key=>$review)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<td>{{$review->comment}}</td>
							          	<td>{{$review->rate}} / 5</td>
							          	<td>
							          		@if($review->status == 'waiting')
							          			<label class="label label-warning label-sm">
							          				@lang('leftsidebar.'.$review->status)
							          			</label>
							          		@elseif($review->status == 'accepted')
							          			<label class="label label-success label-sm">
							          				@lang('leftsidebar.'.$review->status)
							          			</label>
							          		@elseif($review->status == 'refused')
							          			<label class="label label-danger label-sm">
							          				@lang('leftsidebar.'.$review->status)
							          			</label>
							          		@endif
							          	</td>
							          	<td>
								          	<div class="btn-group">
								          		<a class="btn btn-success" href="{{url('admin/changeReviewStatus/'.$review->id.'/accepted')}}">
								          			@lang('leftsidebar.accept')
								          		</a>
							          	 		<a class="btn btn-danger" href="{{url('admin/changeReviewStatus/'.$review->id.'/refused')}}" onclick="return confirm('Are you sure?');" >
							          	 			@lang('leftsidebar.refuse')
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
