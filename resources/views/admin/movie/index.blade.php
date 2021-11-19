@extends('layouts.admin')

@section('title')
    <title>Phim</title>
@endsection

@section('css')

@endsection

@section('js')
    <script src="{{asset('js/sweetalert2.js')}}"></script>
    <script src="{{asset('admins/main.js')}}"></script>
    <script>
        $('#myInputSearch').on('keyup', function (e) {
            var txt = $('#myInputSearch').val();
            $.ajax({
                type: "GET",
                cache: false,
                url: "{{route('movie.search')}}",
                data: {txt: txt},
                success: function (html) {
                    $('#myTable').html(html);
                    console.log(html);
                }
            });
        })
    </script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Movie','key' =>'List'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="input-group p-2 col-md-11">
                                <div class="form-outline col-md-4">
                                    <input type="search" id="myInputSearch" class="form-control"
                                           placeholder="Tìm kiếm"/>
                                </div>
                            </div>

                            <a href="{{route('movie.create')}}"
                               class="btn btn-outline-success m-2 float-right">Add</a>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên phim</th>
                            <th scope="col">Loại phim</th>
                            <th scope="col">Dạng phim</th>
                            <th scope="col">Nhà sản xuất</th>
                            <th scope="col">Ảnh đại diện</th>
                            <th scope="col">Action</th>

                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach($movie as $value)
                            <tr>
                                <th scope="row">{{$value->id}}</th>
                                <th scope="row">{{$value->movie_name}}</th>
                                <th scope="row">{{$value->type_name}}</th>
                                <th scope="row">{{$value->format_name}}</th>
                                <th scope="row">{{$value->producer}}</th>
                                <th scope="row"><img style="width: 100%;height: auto;max-width: 150px;"
                                                     src="{{$value->feature_image_path}}"
                                                     class="img-fluid img-thumbnail"></th>
                                <td>

                                    <a href="{{route('movie.edit',['id'=>$value->id])}}"
                                       class="btn btn-default">Edit</a>


                                    <a href="javascript:void(0)"
                                       data-url="{{route('movie.delete',['id'=>$value->id])}}"
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
    <!-- /.content-wrapper -->
@endsection
