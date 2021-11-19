@extends('layouts.admin')

@section('title')
    <title>Danh sách khách hàng</title>
@endsection

@section('css')
    {{--    <link rel="stylesheet" href="{{asset('admins/slider/add/add.css')}}">--}}
@endsection

@section('js')
    <script src="{{asset('js/sweetalert2.js')}}"></script>
    <script src="{{asset('admins/main.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Customer','key' =>'List'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('customer.create')}}" class="btn btn-outline-success m-2 float-right">Add</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Ngày sinh</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customer as $value)
                                <tr>
                                    <th scope="row">{{$value->id}}</th>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->address}}</td>
                                    <td>{{$value->date_of_birth}}</td>
                                    <td class="phone_number">{{$value->phone_number}}</td>
                                    <td>{{$value->email}}</td>

                                    <td>

                                        <a href="{{route('customer.edit',['id'=>$value->id])}}"
                                           class="btn btn-default">Edit</a>


                                        <a href="javascript:void(0)"
                                           data-url="{{route('customer.delete',['id'=>$value->id])}}"
                                           class="btn btn-outline-danger action_delete">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
