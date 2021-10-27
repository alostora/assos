<div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
        
        @if(!empty($items))
            {{$items->render()}}
        @endif
        <div class="row">
            @foreach($items as $key=>$item)
                <div class="col-md-4">
                    <div class="box box-widget">

                        <div class="box-header with-border">
                            <div class="user-block">
                                <img class="img-circle" src="{{url('uploads/itemImages/'.$item->itemImage)}}" alt="{{$item->itemImage}}" style="height: 50;width: 50;">
                                <span class="username">
                                    <a href="{{URL::to('single-item/'.$item->itemName.'/'.Crypt::encryptString($item->id))}}">{{$item->itemName}}</a>
                                </span>
                                <span class="description">
                                    @lang('leftsidebar.Published at') : {{$item->created_at}}
                                </span>
                                <span class="description">
                                    @lang('leftsidebar.itemCount') : {{$item->itemCount}}
                                </span>
                                <span class="description">
                                    @lang('leftsidebar.itemPrice') : {{$item->itemPrice}}
                                </span>
                                <span class="description">
                                    @lang('leftsidebar.discountValue') : {{$item->discountValue}} %
                                </span>
                                <span class="description">
                                    @lang('leftsidebar.itemPriceAfterDis') : {{$item->itemPriceAfterDis}}
                                </span>
                                <span class="description">
                                    @lang('leftsidebar.facePage') : {{$item->facePage}}
                                </span>
                            </div>
                            <div class="box-tools">
                                <a href="{{url('viewCreateItem/'.Crypt::encryptString($item->id))}}" class="btn btn-box-tool" title="تعديل">
                                    <i class="fa fa-circle-o"></i>
                                </a>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" id="{{$key}}" onclick="removeItem('{{Crypt::encryptString($item->id)}}',this.id);">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="box-body">
                                <div id="carousel-example-generic{{$key}}" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                      @if(count($item->other_item_images))
                                        @foreach($item->other_item_images as $kkeyy=>$ItemImg)
                                        @if($kkeyy <= 1)
                                            <li data-target="#carousel-example-generic{{$key}}" data-slide-to="{{$kkeyy}}" class="@if($kkeyy == 0) active @endif"></li>
                                          @endif
                                        @endforeach
                                      @endif
                                    </ol>
                                    <div class="carousel-inner">
                                      @if(count($item->other_item_images))
                                        @foreach($item->other_item_images as $kkeyx=>$ItemImgg)
                                            @if($kkeyx <= 1)
                                            <div class="@if($kkeyx == 0) item active @else item @endif">
                                                <img src="{{url('uploads/itemImages/'.$ItemImgg->itemImageName)}}" alt="First slide" style="height: 300px;width: 100%;">
                                                <div class="carousel-caption">
                                                  {{$item->itemName}}
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                      @endif
                                    </div>
                                    <a class="left carousel-control" href="#carousel-example-generic{{$key}}" data-slide="prev" style="right: 85%">
                                        <span class="fa fa-angle-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example-generic{{$key}}" data-slide="next">
                                        <span class="fa fa-angle-right"></span>
                                    </a>
                                </div>
                            </div>

                            <a href="https://www.facebook.com/sharer/sharer.php?u={{URL::to('/')}}" class="btn btn-default btn-xs"><i class="fa fa-share"></i> @lang('leftsidebar.Share') @lang('leftsidebar.Face')</a>

                            <a href="https://twitter.com/share?url={{URL::to('/')}}" class="btn btn-default btn-xs"><i class="fa fa-share"></i> @lang('leftsidebar.Share') @lang('leftsidebar.Twitter')</a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        @if(!empty($items))
            {{ $items->render() }}
        @endif
    </section>
</div>





<script type="text/javascript">

    function removeItem(itemId,id){
        /*console.log("{{url('ajaxRemoveItem')}}/"+itemId);
        return false;*/
        if(!confirm('@lang("leftsidebar.Are you sure")')){
          return false;
        }

        $.ajax({
            type : "get",
            url  : "{{url('ajaxRemoveItem')}}/"+itemId,
            success: function(result){
              if(result == "true"){
              }
            }
        });
        $("#"+id).attr("data-widget","remove");
    }

</script>
