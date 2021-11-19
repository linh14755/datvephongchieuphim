@extends('layouts.admin')

@section('title')
    <title>Danh sách dạng phim</title>
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
    @include('partial.content-header',['name'=>'Book Ticket','key' =>'List'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{--                        <a href=""--}}
                        {{--                           class="btn btn-outline-success m-2 float-right">Add</a>--}}
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Phòng</th>
                                <th scope="col">Tên phim</th>
                                <th scope="col">Thời gian chiếu</th>
                                <th scope="col">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($movieTitle as $value)
                                <tr>
                                    <th scope="row">{{$value->id}}</th>
                                    <td>{{optional($value->cinema)->cinema_name}}</td>
                                    <td>{{optional($value->movie)->movie_name}}</td>
                                    <td>{{$value->movie_screening}}</td>
                                    <td>

                                        <a href="{{route('bookticket.create',['id'=>$value->id])}}"
                                           class="btn btn-default">Đặt vé</a>

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
