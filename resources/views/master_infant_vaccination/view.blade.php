@extends('layouts.default')
@section('content')
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New Vaccination</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Add New Vaccination</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
               
 <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">


                <div class="card card-info">
                                    <div class="card-header">
                                      <h3 class="card-title">Add New Vaccination</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    
                                      <div class="card-body">
                                        <div class="form-group row">
                                          <label for="vacciantion" class="col-sm-4 col-form-label">Name of the Vaccination *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="vaccination" placeholder="Vacciantion Name" required value="{{$data[0]->name}}">
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="child-birth" class="col-sm-4 col-form-label">Days from Child Birth *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="child-birth" placeholder="Days from Child Birth"  value="{{$data[0]->days_from_child_birth}}">
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="send-alerts" class="col-sm-4 col-form-label">Send Alerts Before *</label>
                                          <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="send-alerts" placeholder="Send Alerts Before"  value="{{$data[0]->send_alerts_before}}">
                                                <div class="input-group-append">
                                                  <span class="input-group-text">Days</span>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                          <label for="remarks" class="col-sm-4 col-form-label">Remarks</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="remarks" placeholder="Remarks"  value="{{$data[0]->remarks}}"> 
                                             <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                                          </div>
                                        </div>
                                        
                                      </div>
                                      <!-- /.card-body -->
                                      <div class="card-footer">
                                           <a href="{{route('master_infant_vaccination.home')}}" ><button type="submit" id="submit" class="btn btn-info">Back</button></a>
                                        
                                      </div>
                                      <!-- /.card-footer -->
                                    
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>
                
          

@endsection
@section('scripts')
<script>
 $('#form input').attr('readonly', 'readonly');
 


</script>
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