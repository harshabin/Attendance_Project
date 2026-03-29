 
 <footer class="main-footer">
    <strong>Copyright &copy; 2022</strong> | All rights reserved.
  </footer>




          
       <script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- daterangepicker -->
<!-- <script src="{{ asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js')}}"></script> -->

<!-- overlayScrollbars -->
<!-- <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script> -->
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('dist/js/pages/dashboard.js')}}"></script> -->
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- <script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script> -->
<!-- <script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<!-- <script src="{{ asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js')}}"></script> -->
<!-- <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script> -->
<script src="{{asset('js/bootstrap-msg.js')}}"></script>
<!-- <script><script src="dist/js/bootstrap-msg.min.js"></script>

    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
 -->
<script>
  

  var searchParams =(window.location.href)
var search_p=(searchParams.split("/"))[3];
//var search_p=(searchParams.split("/"))[3]+"/"+(searchParams.split("/"))[4]+"/"+(searchParams.split("/"))[5]
console.log(search_p)
$(".nav-item").each(function(){
   $(this).find("a").each(function(){
     $(this).removeClass("active")
    });
});
$(".nav-item").each(function(){
  $(this).find("a").each(function(){
    var href=$(this).attr("href")
    console.log(href+"-"+search_p)
  
  if(href.indexOf(search_p)!=-1){
    $(this).addClass("active")
    $(this).parent().parent().parent().addClass("menu-open")
    console.log("jggg="+$(this).parent().parent().parent().attr("class"))
  }
  })
})

function success(data,ids){
 Msg.success(data, 5000);
 $(ids).removeAttr('disabled')
}

function error(data,ids){
 Msg.warning(data, 5000);
  $(ids).removeAttr('disabled')
}
</script>

 @yield('scripts')
