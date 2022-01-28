<div class="content-wrapper" style="min-height: 901px;">
@if(count($categories)>0)
    <section class="content">
          <div class="row">
              <div class="col-sm-12">
                  <div class="box box-info">
                      @if(count($errors))
                        @foreach($errors->all() as $error)
                          <div class="col-sm-12">
                            <div class="alert alert-danger">{{$error}}</div>
                          </div>
                        @endforeach
                      @endif

                      @if(session()->has('success'))
                        <div class="col-sm-12">
                          <div class="alert alert-success">{{session('success')}}</div>
                        </div>
                      @endif

                      @if(session()->has('warning'))
                        <div class="col-sm-12">
                          <div class="alert alert-warning">{{session('warning')}}</div>
                        </div>
                      @endif

                      <div class="box-header with-border">
                          <h3 class="box-title">
                            @if(!empty($item))
                              @lang('leftsidebar.Edit') 
                            @else
                              @lang('leftsidebar.Add') 
                            @endif 
                            @lang('leftsidebar.Item')
                          </h3>
                      </div>
                      <form role="form" class="form-horizontal" action="{{url('vendor/createItem')}}" method="post" enctype="multipart/form-data">
                          <div class="box-body">
                              @csrf
                              <input type="hidden" name="id" value="@if(!empty($item)) {{Crypt::encryptString($item->id)}} @endif">

                              <div class="form-group">
                                <label for="department" class="control-label col-sm-2">
                                  @lang('leftsidebar.department')
                                </label>
                                <div class="col-sm-4">
                                  <select name="department" class="form-control" id="department" required>
                                    @if(!empty($item))
                                      @if($item->department == 'men')
                                        <option value="men" selected>@lang('leftsidebar.men')</option>
                                        <option value="women">@lang('leftsidebar.women')</option>
                                        <option value="kids">@lang('leftsidebar.kids')</option>
                                      @elseif($item->department == 'women')
                                        <option value="men">@lang('leftsidebar.men')</option>
                                        <option value="women" selected>@lang('leftsidebar.women')</option>
                                        <option value="kids">@lang('leftsidebar.kids')</option>
                                      @elseif($item->department == 'kids')
                                        <option value="men">@lang('leftsidebar.men')</option>
                                        <option value="women">@lang('leftsidebar.women')</option>
                                        <option value="kids" selected>@lang('leftsidebar.kids')</option>
                                      @endif
                                    @else
                                      <option value="men">@lang('leftsidebar.men')</option>
                                      <option value="women">@lang('leftsidebar.women')</option>
                                      <option value="kids">@lang('leftsidebar.kids')</option>
                                    @endif
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="itemName" class="control-label col-sm-2">@lang('leftsidebar.itemName')</label>
                                <div class="col-sm-4">
                                  <input id="itemName" type="text" name="itemName" class="form-control" placeholder="@lang('leftsidebar.itemName')" value="@if(!empty($item)) {{$item->itemName}} @endif" required>
                                </div>
                                <label for="itemNameAr" class="control-label col-sm-2">@lang('leftsidebar.itemNameAr')</label>
                                <div class="col-sm-4">
                                  <input id="itemNameAr" type="text" name="itemNameAr" class="form-control" placeholder="@lang('leftsidebar.itemNameAr')" value="@if(!empty($item)) {{$item->itemNameAr}} @endif" required>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="itemDescribeAr" class="control-label col-sm-2">@lang('leftsidebar.itemDescribeAr')</label>
                                <div class="col-sm-4">
                                  <textarea id="itemDescribeAr" type="text" name="itemDescribeAr" class="form-control" placeholder="@lang('leftsidebar.itemDescribeAr')">@if(!empty($item)){{$item->itemDescribeAr}}@endif</textarea>
                                </div>

                                <label for="itemDescribe" class="control-label col-sm-2">@lang('leftsidebar.itemDescribe')</label>
                                <div class="col-sm-4">
                                  <textarea id="itemDescribe" type="text" name="itemDescribe" class="form-control" placeholder="@lang('leftsidebar.itemDescribe')">@if(!empty($item)){{$item->itemDescribe}}@endif</textarea>
                                </div>
                              </div>

                              <div class="form-group">
                                  <label for="itemPrice" class="control-label col-sm-2" >@lang('leftsidebar.itemPrice')</label>
                                  <div class="col-sm-4">
                                    @if(!empty($item))
                                      <input id="itemPrice" type="number" step="any" name="itemPrice" class="form-control" placeholder="@lang('leftsidebar.itemPrice')" value="{{$item->itemPrice}}" onkeyup="checkDicount(this.value)" required>
                                    @else
                                      <input id="itemPrice" type="number" step="any" name="itemPrice" class="form-control" placeholder="@lang('leftsidebar.itemPrice')" onkeyup="checkDicount(this.value)" required>
                                    @endif
                                  </div>
                                  @if(!empty($item))
                                    <div id="discountValueAfterDiv">
                                      <label for="itemPriceAfterDis" class="control-label col-sm-2" >@lang('leftsidebar.itemPriceAfterDis')</label>
                                      <div class="col-sm-4">
                                        <input id="itemPriceAfterDis" name="itemPriceAfterDis" type="number" step="any" class="form-control" value="{{$item->itemPriceAfterDis}}" readonly>
                                      </div>
                                    </div>
                                  @else
                                    <div id="discountValueAfterDiv">
                                        <label for="itemPriceAfterDis" class="control-label col-sm-2" >@lang('leftsidebar.itemPriceAfterDis')</label>
                                        <div class="col-sm-4">
                                          <input id="itemPriceAfterDis" name="itemPriceAfterDis" type="number" step="any" name="itemPriceAfterDis" class="form-control" placeholder="@lang('leftsidebar.itemPriceAfterDis')" readonly>
                                        </div>
                                    </div>
                                  @endif
                              </div>

                              <div class="form-group">
                                @if(!empty($item))
                                  <div id="discountValueDiv">
                                    <label for="discountValue" class="control-label col-sm-2">@lang('leftsidebar.discountValue')</label>
                                    <div class="col-sm-4">
                                        <input id="discountValue" type="number" step="any" name="discountValue" class="form-control" value="{{$item->discountValue}}" onkeyup="publishDiscountValue(this.value)">
                                    </div>
                                  </div>
                                @else
                                  <div id="discountValueDiv">
                                    <label for="discountValue" class="control-label col-sm-2">@lang('leftsidebar.discountValue')</label>
                                    <div class="col-sm-4">
                                      <input id="discountValue" value="0" type="number" step="any" name="discountValue" class="form-control" placeholder="@lang('leftsidebar.discountValue')" onkeyup="publishDiscountValue(this.value)">
                                    </div>
                                  </div>
                                @endif
                              
                                <label for="itemCount" class="control-label col-sm-2">@lang('leftsidebar.itemCount')</label>
                                <div class="col-sm-4">
                                  @if(!empty($item)) 
                                    <input id="itemCount" type="number" step="any" name="itemCount" class="form-control" placeholder="@lang('leftsidebar.itemCount')" value="{{$item->itemCount}}" required>
                                    @else
                                      <input id="itemCount" type="number" step="any" name="itemCount" class="form-control" placeholder="@lang('leftsidebar.itemCount')" required>
                                   @endif
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="itemImage" class="control-label col-sm-2">@lang('leftsidebar.itemImage')</label>
                                <div class="col-sm-4">
                                    @if(!empty($item))
                                      <input id="itemImage" type="file" name="itemImage" class="form-control" accept=".png, .jpeg, .jpg" >
                                      @if(!empty($item->itemImage))
                                        <img src="{{url('uploads/itemImages/'.$item->itemImage)}}" style="height: 100px;width: 100px;">
                                      @else
                                        <label class="label label-success">@lang('leftsidebar.noImage')</label>
                                      @endif
                                    @else  
                                      <input id="itemImage" type="file" name="itemImage" class="form-control" accept=".png, .jpeg, .jpg" required >
                                    @endif
                                </div>
                            
                                <div id="otherItemImagesss">
                                  <label for="otherItemImages" class="control-label col-sm-2">@lang('leftsidebar.otherItemImages')</label>
                                  <div class="col-sm-4">
                                    @if(!empty($item))
                                    <input id="otherItemImages" type="file" name="otherItemImages[]" class="form-control" accept=".png, .jpeg, .jpg" multiple onchange="return onlyThreeImages();">
                                      @if(!empty($item->other_item_images))
                                        <div class="row">
                                          @foreach($item->other_item_images as $key=>$itemImage)
                                                <div class="col-md-4" id="img{{$key}}">
                                                  <div class="thumbnail">

                                                      <a href="#" class="btn btn-danger btn-xs" onclick='return deleteImage("{{Crypt::encryptString($itemImage->id)}}","img{{$key}}");'>
                                                          <i class="fa fa-trash"></i>
                                                      </a>

                                                      <img class="img-thumbnail" src="{{url('uploads/itemImages/'.$itemImage->itemImageName)}}" style="width:100%;max-height: 100px;">
                                                  </div>
                                                </div>
                                          @endforeach
                                        </div>
                                      @else
                                        <label class="label label-success">@lang('leftsidebar.noImage')</label>
                                      @endif
                                    @else
                                    <input id="otherItemImages" type="file" name="otherItemImages[]" class="form-control" accept=".png, .jpeg, .jpg" multiple onchange="return onlyThreeImages();" required>  
                                    @endif
                                  </div>
                                </div>
                              </div>

                              <div class="form-group">
                                  <label for="itemSliderImage" class="control-label col-sm-2">@lang('leftsidebar.itemSliderImage')</label>
                                  <div class="col-sm-4">
                                      @if(!empty($item))
                                          <input id="itemSliderImage" type="file" name="itemSliderImage" class="form-control" accept=".png, .jpeg, .jpg" >
                                          @if(!empty($item->itemSliderImage))
                                              <img src="{{url('uploads/itemImages/'.$item->itemSliderImage)}}" style="height: 100px;width: 100px;">
                                          @else
                                              <label class="label label-success">@lang('leftsidebar.noImage')</label>
                                          @endif
                                      @else  
                                          <input id="itemSliderImage" type="file" name="itemSliderImage" class="form-control" accept=".png, .jpeg, .jpg" required >
                                      @endif
                                  </div>
                              </div>

                              <div class="form-group">

                                <label for="videoLink" class="control-label col-sm-2">@lang('leftsidebar.videoLink')</label>
                                <div class="col-sm-4">
                                  <input id="videoLink" type="text" name="videoLink" class="form-control" placeholder="@lang('leftsidebar.videoLink')" value="@if(!empty($item)) {{$item->videoLink}} @endif">
                                </div>
                              
                                <label for="sub_cat_id" class="col-sm-2 control-label">
                                    @lang('leftsidebar.Category')
                                </label>
                                <div class="col-sm-4">
                                  <select name="sub_cat_id" id="sub_cat_id" class="form-control" required>
                                    <option value="">@lang('leftsidebar.Choose')</option>
                                    @if(App::getLocale() == "en")
                                      @foreach($categories as $cat)
                                        <optgroup label="{{$cat->categoryName}}">
                                          @if(count($cat->sub_categories))
                                              @foreach($cat->sub_categories as $subCat)
                                                  @if(!empty($item))
                                                      @if($item->sub_cat_id == $subCat->id)
                                                        <option value="{{$subCat->id}}" selected>{{$subCat->s_categoryName}}</option>
                                                      @else
                                                        <option value="{{$subCat->id}}">{{$subCat->s_categoryName}}</option>
                                                      @endif
                                                  @else  
                                                      <option value="{{$subCat->id}}">{{$subCat->s_categoryName}}</option>
                                                  @endif
                                              @endforeach
                                          @endif
                                        </optgroup>
                                      @endforeach
                                    @else
                                      @foreach($categories as $cat)
                                        <optgroup label="{{$cat->categoryNameAr}}">
                                          @if(count($cat->sub_categories))
                                              @foreach($cat->sub_categories as $subCat)
                                                  @if(!empty($item))
                                                      @if($item->sub_cat_id == $subCat->id)
                                                        <option value="{{$subCat->id}}" selected>{{$subCat->s_categoryNameAr}}</option>
                                                      @else
                                                        <option value="{{$subCat->id}}">{{$subCat->s_categoryNameAr}}</option>
                                                      @endif
                                                  @else  
                                                      <option value="{{$subCat->id}}">{{$subCat->s_categoryNameAr}}</option>
                                                  @endif
                                              @endforeach
                                          @endif
                                        </optgroup>
                                      @endforeach
                                    @endif  

                                  </select>   
                                </div>
                              </div>

                              <!-- HM -->
                              <div class="box-body">
                                  <div class="box-header with-border">
                                      <h3 class="box-title">@lang('leftsidebar.itemProperities')</h3>
                                  </div>

                                  <div class="form-group">
                                    <label for="main_prop_type" class="col-sm-2 control-label">
                                      @lang('leftsidebar.main_prop_type')
                                    </label>
                                    <div class="col-sm-6">
                                      <select name="main_prop_type" class="form-control" id="main_prop_type" onchange="return propType(this.value);" value="{{!empty($item) ? $item->main_prop_type : ''}}">
                                          <option value="">@lang('leftsidebar.choose')</option>
                                          @if(!empty($item) && $item->main_prop_type == 'clothes_size')
                                            <option value="clothes_size" selected>@lang('leftsidebar.clothes_size')</option>
                                            <option value="shoes_size">@lang('leftsidebar.shoes_size')</option>
                                          @elseif(!empty($item) && $item->main_prop_type == 'shoes_size')
                                            <option value="clothes_size">@lang('leftsidebar.clothes_size')</option>
                                            <option value="shoes_size" selected>@lang('leftsidebar.shoes_size')</option>
                                          @else
                                            <option value="clothes_size">@lang('leftsidebar.clothes_size')</option>
                                            <option value="shoes_size">@lang('leftsidebar.shoes_size')</option>
                                          @endif
                                      </select>
                                    </div>
                                  </div>


                                  <div class="form-group alert alert-default" id="item_properities">
                                    <!-- here ya merna -->
                                    <div class="col-sm-12 alert alert-default" style="background-color:#605ca8;padding:15px 0px 15px 0px;">
                                        <label for="itemProperityName" class="col-sm-2 control-label" style="color:black">
                                          @lang('leftsidebar.itemProperityName')
                                        </label>
                                        <div class="col-sm-6">
                                          <select name="sub_prop_id[]" class="form-control js-example-basic-multiple" multiple>
                                              @foreach($properties as $mainKey=>$prop)
                                                <optgroup label="@lang('leftsidebar.'.$prop->type)" class="{{$prop->type}}" {{$prop->type != 'color' ? 'disabled' : ''}}>
                                                  @if(count($prop->sub_properties) > 0)
                                                    @if(!empty($item))
                                                        @if(!empty($selectedItemSubPro))
                                                          @foreach($prop->sub_properties as $s_key => $s_prop)
                                                              @if(in_array($s_prop->id, $selectedItemSubPro->toArray()))
                                                                <option value="{{$s_prop->id}}" selected>
                                                                  {{$s_prop->propertyName}}
                                                                </option>
                                                                <script type="text/javascript">
                                                                  (function() {
                                                                    $("."+$('#main_prop_type').val()).show();
                                                                  })();
                                                                </script>
                                                              @else
                                                                <option value="{{$s_prop->id}}">
                                                                  {{$s_prop->propertyName}}
                                                                </option>
                                                              @endif
                                                          @endforeach
                                                        @else
                                                          @foreach($prop->sub_properties as $s_key => $s_prop)
                                                            <option value="{{$s_prop->id}}">
                                                              {{$s_prop->propertyName}}
                                                            </option>
                                                          @endforeach
                                                        @endif
                                                    @else
                                                      @foreach($prop->sub_properties as $s_key => $s_prop)
                                                          <option value="{{$s_prop->id}}">
                                                            {{$s_prop->propertyName}}
                                                          </option>
                                                      @endforeach
                                                    @endif
                                                  @endif
                                                </optgroup>
                                              @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <!-- here ya merna -->
                                  </div>
                              </div>
                              <!-- HM -->

                          </div>
                          <div class="box-footer">
                              <input type="submit" class="btn btn-primary" value="@if(!empty($item)) @lang('leftsidebar.Edit') @else @lang('leftsidebar.Add') @endif">
                          </div>
                      </form>
                  </div>
              </div>
          </div>
    </section>
