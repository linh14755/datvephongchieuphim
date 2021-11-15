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
    @include('partial.content-header',['name'=>'Customer','key' =>'Edit'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('customer.update',['id'=>$customer->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên khách hàng</label>
                                <input type="text" class="form-control"
                                       placeholder="Nhập tên khách hàng" name="name" value="{{$customer->name}}">
                            </div>

                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="address" class="form-control"
                                       placeholder="Nhập địa chỉ" name="address" value="{{$customer->address}}">
                            </div>

                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input type="date" class="form-control"
                                       placeholder="Nhập ngày sinh" name="date_of_birth"
                                       value="{{$customer->date_of_birth}}">
                            </div>

                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="tel" class="form-control"
                                       placeholder="Nhập số điện thoại" name="phone_number"
                                       value="{{$customer->phone_number}}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control"
                                       placeholder="Nhập email" name="email" value="{{$customer->email}}">
                            </div>

                            <div class="form-group">
                                <label>Reset Password</label>
                                <input type="password" class="form-control" id="password"
                                       placeholder="Nhập mật khẩu mới" name="password" value="{{old('password')}}">
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
