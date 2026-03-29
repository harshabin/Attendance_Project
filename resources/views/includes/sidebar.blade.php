

    <!-- Sidebar -->
    <div class="sidebar">
   @php 
$role=$_SESSION['roles'];

   @endphp

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @if($role=="admin")
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('registration') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Student Registration
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('attendance') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Attendance
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('qr_code') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Barcode
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('scanner') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Scanner
              </p>
            </a>
          </li>
          @else
          <li class="nav-item">
            <a href="{{ route('scanner') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Scanner
              </p>
            </a>
          </li>
          @endif
         
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
   


   
    </div>
    <!-- /.sidebar -->
