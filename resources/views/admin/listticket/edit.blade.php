@extends('layouts.admin')

@section('title')
    <title>Sửa vé</title>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partial.content-header',['name'=>'Ticket','key' =>'Detail'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">


                            <div class="form-group">
                                <label>Thông tin suất chiếu</label></br>


                                <img src="{{asset($movie->find($ticket->movieTitle[0]->movie_id)->feature_image_path)}}"
                                     style="width: 150px" ;height="150px" class="img-fluid img-thumbnail">

                                <p>Phòng: {{ $cinema->find($ticket->movieTitle[0]->cinema_id)->cinema_name }}</p>
                                <input type="hidden" name="cinema_name"
                                       value="{{ $movie->find($ticket->movieTitle[0]->movie_id)->cinema_name }}">


                                <p>Tên phim: {{ $movie->find($ticket->movieTitle[0]->movie_id)->movie_name }}</p>
                                <input type="hidden" name="movie_name"
                                       value="{{ $movie->find($ticket->movieTitle[0]->movie_id)->movie_name }}">

                                <p>Nhà sản xuất: {{ $movie->find($ticket->movieTitle[0]->movie_id)->producer }}</p>
                                <input type="hidden" name="producer"
                                       value="{{ $movie->find($ticket->movieTitle[0]->movie_id)->producer }}">

                                <p>Thời gian chiếu: {{$ticket->movieTitle[0]->movie_screening}}</p>
                                <input type="hidden" name="movie_screening"
                                       value="{{$ticket->movieTitle[0]->movie_screening}}">

                                <p>Tên khách hàng: {{optional($ticket->customer)->name}}</p>
                                <input type="hidden" name="customer_name" value="{{optional($ticket->customer)->name}}">

                                <p>Loại vé: {{optional($ticket->ticketType)->ticket_type_name}}</p>
                            </div>

                            <div class="form-group border">
                                <div class="row">
                                    @for($i = 1;$i <= optional($movieTitleCinema->cinema)->chair_number; $i++)
                                        <div class="col-md-2">
                                            <input type="checkbox" name="chair_numbers[]"
                                                   value="{{$i}}" @if(!empty($ticketIsHave)) @foreach($ticketIsHave as $ticketIsHaveItem) {{$ticketIsHaveItem->chair == $i ?'disabled' :''}} @endforeach @else  @endif >
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

                            <div class="form-group">
                                <?php $totalprice = 0; ?>
                                <p>Các ghế đã đặt: </br>
                                    @if(!empty($ticketIsHave))
                                        @foreach($ticketIsHave as $ticketIsHaveItem)

                                            Ghế <input type="hidden" name="title_chair[]"
                                                       value="{{$ticketIsHaveItem->chair.'-'.optional($ticket->ticketType)->ticket_type_name.'-'.($price = optional($ticket->ticketType)->price)}}">
                                            {{$ticketIsHaveItem->chair.' - '.optional($ticket->ticketType)->ticket_type_name.' - '.($price = optional($ticket->ticketType)->price)}} </br>
                                            <?php $totalprice += $price; ?>
                                        @endforeach
                                    @else
                                    @endif</p>
                                <h2 class="text-uppercase"><b>Tổng tiền: <?php echo number_format($totalprice); ?></b></h2>
                            </div>
                            <form action="{{route('listticket.checkout')}}" method="post">
                                @csrf
                                <input type="hidden" name="movie_title_id"
                                       value="{{$ticket->movieTitle[0]->id}}">
                                <input type="hidden" name="ticket_id"
                                       value="{{$ticket->id}}">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
