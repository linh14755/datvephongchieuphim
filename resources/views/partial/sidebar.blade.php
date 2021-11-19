<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>

            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('customer.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                        <p>
                            Khách hàng

                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{route('cinema.index')}}" class="nav-link">
                    <i class="fas fa-person-booth"></i>
                        <p>
                            Phòng

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-film"></i>
                        <p>
                            Phim
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{route('typeofmovie.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thể loại phim</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('movieformat.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dạng phim</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{route('movie.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Phim</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            Vé
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{route('tickettype.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Loại vé</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('screeningtitle.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Suất chiếu</p>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="{{route('listticket.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Vé đã bán</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{route('bookticket.index')}}" class="nav-link">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                        <p>Đặt vé</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
