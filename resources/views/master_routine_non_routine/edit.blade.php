@extends('layouts.default')
@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">View Checkup</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">View Checkup</li>
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
                                      <h3 class="card-title">View Checkup</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form class="form-horizontal" id="form1">
                                    <div class="card-body">
                                        <div class="form-group row">
                                        <label for="checkup" class="col-sm-3 col-form-label">Checkup Name *</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="checkup" placeholder="Checkup Name"  value="{{$data[0]->name}}">
                                             <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                              <input type="hidden" class="form-control" name="ids" placeholder="Checkup Name"  value="{{$data[0]->id}}">
                                        </div>
                                        </div>

                                        <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="routine" onclick="show1();" checked="">
                                          <label class="form-check-label" for="inlineRadio1">Regular</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="non_routine" onclick="showManual();">
                                          <label class="form-check-label" for="inlineRadio2">Manual</label>
                                        </div>
                                      </div>
                                    </div> <br>
                                        
                                    <div id="regular-form" class="hide">
                                        <div class="form-group row">
                                        <label for="notification" class="col-sm-3 col-form-label">Notification Cycle *</label>
                                        <div class="col-sm-9">
                                           <div class="input-group mb-3">
                                            <input  value="{{$data[0]->notification_cycle}}" type="text" class="form-control" name="notification" placeholder="Notification Cycle" value="90" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Days</span>
                                                </div>
                                          </div>
                                        </div>
                                        </div>
                                        <div class="form-group row">
                                        <label for="send-alerts" class="col-sm-3 col-form-label">Send 1st alert before *</label>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3"> 
                                                <input   value="{{$data[0]->first_alert}}" type="text" class="form-control" name="send-alerts1" placeholder="Send 1st Alert Before" required>
                                                <div class="input-group-append">
                                                <span class="input-group-text">Days</span>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="form-group row">
                                        <label for="send-alerts" class="col-sm-3 col-form-label">Send 2nd alert before</label>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input   value="{{$data[0]->second_alert}}" type="text" class="form-control" name="send-alerts2" placeholder="Send 2nd Alerts Before" >
                                                <div class="input-group-append">
                                                <span class="input-group-text">Days</span>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="form-group row">
                                        <label for="send-alerts" class="col-sm-3 col-form-label">Send 3rd alert before</label>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text"  value="{{$data[0]->third_alert}}" class="form-control" name="send-alerts3" placeholder="Send 3rd Alert Before" >
                                                <div class="input-group-append">
                                                <span class="input-group-text">Days</span>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                      </div>

                                      <div id="manual-form" class="hide">

                                        <button class="btn btn-success" id="add" onsubmit="return false" style="float: right;">Add</button>
                                        <div class="table-responsive">
                                        <table class="table manual-form-table" id="schedule">
                                         <thead>
                                          <tr>
                                            <th colspan="3"></th>
                                            <th>1st</th>
                                            <th>2nd</th>
                                            <th>3rd</th>
                                          </tr>
                                         </thead>
                                          <tbody>
                                            <?php $i=1;?>
                                            @foreach($checkup_data as $cd)
                                          <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><input type="text"  size="3" name="days[]" value="{{$cd->check_up_days}}"> Days</td>
                                            <td>Send alerts before</td>
                                            <td><input type="text" name="alerts1[]" id="" size="3"  value="{{$cd->first_alert}}"></td>
                                            <td><input type="text" name="alerts2[]" id="" size="3"  value="{{$cd->second_alert}}"></td>
                                            <td><input type="text" name="alerts3[]" id="" size="3" value="{{$cd->third_alert}}"></td>
                                            <td><button class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></button> </td>
                                          </tr>
                                          @endforeach

                                          
                                         
                                          </tbody>
                                          
                                        </table>
                                      </div>
                                      </div>
                                        
                                        <div class="form-group row">
                                        <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="remarks" placeholder="Remarks"  value="{{$data[0]->remarks}}">
                                        </div>
                                        </div>
                                        
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit" class="btn btn-info">Update</button>
                                         <a href="{{route('master_routine_non_routine.home')}}"  class="btn btn-info">Back</a>
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
      url:"{{route('master_routine_non_routine.update')}}",
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
<script>
  
   function show1(){
      document.getElementById('regular-form').style.display = 'block';
      document.getElementById('manual-form').style.display = 'none';
    }

    function showManual(){
      document.getElementById('manual-form').style.display = 'block';
      document.getElementById('regular-form').style.display = 'none';
    }
    
    var i="{{count($checkup_data)+1}}";
    
$("#add").click(function(e){

  e.preventDefault();
var data=`<tr>                                            <td class='sl_no'>${i++}</td>
                                            <td><input type="text" value="0" size="3" name="days[]"> Days</td>
                                            <td>Send alerts before</td>
                                            <td><input type="text" name="alerts1[]" id="" size="3"></td>
                                            <td><input type="text" name="alerts2[]" id="" size="3"></td>
                                            <td><input type="text" name="alerts3[]" id="" size="3"></td>
                                            <td><button class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></button> </td>
                                          </tr>`


  $("#schedule tbody").append(data)
})

$("body").on("click",".delete",function(){
$(this).parent().parent().remove();
i=i-1;

$("#schedule tbody tr").each(function(e){
$(this).find(".sl_no").html(e+1)
})
});

var type="{{$data[0]->type}}";

if(type=="routine"){
show1();
$("#inlineRadio1").attr("checked",true)
$("#inlineRadio2").attr("checked",false)
}else{
  showManual();
  $("#inlineRadio1").attr("checked",false)
  $("#inlineRadio2").attr("checked",true)
}
</script>
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