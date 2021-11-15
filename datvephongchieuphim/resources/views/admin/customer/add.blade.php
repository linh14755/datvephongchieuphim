@extends('layouts.admin')

@section('title')
    <title>Thêm khách hàng</title>
@endsection

@section('js')
    <script src="{{asset('admins/customer/add.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Customer','key' =>'Add'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('customer.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên khách hàng</label>
                                <input type="text" class="form-control"
                                       placeholder="Nhập tên khách hàng" name="name" value="{{old('name')}}">
                            </div>

                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="address" class="form-control"
                                       placeholder="Nhập địa chỉ" name="address" value="{{old('address')}}">
                            </div>

                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input type="date" class="form-control"
                                       placeholder="Nhập ngày sinh" name="date_of_birth"
                                       value="{{old('date_of_birth')}}">
                            </div>

                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="tel" class="form-control"
                                       placeholder="Nhập số điện thoại" name="phone_number"
                                       value="{{old('phone_number')}}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control"
                                       placeholder="Nhập email" name="email" value="{{old('email')}}">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" id="password"
                                       placeholder="Nhập mật khẩu" name="password" value="{{old('password')}}">
                                <input type="checkbox" onclick="showPassword()"> Show Password
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Submit</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
