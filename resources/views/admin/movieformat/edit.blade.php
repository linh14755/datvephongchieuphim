@extends('layouts.admin')

@section('title')
    <title>Sửa loại phim</title>
@endsection

@section('css')

@endsection

@section('js')

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Movie Format','key' =>'Edit'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('movieformat.update',['id'=>$movieFormat[0]->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên dạng phim</label>
                                <input type="text" class="form-control "
                                       placeholder="Nhập tên dạng phim" name="format_name" value="{{$movieFormat[0]->format_name}}">
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
