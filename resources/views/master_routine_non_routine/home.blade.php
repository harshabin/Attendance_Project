@extends('layouts.default')
@section('content')
   
               <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Routine Check-up</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">Master</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Routine Checkup </h3>
                      <div class="add-btn">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-vaccination-registration">
                            Add
                        </button>
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                     <!--    <table border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                <td>Date From:</td>
                                <td><input type="date" id="min" name="min"></td>
                                <td>Date To:</td>
                                <td><input type="date" id="max" name="max"></td>
                                </tr>
                            </tbody>
                        </table> -->
                      <table id="table3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Si No</th>
                         
                         <!--  <th>Date of Birth</th> -->
                         
                           
                          <th>Date Created</th>
                           <th>Name</th>
                            <!-- <th>Days From Child Birth</th>
                            <th>Send Alerts before</th> -->
                           
                          <th>Created By</th>
                           <th>Status</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        
                        </tbody>
                        
                      </table>
                    </div>
                    <!-- /.card-body -->
                </div>



                <div class="modal fade" id="modal-vaccination-registration">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="modal-body">
                                <div class="card card-info">
                                    <div class="card-header">
                                      <h3 class="card-title">Routine Checkup </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form class="form-horizontal" id="form1">
                                    <div class="card-body">
                                        <div class="form-group row">
                                        <label for="checkup" class="col-sm-3 col-form-label">Checkup Name *</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="checkup" placeholder="Checkup Name" >
                                             <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
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
                                            <input type="text" class="form-control" name="notification" placeholder="Notification Cycle" value="90" required>
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
                                                <input type="text" class="form-control" name="send-alerts1" placeholder="Send 1st Alert Before" required>
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
                                                <input type="text" class="form-control" name="send-alerts2" placeholder="Send 2nd Alerts Before" >
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
                                                <input type="text" class="form-control" name="send-alerts3" placeholder="Send 3rd Alert Before" >
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
                                          <tr>
                                            <td>1</td>
                                            <td><input type="text" value="0" size="3" name="days[]"> Days</td>
                                            <td>Send alerts before</td>
                                            <td><input type="text" name="alerts1[]" id="" size="3"></td>
                                            <td><input type="text" name="alerts2[]" id="" size="3"></td>
                                            <td><input type="text" name="alerts3[]" id="" size="3"></td>
                                            <td><button class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></button> </td>
                                          </tr>

                                          <!-- <tr>
                                            <td>2nd Checkup</td>
                                            <td><input type="text" value="15"> Days</td>
                                            <td>Send alerts before</td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button> </td>
                                          </tr>

                                          <tr>
                                            <td>3rd Checkup</td>
                                            <td><input type="text" value="30"> Days</td>
                                            <td>Send alerts before</td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button> </td>
                                          </tr>

                                          <tr>
                                            <td>4th Checkup</td>
                                            <td><input type="text" value="30"> Days</td>
                                            <td>Send alerts before</td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button> </td>
                                          </tr>

                                          <tr>
                                            <td>5th Checkup</td>
                                            <td><input type="text" value="30"> Days</td>
                                            <td>Send alerts before</td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><input type="text" name="" id=""></td>
                                            <td><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button> </td>
                                          </tr> -->
                                         
                                          </tbody>
                                          
                                        </table>
                                      </div>
                                      </div>
                                        
                                        <div class="form-group row">
                                        <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="remarks" placeholder="Remarks">
                                        </div>
                                        </div>
                                        
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit" class="btn btn-info">SUBMIT</button>
                                        
                                    </div>
                                    <!-- /.card-footer -->
                                    </form>
                                </div>
                            </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->

                
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
                
          

@endsection
@section('scripts')
<script>
  <?php
if(isset($_GET['param']) && $_GET['param']==1){ ?>

error("cannot delete Checkup,it is associated with registration","#submit");

  <?php

}else{
  ?>

  <?php
}
  ?>
