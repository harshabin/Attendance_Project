@extends('layouts.default')
@section('content')
   
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">Scanner</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                    <div class="row">
  <div class="col">
    <div id="reader"></div>
  </div>
  <div class="col" style="padding: 30px">
    <h4>Scan Result </h4>
    <div id="result">
      Result goes here
    </div>
  </div>

</div>
<script src="https://cdn.tutorialjinni.com/html5-qrcode/2.1.1/html5-qrcode.min.js" type="text/javascript"></script>
<script src="//unpkg.com/javascript-barcode-reader"></script>

<style>
    h1 {
  text-align: center;
}

#reader {
  width: 500px;
}

.result {
  background-color: green;
  color: #fff;
  padding: 20px;
}

.row {
  display: flex;
}

#reader__scan_region {
  background: white;
}

</style>
<script>
  function onScanSuccess(decodedText, decodedResult) {
  // Handle the scanned code as you like, for example:
  console.log(`Code matched = ${decodedText}`, decodedResult);
  $("#result").html(decodedText)
  if(decodedText=="{{$_SESSION['number']}}"){
    $.ajax({
      url:"{{route('update_attanedance')}}",
      data:{},
      dataType:"json",
      type:"POST",
       
      success:function(data){
        if(data.status_code=="200"){
          alert("Done")
          
        window.location.relod();

        }else{
          alert("Attendance was not updated")

        }

      }



    })
  }

  




}

const formatsToSupport = [ "QR_CODE", "AZTEC",
    "CODABAR", "CODE_39", "CODE_93",
    "CODE_128", "DATA_MATRIX",  "MAXICODE",
    "ITF", "EAN_13", "EAN_8",
    "PDF_417", "RSS_14", "RSS_EXPANDED"
    , "UPC_A", "UPC_E", "UPC_EAN_EXTENSION"];
const html5QrcodeScanner = new Html5QrcodeScanner(
  "reader",
  {
   // fps: 10,
   fps: 10,
       // qrbox: {width: 250, height: 250},
        useBarCodeDetectorIfSupported: true,
        rememberLastUsedCamera: true,
        aspectRatio: 4/3,
        showTorchButtonIfSupported: true,
    qrbox: { width: 350, height: 350 },
  
  },
  /* verbose= */ false);
html5QrcodeScanner.render(onScanSuccess,onScanError);
function onScanError(errorMessage) {
  console.log(errorMessage)
}
//   var Html5QrcodeSupportedFormats= {
//   QR_CODE = 0,
//   AZTEC,
//   CODABAR,
//   CODE_39,
//   CODE_93,
//   CODE_128,
//   DATA_MATRIX,
//   MAXICODE,
//   ITF,
//   EAN_13,
//   EAN_8,
//   PDF_417,
//   RSS_14,
//   RSS_EXPANDED,
//   UPC_A,
//   UPC_E,
//   UPC_EAN_EXTENSION,
// }
// const html5QrCode = new Html5Qrcode(
//   "reader", { formatsToSupport: [ QR_CODE, AZTEC,
//     CODABAR, CODE_39, CODE_93,
//     CODE_128, DATA_MATRIX,  MAXICODE,
//     ITF, EAN_13, EAN_8,
//     PDF_417, RSS_14, RSS_EXPANDED
//     , UPC_A, UPC_E, UPC_EAN_EXTENSION] });
// const qrCodeSuccessCallback = (decodedText, decodedResult) => {
//     /* handle success */
// };
// const config = { fps: 10, qrbox: { width: 250, height: 250 } };

// // If you want to prefer front camera
// html5QrCode.start({ facingMode: "user" }, config, qrCodeSuccessCallback);


    // When scan is successful fucntion will produce data
// function onScanSuccess(qrCodeMessage) {
//   document.getElementById("result").innerHTML =
//     '<span class="result">' + qrCodeMessage + "</span>";
// }

// // When scan is unsuccessful fucntion will produce error message
// function onScanError(errorMessage) {
//   // Handle Scan Error
// }

// // Setting up Qr Scanner properties
// var html5QrCodeScanner = new Html5QrcodeScanner("reader", {
//   fps: 10,
//   qrbox: 250
// });

// // in
// html5QrCodeScanner.render(onScanSuccess, onScanError);

</script>
                      
                    </div>
                    <!-- /.card-body -->
                </div>
<?php
  date_default_timezone_set("Asia/Kolkata");
  $date=date("Y-m-d");

?>


                
        </div>
      </div><!-- /.container-fluid -->
    </section>
                
          

@endsection
@section('scripts')
<script>


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