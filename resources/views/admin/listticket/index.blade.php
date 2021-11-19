@extends('layouts.admin')

@section('title')
    <title>Danh sách vé đã bán</title>
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
    @include('partial.content-header',['name'=>'List Ticket','key' =>'List'])
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
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Tên phim</th>
                                <th scope="col">Số ghế</th>
                                <th scope="col">Phòng</th>
                                <th scope="col">Nhân viên đặt vé</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Trạng thái</th>

                                <th scope="col">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ticket as $value)
                                <tr>
                                    <th scope="row">{{$value->id}}</th>
                                    <td>{{optional($value->customer)->name}}</td>
                                    <td>{{ ($movie->find(optional($value->movieTitle[0])->movie_id))->movie_name }}</td>
                                    <td>Ghế {{$value->chair}}</td>
                                    <td>Phòng {{($cinema->find(optional($value->movieTitle[0])->cinema_id))->cinema_name}}</td>
                                    <td>{{optional($value->user)->name}}</td>
                                    <td>{{number_format(optional($value->ticketType)->price)}}</td>
                                    <td>{{$value->ticket_sale_date}}</td>
                                    <td><img
                                            src="{{$value->status == 0 ?asset('adminlte/dist/img/warning.png'):asset('adminlte/dist/img/checked.png')}}"
                                            style="max-width: 30px;max-height: 30px"></td>

                                    <td>
                                        @if($value->status == 0)
                                            <a href="{{route('listticket.edit',['id'=>$value->id])}}"
                                               class="btn btn-default">Thanh toán</a>
                                        @else
                                            <a href="{{route('listticket.print',['id'=>$value->id])}}"
                                               class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> In</a>
                                        @endif

                                        <a href="javascript:void(0)"
                                           data-url=""
                                           class="btn btn-outline-danger action_delete">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            <td>
                                {{$ticket->links()}}
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
