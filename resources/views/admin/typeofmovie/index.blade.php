@extends('layouts.admin')

@section('title')
    <title>Danh sách loại phim</title>
@endsection

@section('js')
    <script src="{{asset('js/sweetalert2.js')}}"></script>
    <script src="{{asset('admins/main.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Type Of Movie','key' =>'List'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">


                    <div class="form-outline col-md-4">
                        <input type="search" id="myInput" onkeyup="myFunction()" class="form-control"
                               placeholder="Tìm kiếm"/>

                    </div>
                    <div class="col-md-8">
                        <a href="{{route('typeofmovie.create')}}"
                           class="btn btn-outline-success m-2 float-right">Add</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Loại phim</th>
                                <th scope="col">Action</th>

                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @foreach($typeOfMovie as $value)
                                <tr>
                                    <th scope="row">{{$value->id}}</th>
                                    <td>{{$value->type_name}}</td>

                                    <td>

                                        <a href="{{route('typeofmovie.edit',['id'=>$value->id])}}"
                                           class="btn btn-default">Edit</a>
                                        <a href="javascript:void(0)"
                                           data-url="{{route('typeofmovie.delete',['id'=>$value->id])}}"
                                           class="btn btn-outline-danger action_delete">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            <td>
                                {{$typeOfMovie->links()}}
                            </td>

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
