@extends('layouts.admin')

@section('title')
    <title>Đặt vé</title>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Ticket','key' =>'Add'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <form action="{{route('bookticket.store')}}" method="post" enctype="multipart/form-data">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">

                            @csrf
                            <div class="form-group">
                                <label>Tên khách hàng (có thể trống)</label>
                                <select class="form-control"
                                        name="customer_id">
                                    <option value="">Chọn khách hàng</option>
                                    @foreach($customer as $customerItem)
                                        <option
                                            value="{{$customerItem->id}}">{{$customerItem->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Loại vé</label>
                                <select class="form-control"
                                        name="ticket_type_id">
                                    <option value="">Chọn loại vé</option>
                                    @foreach($ticketType as $ticketTypeItem)
                                        <option
                                            value="{{$ticketTypeItem->id}}">{{$ticketTypeItem->ticket_type_name.' - '.number_format($ticketTypeItem->price)}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Thông tin suất chiếu đã chọn</label></br>
                                <img src="{{asset(optional($movieTitle->movie)->feature_image_path)}}"
                                     style="width: 150px" ;height="150px">
                                <input type="hidden" value="{{$movieTitle->id}}" name="title_movie_id">
                                <p>Phòng: {{optional($movieTitle->cinema)->cinema_name}}</p>
                                <p>Tên phim: {{optional($movieTitle->movie)->movie_name}}</p>
                                <p>Nhà sản xuất: {{optional($movieTitle->movie)->producer}}</p>
                                <p>Thời gian chiếu: {{$movieTitle->movie_screening}}</p>


                            </div>


                            <div class="form-group border">
                                <div class="row">
                                    @for($i = 1;$i <= optional($movieTitle->cinema)->chair_number; $i++)
                                        <div class="col-md-2">

                                            <input type="checkbox" name="chair_numbers[]" value="{{$i}}" @if(!empty($ticketIsHave)) @foreach($ticketIsHave as $ticketIsHaveItem) {{$ticketIsHaveItem->chair == $i ?'disabled':''}} @endforeach @else  @endif >
                                            <label
                                                class=" @if(!empty($ticketIsHave)) @foreach($ticketIsHave as $ticketIsHaveItem) {{$ticketIsHaveItem->chair == $i ?'text-warning':'text-success'}} @endforeach @else text-success @endif">Ghế {{$i}}</label>
                                        </div>

                                    @endfor
                                </div>

                            </div>
                            <div class="form-group">
                                <label>
                                    <button type="button" class="btn btn-success"></button>
                                    còn trống</label>
                                <label>
                                    <button type="button" class="btn btn-warning"></button>
                                    đã được đặt</label>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4">Submit</button>

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
