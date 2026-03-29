@extends('layouts.default')
@section('content')
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Update Vaccination</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Update Vaccination</li>
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
                                      <h3 class="card-title">Update Vaccination</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form class="form-horizontal" id="form1">
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
                                              <input type="hidden" name="ids"  value="{{ $data[0]->id }}">

                                          </div>
                                        </div>
                                        
                                      </div>
                                      <!-- /.card-body -->
                                      <div class="card-footer">
                                        <button type="submit" id="submit" class="btn btn-info">Update</button>
                                        <a href="{{route('master_infant_vaccination.home')}}"  class="btn btn-info">Back</a>
                                        
                                      </div>
                                      <!-- /.card-footer -->
                                    </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>
                
          

@endsection
@section('scripts')
<script>
$("#submit").click(function(e){
    e.preventDefault()
    $(this).attr("disabled",true)

    var formData = new FormData(document.querySelector('#form1'))
    $.ajax({
      url:"{{route('master_infant_vaccination.update')}}",
      data:formData,
      dataType:"json",
      type:"POST",
       processData: false,
        contentType: false,
      success:function(data){
        if(data.status_code=="200"){
         success(data.data,"#submit");



        }
else if(data.status_code=="404"){
$('.modal').modal('show');
 $("#submit").removeAttr("disabled")

}
        else{
         
 error(data.data,"#submit");

        }

      },error:function(data){
         $("#submit").removeAttr("disabled")

      }



    })

  })
 


</script>
<script>
$("body").on("click","#login",function(e){
    e.preventDefault()

    var formData = new FormData(document.querySelector("#form"))
    $.ajax({
      url:"{{route('check_login')}}",
      data:formData,
      dataType:"json",
      type:"POST",
       processData: false,
        contentType: false,
      success:function(data){
        if(data.status_code=="200"){
          
         $('.modal').modal('hide');

        }else{
          $(".error").html(data.data);
          $('.alert').alert()
          $('.alert').show()


        }

      }



    })

  })  
</script>

<style type="text/css">
  form .required:after {
  content: " *";
    color: red;
    font-weight: 100;
}
</style>

<div class="modal fade" id="modal-vaccination-registration">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="modal-body" style="margin: 0 auto;">
                          <div class="login-box">
  <div class="login-logo" style="margin-bottom: 0;">
    <img src="{{ asset('dist/img/av-logo.jpg')}}" width="100%" alt="">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <p style="text-align: center;"><img src="{{ asset('dist/img/av-thumb.png')}}" style="border-radius: 50%; width: 70px;" alt=""></p>
      <p class="login-box-msg">Log in to start your session</p>

      <form action="" method="post" id="form">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="User ID" required name='user_name'> 
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-users"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" required name='pwd'>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-md-12">
             <div class="error alert alert-danger alert-dismissible fade show"  role="alert"  style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
             </div>
          </div>
        </div>
        <div class="row">
          
           <!-- /.col -->
           <div class="col-4"></div>
           <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

          <!-- /.col -->
          <div class="col-4">
            
            <button type="submit" class="btn btn-primary btn-block" id="login">Log In</button>
          </div>
          <!-- /.col -->
          <div class="col-4"></div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
                            </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
  @stop