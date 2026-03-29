@extends('layouts.default')
@section('content')
   
                
                
          <div class="">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @php 
$role=$_SESSION['roles'];

   @endphp
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          @if($role=="admin")
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <p>Student Registration</p>
              </div>
              <div class="icon">
                <i class="fas fa-syringe"></i>
              </div>
              <a href="{{ route('registration') }}" class="small-box-footer">Go To <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @else

          <h4>Welcome ,<?php echo $_SESSION['first_name'];?></h4>
        
      
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <p>Scanner</p>
              </div>
              <div class="icon">
                <i class="fas fa-stethoscope"></i>
              </div>
              <a href="{{ route('scanner') }}" class="small-box-footer">Go To <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <a href="{{ route('logout') }}" class="nav-link">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                Logout
              </p>
            </a>
          @endif
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
@section('scripts')
<!-- <script>
$("body").on("submit", "#form1", function(e){
     $(".success").html("")
     $(".error").html("")
            e.preventDefault();
            $("#submit").attr("disabled",true)
    $.ajax({
    type: "POST",
    url: "/add_wheat",// where you wanna post
    data: new FormData(this),
    processData: false,
    contentType: false,
    dataType:"json",
    error: function(jqXHR, textStatus, errorMessage) {
        $(".error").html(errorMessage); 
        $("#submit").removeAttr("disabled")// Optional
    },
    success: function(data) {
         $(".success").html(data.data);
         $(".error").html(data.error);
          $("#submit").removeAttr("disabled")
        
        
    } 
});
 });    
</script> -->

<style type="text/css">
  form .required:after {
  content: " *";
    color: red;
    font-weight: 100;
}
</style>


  @stop