@else
  <h5>@lang('leftsidebar.There is no categories')</h5>    
@endif
</div>

<script type="text/javascript">
  
    function propType(valuee){
      if(valuee == 'clothes_size'){
        $("."+valuee).prop('disabled', false);
        $(".shoes_size").prop('disabled', true);
      }else if(valuee == 'shoes_size'){
        $("."+valuee).prop('disabled', false);
        $(".clothes_size").prop('disabled', true);
      }else{
        $(".clothes_size").prop('disabled', true);
        $(".shoes_size").prop('disabled', true);
      }
    }  




    function checkDicount(itemPrice){

        var discountType = $("#discountType");
            discountValue = $("#discountValue");
            itemPriceAfterDis = $("#itemPriceAfterDis");

        if(discountType.val() == "without") {
          return false;
        }else if(discountType.val() == "percent"){
          itemPriceAfterDis.val(itemPrice - ( itemPrice*discountValue.val()/100 ));
        }

    }


    function publishDiscountValue(discountValue){

      var discountType = $("#discountType").val();
          itemPrice = $("#itemPrice").val();
          itemPriceAfterDis = $("#itemPriceAfterDis");

          itemPriceAfterDis.val(itemPrice - (itemPrice*discountValue/100 ) );

    }


    function changeDiscountType(discountType){

        var itemPrice = $("#itemPrice");
            itemPriceAfterDis = $("#itemPriceAfterDis");
            discountValueAfterDiv = $("#discountValueAfterDiv");
            discountValueDiv = $("#discountValueDiv");
            discountValue = $("#discountValue");

            if(discountType == "percent"){
              
              discountValueDiv.show();
              discountValueAfterDiv.show();
              itemPriceAfterDis.val( itemPrice.val() -(itemPrice.val() - discountValue.val()/100) );
              
            }else if(discountType == "without"){
              itemPriceAfterDis.val(0);
              discountValue.val(0);
              discountValueDiv.hide();
              discountValueAfterDiv.hide();

            }
    }

    
    function itemPriceStatuss(statusVal){

        if(statusVal == "hasProperty"){
            $("#itemProperitiesParent").attr('style','display:block');
            $("#propCount").val(1);
        }else{
            $("#itemProperitiesParent").attr('style','display:none');
            $("#item_properities").html("");
            $("#propCount").val("");
        }
    }







    var counter = 0;
    @if(!empty($item))
        @if(count($item->item_properities))
            var counter = "{{count($item->item_properities)-1}}";
        @endif
    @endif



    function removeProperty(divId){
      $("#propCount").val($("#propCount").val()-1);
      $("#"+divId).remove();
    }


    //protertyPlus
    var counterPlus = 0;
    @if(!empty($item))
        @if(count($item->item_properities))
            var counterPlus = 30000;
        @endif
    @endif



    function appendPropertyPlusTwo(appendOn){
      counterPlus++;
      var appendOn = appendOn.split(" ")[2];
          countt = appendOn.split("propertyPlus")[1];

      $("#"+appendOn).append(

            '<div class="col-sm-12" id="rm'+counterPlus+'">'+


                '<div class="btn-group col-sm-12">'+
                  '<button type="button" class="btn btn-warning rm'+counterPlus+'" onclick="return removePropertyPlus(this.className);">'+
                    '<i class="fa fa-trash"></i>'+
                  '</button>'+
                '</div>'+

                '<label for="propertyValue" class="col-sm-2 control-label" style="color:black">'+
                 ' @lang("leftsidebar.propertyValue")'+
                '</label>'+
                '<div class="col-sm-2">'+
                    '<input type="text" name="propertyValue'+countt+'[]" class="form-control" placeholder="@lang("leftsidebar.propertyValue")" required  id="propertyValue">'+
                '</div>'+

                '<label for="propertyPrice" class="col-sm-2 control-label" style="color:black">'+
                 ' @lang("leftsidebar.propertyPrice")'+
                '</label>'+
                '<div class="col-sm-2">'+
                    '<input type="text" name="propertyPrice'+countt+'[]" class="form-control" placeholder="@lang("leftsidebar.propertyPrice")" required  id="propertyPrice" value="0">'+
                '</div>'+

            '</div>'

        );
    }


    function removePropertyPlus(classsName){
      $("#"+classsName.split(" ")[2]).remove();
    }


    function deleteImage(imageId,imgKey){
        if (confirm("are you sure") == false) {
            return false;
        }
        
        $.ajax({
              type : "get",
              url  : "{{url('ajaxDeleteItemImage')}}/"+imageId,
              success: function(result){
                  if(result == "true"){
                    $('#'+imgKey).remove();
                  }else{
                    alert("some thing worng");
                  }
              }
        });
    }


    function onlyThreeImages() {
        if ($("#otherItemImages")[0].files.length > 3) {
            alert("You can select only 3 images");
            $("#otherItemImages").parent().html($("#otherItemImages").parent().html())
        }
    }
</script>

