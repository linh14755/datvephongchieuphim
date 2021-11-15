@extends('layouts.admin')

@section('title')
    <title>Thêm suất chiếu</title>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Screening Title','key' =>'Add'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('screeningtitle.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên Phim</label>
                                <select class="form-control"
                                        name="movie_id">
                                    <option value="">Chọn tên phim</option>
                                    @foreach($movie as $movieItem)
                                        <option
                                            value="{{$movieItem->id}}">{{$movieItem->movie_name.' - '.optional($movieItem->movieFormat)->format_name.' - '.$movieItem->producer}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tên Phòng</label>
                                <select class="form-control"
                                        name="cinema_id">
                                    <option value="">Chọn phòng</option>
                                    @foreach($cinema as $cinemaItem)
                                        <option
                                            value="{{$cinemaItem->id}}">{{$cinemaItem->cinema_name.' - '.$cinemaItem->chair_number.' ghế'}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Suất chiếu</label>
                                <input type="datetime-local" class="form-control"
                                       name="movie_screening" value="{{old('movie_screening')}}">
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
