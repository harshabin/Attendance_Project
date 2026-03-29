@extends('layouts.default')
@section('content')
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">View Registration</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">View Registration</li>
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
                                      <h3 class="card-title">View Registration</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form class="form-horizontal" id="form1">
                                      <div class="card-body">
                                        <div class="form-group row">
                                          <label for="name" class="col-sm-4 col-form-label">Patient Name *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="name" placeholder="Baby or Parent's Name"  value="{{$data[0]->name}}">
                                          </div>
                                        </div>
                                        <div class="form-group row" style="display: none">
                                          <label for="birth" class="col-sm-4 col-form-label">Date of Birth *</label>
                                          <div class="col-sm-8">
                                            <input type="date" class="form-control" name="dob" placeholder="Date of Birth"  value="{{$data[0]->dob}}">
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="mobile" class="col-sm-4 col-form-label">Mobile Number *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number"  value="{{$data[0]->mobile_number}}">
                                          </div>
                                        </div>
                                           <div class="form-group row">
                                          <label for="mobile" class="col-sm-4 col-form-label">Alternative Mobile Number</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="alt_mobile_number" placeholder="Alternative Mobile Number" 
                                            value="{{$data[0]->alt_mobile_number}}">
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="email" class="col-sm-4 col-form-label">Email Address</label>
                                          <div class="col-sm-8">
                                            <input type="email" class="form-control" name="email_id" placeholder="Email ID"  value="{{$data[0]->email_id}}">
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="address" class="col-sm-4 col-form-label">Address *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="address" placeholder="Address"  value="{{$data[0]->address}}">
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="pin" class="col-sm-4 col-form-label">Pin Code</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="pin_code" placeholder="Pin Code"  value="{{$data[0]->pin_code}}">
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="remarks" class="col-sm-4 col-form-label">Remarks</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="remarks" placeholder="Remarks"  value="{{$data[0]->remarks}}">
                                          </div>
                                        </div>
                                         <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                          <input type="hidden" name="ids"  value="{{$data[0]->id}}">


                                        <label for="">Available Vaccinations</label> 
                                        <div class="form-group" style="display: flex;gap: 1rem; flex-wrap: wrap;">
                                          
                                          @foreach($checkup_data as $dt)
                                          @if($dt->is_checked==1)
                                            
                                            <div class="custom-control custom-checkbox">
                                              <input name="vaccination_id[]" checked class="custom-control-input" type="checkbox"  id="customCheckbox{{$dt->id}}" 
                                              value="{{$dt->id}}">
                                              <input name="vaccination_name[]"  class="custom-control-input" type="hidden" 
                                              value="{{$dt->name}}">
                                              <label for="customCheckbox{{$dt->id}}" class="custom-control-label">{{$dt->name}}</label> <br> <small>{{$dt->days_from_child_birth}} Days</small>
                                            </div>
                                           

                                             @else
                                            
                                            <div class="custom-control custom-checkbox">
                                              <input name="vaccination_id[]"  class="custom-control-input" type="checkbox"  id="customCheckbox{{$dt->id}}" 
                                              value="{{$dt->id}}">
                                              <input name="vaccination_name[]"  class="custom-control-input" type="hidden" 
                                              value="{{$dt->name}}">
                                              <label for="customCheckbox{{$dt->id}}" class="custom-control-label">{{$dt->name}}</label> <br> <small>{{$dt->days_from_child_birth}} Days</small>
                                            </div>
                                            @endif
                                          
                                             @endforeach
                                            <!-- <div class="custom-control custom-checkbox">
                                              <input class="custom-control-input" type="checkbox" id="customCheckbox2" value="option2">
                                              <label for="customCheckbox2" class="custom-control-label">Polio</label><br> <small>200 Days</small>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                              <input class="custom-control-input" type="checkbox" id="customCheckbox3" value="option3">
                                              <label for="customCheckbox3" class="custom-control-label">Chicken-Pox</label><br> <small>70 Days</small>
                                            </div> -->
                                        </div>
                                       <!-- <div class="success alert alert-info alert-dismissible fade"  role="alert" >
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
             </div> -->
                                        


                                        <button type="submit" id="submit" class="btn btn-info">Update</button>
                                         <a href="{{route('registration_checkup.vaccination')}}"  class="btn btn-info">Back</a>
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
      url:"{{route('registration_checkup.update')}}",
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