$("#submit").click(function(e){
    e.preventDefault()
 $(this).attr("disabled",true)
    var formData = new FormData(document.querySelector('#form1'))
    $.ajax({
      url:"add",
      data:formData,
      dataType:"json",
      type:"POST",
       processData: false,
        contentType: false,
      success:function(data){
        if(data.status_code=="200"){
            success(data.data,"#submit");
 data_table();
            $("#form1").trigger("reset")
            $("#modal-vaccination-registration").modal("hide")


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
var i=2;
$("#add").click(function(){
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
</script>

<script>
      function data_table(){
    $('#table3').DataTable().clear().destroy();
$("#table3").DataTable({
                  "processing": true,
        "serverSide": true,
        "bPaginate":true, // Pagination True
      "sPaginationType":"full_numbers", // And its type.
       "iDisplayLength": 10,
      
        select: true,
       //Initial no order.
         "search": {
    "search": ''
  },
        "ajax": {
           
           url:"get_master", 
   dataType:"JSON",
   type:"get",
 
   
           
            "dataSrc": function (json1) {
          var return_data=new Array(); 
          var data=json1.data;
          var k=1;
          for(var i=0;i<data.length;i++){
            var id=data[i].id;
           
            var status="Activate";
            if(data[i].status=="active"){
              status="Disable"
            }
           
             
              
        return_data.push({
              
          'id':k++,
          
          
        
         // "dob":data[i].dob,
          
           
           
          "created_on":data[i].created_on,
           "name":data[i].name,
            // "days_from_child_birth":data[i].days_from_child_birth,
            // "send_alerts_before":data[i].send_alerts_before,
            "status":data[i].status,
           "created_by":data[i].created_by,
          
           
        "action":"<a href='../master_routine_non_routine/view/"+id+"'><button class='view btn btn-success' value='"+id+"'>View</button></a>&nbsp;"
        +"<a href='../master_routine_non_routine/edit/"+id+"'><button class='view btn btn-primary' value='"+id+"'>Edit</button></a>&nbsp;"
         +"<a href='../master_routine_non_routine/disable/"+id+"/"+data[i].status+"' onclick='return func()'><button class='view btn btn-info' value='"+id+"'>"+status+"</button></a>&nbsp;"
        +"<a href='../master_routine_non_routine/delete/"+id+"' onclick='return func()'><button class='view btn btn-danger' value='"+id+"'>Delete</button></a>&nbsp;",
       
        
 
        
        
         

         
        
           "recordsTotal":11,
          
           "recordsFiltered":11,
          
        });
       }
    //$("#table11_filter").find("input").css({"width":"700px","margin-left":"-50%"});
       $("#table3_filter").find("input").attr("placeholder","Search  Vaccination ");
      return return_data;
       },
       error:function(xhr){
       // alert(xhr.responseText);

       }
    
        } ,
        // "createdRow": function ( row, data, index ) {
         
        //         $('td',row).find(".credit").parent().parent().addClass('highlight');
            
        // },
         "columnDefs": [
        { 
            //"targets": [ 0,2,3,5], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
        "columns": [
           { "data": "id" },
          
            
             
                                     { "data": "created_on" },
                                     { "data": "name" },
                                      // { "data": "days_from_child_birth" },
                                      //  { "data": "send_alerts_before" },
                               {"data":"created_by"},
                                { "data": "status" },
                               {"data":"action"},
                               
                                  
               
        ]
   
             });
         }
         data_table()     
function func(){
  if(confirm("Are you Sure?")){
    return true;
  }
  return false;
}
</script>


<style type="text/css">
  form .required:after {
  content: " *";
    color: red;
    font-weight: 100;
}
</style>
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
          
         $('.modal1').modal('hide');

        }else{
          $(".error").html(data.data);
          $('.alert').alert()
          $('.alert').show()


        }

      }



    })

  })  
</script>
<script>
    function show1(){
      document.getElementById('regular-form').style.display = 'block';
      document.getElementById('manual-form').style.display = 'none';
    }

    function showManual(){
      document.getElementById('manual-form').style.display = 'block';
      document.getElementById('regular-form').style.display = 'none';
    }
    show1();
  </script>
<style type="text/css">
  form .required:after {
  content: " *";
    color: red;
    font-weight: 100;
}
</style>

<div class="modal fade modal1" id="modal-vaccination-registration">
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