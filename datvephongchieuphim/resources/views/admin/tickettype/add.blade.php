@extends('layouts.admin')

@section('title')
    <title>Thêm loại vé</title>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Ticket Type','key' =>'Add'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('tickettype.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên loại vé</label>
                                <input type="text" class="form-control"
                                       placeholder="Nhập tên loại vé" name="ticket_type_name"
                                       value="{{old('ticket_type_name')}}">
                            </div>
                            <div class="form-group">
                                <label>Giá tiền</label>
                                <input type="number" class="form-control"
                                       placeholder="Nhập giá tiền" name="price" value="{{old('price')}}">
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
