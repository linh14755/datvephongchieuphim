<?php

namespace App\Http\Controllers;

use App\Cinema;
use App\Movie;
use App\MovieTitle;
use App\MovieTitleTicket;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PFD;
use Carbon\Carbon;

class AdminListTicketsController extends Controller
{
    private $ticket;
    private $movie;
    private $movieTitle;
    private $cinema;
    private $movieTitleTicket;

    public function __construct(Ticket $ticket, Movie $movie, MovieTitle $movieTitle, Cinema $cinema, MovieTitleTicket $movieTitleTicket)
    {
        $this->ticket = $ticket;
        $this->movie = $movie;
        $this->movieTitle = $movieTitle;
        $this->cinema = $cinema;
        $this->movieTitleTicket = $movieTitleTicket;
    }

    public function index()
    {
        $ticket = $this->ticket->latest()->paginate(20);
        $movie = $this->movie->all();
        $cinema = $this->cinema->all();
        return view('admin.listticket.index', compact('ticket', 'movie', 'cinema'));
    }

    public function edit($id)
    {
        $ticket = $this->ticket->find($id);

        $movie = $this->movie->all();
        $cinema = $this->cinema->all();
        $movieTitleCinema = $ticket->movieTitle[0];


        //Check trong suat chieu nay da co bao nhieu ve duoc ban ra
        $movieTitleTicketInTicket = $this->movieTitleTicket->where('movie_title_id', $movieTitleCinema->id)->get();
        $ticketIsHave = array();
        foreach ($movieTitleTicketInTicket as $movieTitleTicketInTicketItem) {
            if ($movieTitleTicketInTicketItem->ticket->status == 0 && $movieTitleTicketInTicketItem->ticket->customer_id == $ticket->customer_id) {
                $ticketIsHave[] = $this->ticket->find($movieTitleTicketInTicketItem->ticket_id);
            }
        }

        return view('admin.listticket.edit', compact('ticket', 'movie', 'movieTitleCinema', 'ticketIsHave', 'cinema'));
    }

    public function checkout(Request $request)
    {
        $ticket = $this->ticket->find($request->ticket_id);
        //Check trong suat chieu nay da co bao nhieu ve duoc ban ra
        $movieTitleTicketInTicket = $this->movieTitleTicket->where('movie_title_id', $request->movie_title_id)->get();

        $ticketIsHave = array();
        foreach ($movieTitleTicketInTicket as $movieTitleTicketInTicketItem) {
            if ($movieTitleTicketInTicketItem->ticket->status == 0 && $movieTitleTicketInTicketItem->ticket->customer_id == $ticket->customer_id) {
                $ticketIsHave[] = $this->ticket->find($movieTitleTicketInTicketItem->ticket_id);
            }
        }

        try {
            DB::beginTransaction();
            foreach ($ticketIsHave as $ticketIsHaveItem) {
                $this->ticket->find($ticketIsHaveItem->id)->update([
                    'status' => '1',
                ]);
            }
            DB::commit();
            return redirect()->route('listticket.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('listticket.index');
        }


    }


    public function print($id)
    {

        $ticket = $this->ticket->find($id);
        $movie = $this->movie->all();
        $cinema = $this->cinema->all();

        $movieTitleCinema = $ticket->movieTitle[0];

        //Check trong suat chieu nay da co bao nhieu ve duoc ban ra
        $movieTitleTicketInTicket = $this->movieTitleTicket->where('movie_title_id', $movieTitleCinema->id)->get();
        $ticketIsHave = array();
        foreach ($movieTitleTicketInTicket as $movieTitleTicketInTicketItem) {
            if ($movieTitleTicketInTicketItem->ticket->status == 1 && $movieTitleTicketInTicketItem->ticket->customer_id == $ticket->customer_id) {
                $ticketIsHave[] = $this->ticket->find($movieTitleTicketInTicketItem->ticket_id);
            }
        }

        return view('admin.listticket.print', compact('ticket', 'movie', 'movieTitleCinema', 'ticketIsHave', 'cinema'));
    }

    public function printpdf(Request $request, $id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($request));

        return $pdf->stream();
    }

    public function print_order_convert($request)
    {

        $arrTitleChair = array();
        foreach ($request->title_chair as $title_chairItem) {
            $arrTitleChair[] = explode('-', $title_chairItem);
        }
        $tongsotien = 0;
        $output = '
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<style>
*{
font-family: Dejavu Sans;
}
body, table{
font-size: 8pt;

}
h2{
font-family: Dejavu Sans;
}


.footer-left {
    text-align:center;
    text-transform:uppercase;
    padding-top:24px;
    position:relative;
    height: 150px;
    width:50%;
    color:#000;
    float:left;
    font-size: 12px;
    bottom:1px;
}
.footer-right {
    text-align:center;
    text-transform:uppercase;
    padding-top:24px;
    position:relative;
    height: 150px;
    width:50%;
    color:#000;
    font-size: 12px;
    float:right;
    bottom:1px;
}

</style>
<h2>Hệ thống đặt vé xem phim (môn hệ QTCSDL)</h2>

        <table class="table">
  <thead>
    <tr>
            <th scope="col">Tên phim</th>
            <th scope="col">Phòng</th>
            <th scope="col">Ghế</th>
            <th scope="col">Loại vé</th>
            <th scope="col">Ngày chiếu</th>
            <th scope="col">Giá</th>
</tr>
  </thead>
  <tbody>';
        foreach ($arrTitleChair as $arrTitleChairItem) {
            $tongsotien += $arrTitleChairItem[2];
            $output .= '
    <tr>
    <td>' . $request->movie_name . '</td>
    <td>' . $request->cinema_name . '</td>
    <td>' . $arrTitleChairItem[0] . '</td>
    <td>' . $arrTitleChairItem[1] . '</td>
    <td>' . $request->movie_screening . '</td>
    <td>' . $arrTitleChairItem[2] . '</td>
    </tr>
    ';
        }
        $output .= '
<tr>
      <td colspan="5" class="tong">Tổng cộng</td>
      <td class="cotSo">'.number_format(($tongsotien),0,",",".").'</td>
    </tr>
</tbody></table>

<div class="footer-left"> Đà Lạt, ngày '.Carbon::now()->day.' tháng '.Carbon::now()->month.' năm '.Carbon::now()->year.'<br/>
    Khách hàng
    </br><p>'.$request->customer_name.'</p>
    </div>
  <div class="footer-right">Đà Lạt, ngày '.Carbon::now()->day.' tháng '.Carbon::now()->month.' năm '.Carbon::now()->year.'<br/>
    Nhân viên
</br><p>'.$request->user_name.'</p>
    </div>

';


        return $output;
    }
}
