@extends('layouts.admin')

@section('title')
    <title>Thêm phim</title>
@endsection

@section('css')

    <link rel="stylesheet" href="{{asset('/adminlte/plugins/summernote/summernote-bs4.min.css')}}">
@endsection

@section('js')
    <script src="{{asset('admins/movie/add.js')}}"></script>

    <!-- Summernote -->
    <script src="{{asset('/adminlte/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{asset('/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

    <script>
        $(function () {
            // Summernote
            $('#summernote').summernote()


            //Custom Input
            bsCustomFileInput.init();
        })

    </script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Movie','key' =>'Edit'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <form action="{{route('movie.update',['id'=>$movie->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Tên phim</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nhập tên phim"
                                    name="movie_name"
                                    value="{{$movie->movie_name}}">
                            </div>

                            <div class="form-group">
                                <label>Nhà sản xuất</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nhập tên nhà sản xuất"
                                    name="producer"
                                    value="{{$movie->producer}}">
                            </div>
                            <div class="form-group">
                                <label>Năm sản xuất</label>
                                <select class="form-control" name="publishing_year">
                                    <?php
                                    for ($year = (int)date('Y'); 1900 <= $year; $year--): ?>
                                    <option
                                        {{ ($movie->publishing_year == $year) ?'selected':'' }} value="<?=$year;?>"><?=$year;?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="InputFeatureImage">Ảnh đại diện</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="InputFeatureImage"
                                               name="feature_image_path">
                                        <label class="custom-file-label" for="InputFeatureImage">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>

                                <img class="img-fluid img-thumbnail" src="{{$movie->feature_image_path}}"
                                     style="width: 100%;height: auto;max-width: 150px;">
                            </div>

                            <div class="form-group">
                                <label for="InputFeatureImagePath">Ảnh chi tiết</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="InputFeatureImagePath"
                                               name="image_path[]" multiple>
                                        <label class="custom-file-label" for="InputFeatureImagePath">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>


                                <div class="row">
                                    @foreach($movie->images as $imageItem)
                                        <img class="img-fluid img-thumbnail" src="{{$imageItem->image_path}}"
                                             style="width: 100%;height: auto;max-width: 100px;">
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Chọn loại phim</label>
                                <select class="form-control"
                                        name="type_of_movie_id">
                                    <option value="">Chọn loại phim</option>
                                    @foreach($typeOfMovie as $typeOfMovieItem)
                                        <option
                                            {{optional($movie->typeOfMovie)->id == $typeOfMovieItem->id ? 'selected' : ''}}
                                            value="{{$typeOfMovieItem->id}}">{{$typeOfMovieItem->type_name}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group">
                                <label>Chọn dạng phim</label>
                                <select class="form-control"
                                        name="movie_format_id">
                                    <option value="">Chọn dạng phim</option>
                                    @foreach($movieFormat as $movieFormatItem)
                                        <option
                                            {{optional($movie->movieFormat)->id == $movieFormatItem->id ? 'selected' : ''}}
                                            value="{{$movieFormatItem->id}}">{{$movieFormatItem->format_name}}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Mô tả sản phẩm
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <textarea id="summernote" style="display: none;"
                                              name="contents">{!! $movie->content !!}</textarea>
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 mb-4">Submit</button>
                        </div>

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </form>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
