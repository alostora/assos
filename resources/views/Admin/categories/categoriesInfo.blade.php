
<!---header -->
@include('Admin/layouts/header')
<!--end header-->

<!--mainHeader-->
@include('Admin/layouts/mainheader')
<!--mainheader--> 
  <!-- Left side column. contains the logo and sidebar -->
  @include('Admin/layouts/leftsidebar')

 <!-- admins table-->
    @include('Admin/layouts/categories/categoriesInfo') 
 <!--end admins table-->

<!--footer-->
@include('Admin/layouts/footer')
<!--end footer -->
