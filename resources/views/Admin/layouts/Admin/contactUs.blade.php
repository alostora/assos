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
				              	@lang('leftsidebar.contactUs')
			              	</h3>
		              	</div>
		            </div>

		            <div class="box-body table-responsive no-padding">
		              	<table class="table table-hover">
			                <tr>
			                  	<th>#</th>
			                  	<th>@lang('leftsidebar.name')</th>
			                  	<th>@lang('leftsidebar.email')</th>
			                  	<th>@lang('leftsidebar.message')</th>
			                </tr>
							@if(!empty($messages))
								@foreach($messages as $key=>$msg)
									<tr>
							          	<td>{{$key+1}}</td>
							          	<td>{{$msg->name}}</td>
							          	<td>{{$msg->email}}</td>
							          	<td>{{$msg->message}}</td>
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