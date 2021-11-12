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
                          <h3 class="box-title">@if(!empty($item)) @lang('leftsidebar.Edit') @else @lang('leftsidebar.Add') @endif @lang('leftsidebar.Item')</h3>
                      </div>
                      <form role="form" class="form-horizontal" action="{{url('vendor/createItem')}}" method="post" enctype="multipart/form-data">
                          <div class="box-body">
                              @csrf
                              <input type="hidden" name="id" value="@if(!empty($item)) {{Crypt::encryptString($item->id)}} @endif">




                              <div class="form-group">
                                  <label for="facePage" class="control-label col-sm-2">@lang('leftsidebar.facePage')</label>
                                  <div class="col-sm-4">
                                    <input id="facePage" type="text" name="facePage" class="form-control" placeholder="@lang('leftsidebar.facePage')" value="@if(!empty($item)) {{$item->facePage}} @endif">
                                  </div>

                                  <label for="videoLink" class="control-label col-sm-2">@lang('leftsidebar.videoLink')</label>
                                  <div class="col-sm-4">
                                    <input id="videoLink" type="text" name="videoLink" class="form-control" placeholder="@lang('leftsidebar.videoLink')" value="@if(!empty($item)) {{$item->videoLink}} @endif">
                                  </div>
                              </div>







                              <div class="form-group">
                                  <label for="withProp" class="col-sm-2 control-label">
                                      @lang('leftsidebar.withProp')
                                  </label>
                                  <div class="col-sm-4">
                                      <input type="hidden" name="propCount" id="propCount" value="@if(!empty($item) && count($item->item_properities)) {{count($item->item_properities)}} @endif" >
                                      <select name="withProp" class="form-control" required onchange="return itemPriceStatuss(this.value);" id="withProp" required>
                                        @if(!empty($item))
                                              @if($item->withProp == 'dontHasProperty' or count($item->item_properities) == 0)
                                                  <option value="dontHasProperty" selected>@lang('leftsidebar.dontHasProperty')</option>
                                                  <option value="hasProperty">@lang('leftsidebar.hasProperty')</option>
                                              @elseif($item->withProp == 'hasProperty' or count($item->item_properities) > 0)
                                                  <option value="dontHasProperty">@lang('leftsidebar.dontHasProperty')</option>
                                                  <option value="hasProperty" selected>@lang('leftsidebar.hasProperty')</option>
                                              @endif
                                          @else
                                              <option value="dontHasProperty">@lang('leftsidebar.dontHasProperty')</option>
                                              <option value="hasProperty">@lang('leftsidebar.hasProperty')</option>
                                          @endif
                                      </select>
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

                                  <label for="itemDescribe" class="control-label col-sm-2">@lang('leftsidebar.itemDescribe')</label>
                                  <div class="col-sm-4">
                                    <textarea id="itemDescribe" type="text" name="itemDescribe" class="form-control" placeholder="@lang('leftsidebar.itemDescribe')">@if(!empty($item)){{$item->itemDescribe}}@endif</textarea>
                                  </div>

                                  <label for="itemDescribeAr" class="control-label col-sm-2">@lang('leftsidebar.itemDescribeAr')</label>
                                  <div class="col-sm-4">
                                    <textarea id="itemDescribeAr" type="text" name="itemDescribeAr" class="form-control" placeholder="@lang('leftsidebar.itemDescribeAr')">@if(!empty($item)){{$item->itemDescribeAr}}@endif</textarea>
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
                                        @if($item->discountType != 'without')
                                            <div id="discountValueAfterDiv">
                                        @else
                                            <div id="discountValueAfterDiv" style="display: none">
                                        @endif 
                                            <label for="itemPriceAfterDis" class="control-label col-sm-2" >@lang('leftsidebar.itemPriceAfterDis')</label>
                                            <div class="col-sm-4">
                                                <input id="itemPriceAfterDis" name="itemPriceAfterDis" type="number" step="any" class="form-control" value="{{$item->itemPriceAfterDis}}" readonly>
                                            </div>
                                        </div>
                                    @else
                                        <div id="discountValueAfterDiv" style="display: none">
                                            <label for="itemPriceAfterDis" class="control-label col-sm-2" >@lang('leftsidebar.itemPriceAfterDis')</label>
                                            <div class="col-sm-4">
                                                <input id="itemPriceAfterDis" name="itemPriceAfterDis" type="number" step="any" name="itemPriceAfterDis" class="form-control" placeholder="@lang('leftsidebar.itemPriceAfterDis')" readonly>
                                            </div>
                                        </div>
                                    @endif
                              </div>


                              <div class="form-group">
                                  <label for="discountType" class="control-label col-sm-2">@lang('leftsidebar.discountType')</label>
                                  <div class="col-sm-4">
                                    <select name="discountType" class="form-control" required onchange="return changeDiscountType(this.value)" required id="discountType">

                                          @if(!empty($item))
                                              @if($item->discountType == 'percent')
                                                  <option value="percent" selected>@lang('leftsidebar.percent')</option>
                                                  <option value="without">@lang('leftsidebar.without')</option>
                                              @elseif($item->discountType == 'without')
                                                  <option value="percent">@lang('leftsidebar.percent')</option>
                                                  <option value="without" selected>@lang('leftsidebar.without')</option>
                                              @endif
                                          @else
                                              <option value="without">@lang('leftsidebar.without')</option>
                                              <option value="percent">@lang('leftsidebar.percent')</option>
                                          @endif
                                    </select>
                                  </div>

                                  @if(!empty($item))
                                      @if($item->discountType != 'without')
                                          <div id="discountValueDiv">
                                      @else
                                          <div id="discountValueDiv" style="display: none">
                                      @endif 
                                          <label for="discountValue" class="control-label col-sm-2">@lang('leftsidebar.discountValue')</label>
                                          <div class="col-sm-4">
                                              <input id="discountValue" type="number" step="any" name="discountValue" class="form-control" value="{{$item->discountValue}}" onkeyup="publishDiscountValue(this.value)">
                                          </div>
                                      </div>
                                  @else
                                      <div id="discountValueDiv" style="display:none">
                                          <label for="discountValue" class="control-label col-sm-2">@lang('leftsidebar.discountValue')</label>
                                          <div class="col-sm-4">
                                               <input id="discountValue" value="0" type="number" step="any" name="discountValue" class="form-control" placeholder="@lang('leftsidebar.discountValue')" onkeyup="publishDiscountValue(this.value)">
                                          </div>
                                      </div>
                                  @endif
                              </div>

                              <div class="form-group">
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

                              <div class="box-body" id="itemProperitiesParent" style="display:@if(!empty($item) && count($item->item_properities)) block; @else none; @endif">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@lang('leftsidebar.itemProperities')</h3>
                                </div>
                                  <div class="form-group alert alert-default" id="item_properities">

                                    @if(!empty($item))
                                        @if(count($item->item_properities))
                                          @foreach($item->item_properities as $key=>$property)
                                              <div id="{{$key}}">

                                                    <div class="col-sm-12 alert alert-default" style="background-color:#605ca8;padding:15px 0px 15px 0px;">

                                                    <div class="btn-group col-sm-12">
                                                        <button type="button" class="btn btn-info" onclick="return appendProperty();">
                                                          <i class="fa fa-plus"></i>
                                                        </button>
                                                        @if($key != 0)
                                                          <button type="button" class="btn btn-danger" onclick="return removeProperty('{{$key}}');">
                                                            <i class="fa fa-trash"></i>
                                                          </button>
                                                        @endif
                                                    </div>

                                                    <label for="itemProperityName" class="col-sm-2 control-label" style="color:black">
                                                      @lang('leftsidebar.itemProperityName')
                                                    </label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="itemProperityName{{$key}}[]" class="form-control" placeholder="@lang('leftsidebar.itemProperityName')" value="{{$property->itemProperityName}}" required  id="itemProperityName{{$key}}">
                                                    </div>


                                                    <div class="btn-group col-sm-4">
                                                        <button type="button" class="btn btn-success propertyPlus{{$key}}" onclick="return appendPropertyPlusTwo(this.className);">
                                                          <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>

                                                    <div class="col-sm-12" id="propertyPlus{{$key}}" style="margin:15px 0px 15px 0px;">

                                                        @if(!empty(\App\Models\Item_property_plus::where('properity_id',$property->id)->get()))
                                                            @foreach(\App\Models\Item_property_plus::where('properity_id',$property->id)->get() as $keyP=>$propertyPlus)
                                                                <div class="col-sm-12" id="rm{{$propertyPlus->id}}">

                                                                    @if($keyP != 0)
                                                                      <div class="btn-group col-sm-12">
                                                                          <button type="button" class="btn btn-warning rm{{$propertyPlus->id}}" onclick="return removePropertyPlus(this.className);">
                                                                            <i class="fa fa-trash"></i>
                                                                          </button>
                                                                      </div>
                                                                    @endif  

                                                                      <label for="propertyValue" class="col-sm-2 control-label" style="color:black">
                                                                          @lang("leftsidebar.propertyValue")
                                                                      </label>

                                                                      <div class="col-sm-2">
                                                                          <input type="text" name="propertyValue{{$key}}[]" class="form-control" value="{{$propertyPlus->propertyValue}}" required  id="propertyValue">
                                                                      </div>

                                                                      <label for="propertyPrice" class="col-sm-2 control-label" style="color:black">
                                                                          @lang("leftsidebar.propertyPrice")
                                                                      </label>

                                                                      <div class="col-sm-2">
                                                                          <input type="number" name="propertyPrice{{$key}}[]" class="form-control" value="{{$propertyPlus->propertyPrice}}" required  id="propertyPrice">
                                                                      </div>

                                                                </div>
                                                            @endforeach   
                                                        @endif
                                                    </div>

                                                  </div>
                                              </div>
                                          @endforeach
                                        @endif
                                    @endif

                                  </div>
                              </div>

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


        if(discountType == "percent"){
          itemPriceAfterDis.val(itemPrice - (itemPrice*discountValue/100 ) );
        }else if(discountType == "without"){
          return false;
        }

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

            $("#item_properities").html(


                  '<div class="col-sm-12 alert alert-default" style="background-color:#605ca8;padding:15px 0px 15px 0px;">'+
                    
                     '<div class="btn-group col-sm-12">'+
                          '<button type="button" class="btn btn-info" onclick="return appendProperty();">'+
                            '<i class="fa fa-plus"></i>'+
                          '</button>'+
                      '</div>'+

                      '<label for="itemProperityName" class="col-sm-2 control-label" style="color:black">'+
                        '@lang('leftsidebar.itemProperityName')'+
                      '</label>'+
                      '<div class="col-sm-6">'+

                          '<select type="text" name="itemProperityName0[]" class="form-control" placeholder="@lang("leftsidebar.itemProperityNameDesc")" required id="itemProperityName">'+
                          '@foreach($properties as $prop)'+
                              '<option>{{$prop->propertyName}}</option>'+
                            '@endforeach'+
                          '</select>'+

                      '</div>'+
                      '<div class="btn-group col-sm-4">'+
                          '<button type="button" class="btn btn-success" onclick="return appendPropertyPlus();">'+
                            '<i class="fa fa-plus"></i>'+
                          '</button>'+
                      '</div>'+

                      //property plus
                      
                      '<div class="col-sm-12" id="propertyPlus" style="margin:15px 0px 15px 0px;">'+
                          '<div class="col-sm-12" id="rm">'+

                                '<label for="propertyValue" class="col-sm-2 control-label" style="color:black">'+
                                  ' @lang("leftsidebar.propertyValue")'+
                                '</label>'+
                                '<div class="col-sm-2">'+
                                    '<input type="text" name="propertyValue0[]" class="form-control" placeholder="@lang("leftsidebar.propertyValue")" required  id="propertyValue">'+
                                '</div>'+

                                '<label for="propertyPrice" class="col-sm-2 control-label" style="color:black">'+
                                  ' @lang("leftsidebar.propertyPrice")'+
                                '</label>'+
                                '<div class="col-sm-2">'+
                                    '<input type="text" name="propertyPrice0[]" class="form-control" placeholder="@lang("leftsidebar.propertyPrice")" value="0" required  id="propertyPrice">'+
                                '</div>'+

+
                          '</div>'+
                      '</div>'+
                      //property plus
                  '</div>'
            );


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





    function appendProperty(){
      counter++;
      
      $("#propCount").val(parseInt($("#propCount").val()) + 1);
      $("#item_properities").append(
                     
             '<div class="col-sm-12 alert alert-default" style="background-color:#605ca8;padding:15px 0px 15px 0px;"  id="'+counter+'">'+
                
                     '<div class="btn-group col-sm-12">'+
                          '<button type="button" class="btn btn-info" onclick="return appendProperty();">'+
                            '<i class="fa fa-plus"></i>'+
                          '</button>'+
                          '<button type="button" class="btn btn-danger" onclick="return removeProperty('+counter+');">'+
                            '<i class="fa fa-trash"></i>'+
                          '</button>'+
                      '</div>'+

                      '<label for="itemProperityName'+counter+'" class="col-sm-2 control-label" style="color:black">'+
                        '@lang('leftsidebar.itemProperityName')'+
                      '</label>'+
                      '<div class="col-sm-6">'+
                          '<input type="text" name="itemProperityName'+counter+'[]" class="form-control" placeholder="@lang("leftsidebar.itemProperityName")" required id="itemProperityName'+counter+'">'+
                      '</div>'+


                      '<div class="btn-group col-sm-4">'+
                          '<button type="button" class="btn btn-success propertyPlus'+counter+'" onclick="return appendPropertyPlusTwo(this.className);">'+
                            '<i class="fa fa-plus"></i>'+
                          '</button>'+
                      '</div>'+

                      //property plus
                      
                      '<div class="col-sm-12" id="propertyPlus'+counter+'" style="margin:15px 0px 15px 0px;">'+

                            '<label for="propertyValue" class="col-sm-2 control-label" style="color:black">'+
                               ' @lang("leftsidebar.propertyValue")'+
                              '</label>'+
                              '<div class="col-sm-2">'+
                                  '<input type="text" name="propertyValue'+counter+'[]" class="form-control" placeholder="@lang("leftsidebar.propertyValue")" required  id="propertyValue">'+
                              '</div>'+

                              '<label for="propertyPrice" class="col-sm-2 control-label" style="color:black">'+
                                  ' @lang("leftsidebar.propertyPrice")'+
                                '</label>'+
                                '<div class="col-sm-2">'+
                                    '<input type="text" name="propertyPrice'+counter+'[]" class="form-control" placeholder="@lang("leftsidebar.propertyPrice")" value="0" required  id="propertyPrice">'+
                                '</div>'+

                      '</div>'+
                      //property plus
            '</div>'
            );
    }




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

    function appendPropertyPlus(){
      counterPlus++;
      $("#propertyPlus").append(

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
                    '<input type="text" name="propertyValue0[]" class="form-control" placeholder="@lang("leftsidebar.propertyValue")" required  id="propertyValue">'+
                '</div>'+

                '<label for="propertyPrice" class="col-sm-2 control-label" style="color:black">'+
                 ' @lang("leftsidebar.propertyPrice")'+
                '</label>'+
                '<div class="col-sm-2">'+
                    '<input type="text" name="propertyPrice0[]" class="form-control" placeholder="@lang("leftsidebar.propertyPrice")" required  id="propertyPrice" value="0">'+
                '</div>'+

            '</div>'

        );
    }


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
    };


</script>
