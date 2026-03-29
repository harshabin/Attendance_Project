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
                                   
                                      <div class="card-body">
                                        <div class="form-group row">
                                          <label for="name" class="col-sm-4 col-form-label">Baby or Parent's Name *</label>
                                          <div class="col-sm-8">
                                            <input type="text" class="form-control" name="name" placeholder="Baby or Parent's Name"  value="{{$data[0]->name}}">
                                          </div>
                                        </div>
                                        <div class="form-group row">
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


                                        <label for="">Available Vaccinations</label> 
                                        <div class="form-group row" style="gap: 1rem; flex-wrap: wrap;">
                                          
                                          @foreach($checkup_data as $dt)
                                          @if($dt->is_checked==1)
                                            
                                            <div class="custom-control custom-checkbox col-md-2">
                                              <input name="vaccination_id[]" checked class="custom-control-input" type="checkbox"  
                                              value="{{$dt->id}}">
                                              <input name="vaccination_name[]"  class="custom-control-input" type="hidden" 
                                              value="{{$dt->name}}">
                                              <label for="customCheckbox1" class="custom-control-label">{{$dt->name}}</label> <br> <small>{{$dt->days_from_child_birth}} Days</small>
                                            </div>
                                           

                                             @else
                                            
                                            <div class="custom-control custom-checkbox col-md-2">
                                              <input name="vaccination_id[]"  class="custom-control-input" type="checkbox" 
                                              value="{{$dt->id}}">
                                              <input name="vaccination_name[]"  class="custom-control-input" type="hidden" 
                                              value="{{$dt->name}}">
                                              <label for="customCheckbox1" class="custom-control-label">{{$dt->name}}</label> <br> <small>{{$dt->days_from_child_birth}} Days</small>
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
                                        <h4 class="success"></h4>
                                        <h4 class="error"></h4>


                                           <a href="{{route('registration.vaccination')}}" ><button type="submit" id="submit" class="btn btn-info">Back</button></a>
                                        
                                      </div>
                                     
                                    
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>
                
          

@endsection
@section('scripts')
<script>
 $('#form1 input').attr('readonly', 'readonly');
 


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
<script>
  var total_records=0;
 function get_list(){
  var from_date=$("#from").val()
   var to_date=$("#to").val()
$("#example").DataTable({
                  "processing": true,
        "serverSide": true,
        "bPaginate":true, // Pagination True
      "sPaginationType":"full_numbers", // And its type.
       "iDisplayLength": 10,
      "bDestroy": true,
        select: true,
       //Initial no order.
         "search": {
    "search": ''
  },
        "ajax": {
           
           url:"{{route('get_delivery_control_details')}}", 
   dataType:"JSON",
   type:"post",
   data:{from_date:from_date,to_date:to_date},
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
 
   
           
            "dataSrc": function (json1) {
          var return_data=new Array(); 
          var data=json1.data;
           total_records=json1.recordsTotal
          var k=1;
          for(var i=0;i<data.length;i++){
            var id=data[i].id

            
             
              
        return_data.push({
              
          'id':k++,
          'type':data[i].type,
    
         
          'amount':data[i].amount,
        
          'status':data[i].status,
         
          
            "action":`
<a href="${data[i].edit}" ><button class="btn btn-sm btn-info"><i class="fa fa-pencil text-white"></i></button></a>

`,

         
        
           "recordsTotal":11,
          
           "recordsFiltered":11,
          
        });
       }
    //$("#table11_filter").find("input").css({"width":"700px","margin-left":"-50%"});
       $("#example_filter").find("input").attr("placeholder","Type");
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
           
           { "data": "type" },
          
              { "data": "amount" },
              { "data": "status" },
                
             { "data": "action" }               
                                  
               
        ]
   
             });
}
      
get_list();

     function func(){
      if(confirm("Are you Sure?")){
        return true
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


  @stop