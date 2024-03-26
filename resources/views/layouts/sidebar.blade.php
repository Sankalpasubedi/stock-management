<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

        </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="{{route('home')}}" class="brand-link">
            <img src="{{url('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Stock MMT</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="{{route('category')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Category
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('product')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Product
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('unit')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Unit
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('brand')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Brand
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('vendor')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Vendor
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('customer')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Customer
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('bill')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Bills
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('return')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Returned Products
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar -->
        </div>
    </aside>


</div>
<!-- /.content-wrapper -->


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>

