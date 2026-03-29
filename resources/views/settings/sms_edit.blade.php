@extends('layouts.default')
@section('content')
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">View SMS</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">View SMS</li>
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
                                      <h3 class="card-title">View SMS</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form class="form-horizontal" id="form1">
                                      <div class="card-body">
                                        <div class="form-group row">
                                          <label for="name" class="col-sm-4 col-form-label">Vaccination Text *</label>
                                          <div class="col-sm-8">
                                           <textarea class="form-control" name="text" placeholder="Address" required> {{$data[0]->text}}</textarea> 
                                          </div>
                                        </div>
                                         <div class="form-group row">
                                          <label for="name" class="col-sm-4 col-form-label">Checkup Text *</label>
                                          <div class="col-sm-8">
                                           <textarea class="form-control" name="checkup_text" placeholder="Address" required> {{$data[0]->checkup_text}}</textarea> 
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="birth" class="col-sm-4 col-form-label">URL *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="url" placeholder="URL" required value="{{$data[0]->url}}">
                                          </div>
                                        </div>
                                        
                                        
                                         <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                          <input type="hidden" class="form-control" name="ids" placeholder="Mobile Number"  value="{{$data[0]->id}}">


                                        


                                        <!-- <button type="submit" id="submit" class="btn btn-info">Update</button> -->
                                        
                                      </div>
                                     
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
      url:"{{route('settings.sms_update')}}",
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