@extends('layouts.default')
@section('content')
   
                <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                      <h3 class="card-title">Users</h3>
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
                          <th>Name</th>
                           <th>User Name</th>
                          <th>Password</th>
                          <th>Mobile</th>
                           <th>Address</th>
                           <th>Status</th>
                         
                          <th>Created By</th>
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
                                      <h3 class="card-title">Users</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form class="form-horizontal" id="form1">
                                      <div class="card-body">
                                        <div class="form-group row">
                                          <label for="name" class="col-sm-4 col-form-label">Name *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="birth" class="col-sm-4 col-form-label">User Name *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="user_name" placeholder="User name" required>
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="mobile" class="col-sm-4 col-form-label">Password *</label>
                                          <div class="col-sm-8">
                                            <input type="password" class="form-control" name="pwd" placeholder="Password" required>
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="email" class="col-sm-4 col-form-label">Mobile Number *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number" >
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label for="address" class="col-sm-4 col-form-label">Address *</label>
                                          <div class="col-sm-8">
                                            <textarea class="form-control" name="address" placeholder="Address" required></textarea> 
                                          </div>
                                        </div>
                                        
                                         <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">


                                        


                                        <button type="submit" id="submit" class="btn btn-info">SUBMIT</button>
                                        
                                      </div>
                                     
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
           
           url:"get_users", 
   dataType:"JSON",
   type:"get",
 
   
           
            "dataSrc": function (json1) {
          var return_data=new Array(); 
          var data=json1.data;
          var k=1;
          for(var i=0;i<data.length;i++){
            var id=data[i].id;
           
            
             
              
        return_data.push({
              
          'id':k++,
          
          
         "name":data[i].name,
          "user_name":data[i].user_name,
           "pwd":data[i].pwd,
           "mobile_number":data[i].mobile_number,
           "address":data[i].address,
            "status":data[i].status,
          "created_on":data[i].created_on,
           
          
           
        "action":"<a href='../users/edit/"+id+"'><button class='view btn btn-primary' value='"+id+"'>Edit</button></a>&nbsp;"
         +"<a href='../users/disable/"+id+"/"+data[i].status+"' onclick='return func()'><button class='view btn btn-info' value='"+id+"'>Disable</button></a>&nbsp;"
        +"<a href='../users/delete/"+id+"' onclick='return func()'><button class='view btn btn-danger' value='"+id+"'>Delete</button></a>&nbsp;",
       
        
 
        
        
         

         
        
           "recordsTotal":11,
          
           "recordsFiltered":11,
          
        });
       }
    //$("#table11_filter").find("input").css({"width":"700px","margin-left":"-50%"});
       $("#table3_filter").find("input").attr("placeholder","Search  User name ");
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
          
            { "data": "name" },
             { "data": "user_name" },
              { "data": "pwd" },
             { "data": "mobile_number" },
              { "data": "address" },
              { "data": "status" },
                                     { "data": "created_on" },
                                     
                             
                               {"data":"action"},
                               
                                  
               
        ]
   
             });
              
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