@extends('layouts.admin')

@section('title')
    <title>Sửa phòng</title>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Cinema','key' =>'Edit'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('cinema.update',['id'=>$cinema[0]->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên phòng</label>
                                <input type="text" class="form-control"
                                       placeholder="Nhập tên phòng" name="cinema_name" value="{{$cinema[0]->cinema_name}}">
                            </div>

                            <div class="form-group">
                                <label>Số ghế</label>
                                <input type="number" class="form-control"
                                       placeholder="Nhập số ghế" name="chair_number" value="{{$cinema[0]->chair_number}}">
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
