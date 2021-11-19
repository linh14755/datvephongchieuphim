@extends('layouts.admin')

@section('title')
    <title>Danh sách phòng</title>
@endsection

@section('css')

@endsection

@section('js')
    <script src="{{asset('js/sweetalert2.js')}}"></script>
    <script src="{{asset('admins/main.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Cinema','key' =>'List'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('cinema.create')}}"
                           class="btn btn-outline-success m-2 float-right">Add</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên phòng</th>
                                <th scope="col">Số ghế</th>
                                <th scope="col">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cinema as $value)
                                <tr>
                                    <th scope="row">{{$value->id}}</th>
                                    <td>{{$value->cinema_name}}</td>
                                    <td>{{$value->chair_number}}</td>

                                    <td>

                                        <a href="{{route('cinema.edit',['id'=>$value->id])}}"
                                           class="btn btn-default">Edit</a>
                                        <a href="javascript:void(0)"
                                           data-url="{{route('cinema.delete',['id'=>$value->id])}}"
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
