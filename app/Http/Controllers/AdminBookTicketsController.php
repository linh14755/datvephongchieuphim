<?php

namespace App\Http\Controllers;

use App\Customer;
use App\MovieTitle;
use App\MovieTitleTicket;
use App\Ticket;
use App\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;


class AdminBookTicketsController extends Controller
{
    private $ticket;
    private $customer;
    private $ticketType;
    private $movieTitle;
    private $movieTitleTicket;

    public function __construct(Ticket $ticket, Customer $customer, TicketType $ticketType, MovieTitle $movieTitle, MovieTitleTicket $movieTitleTicket)
    {
        $this->ticket = $ticket;
        $this->customer = $customer;
        $this->ticketType = $ticketType;
        $this->movieTitle = $movieTitle;
        $this->movieTitleTicket = $movieTitleTicket;
    }

    public function index()
    {
        $movieTitle = $this->movieTitle->latest()->paginate(20);
        return view('admin.bookticket.index', compact('movieTitle'));
    }

    public function create($id)
    {
        $movieTitle = $this->movieTitle->find($id);
        $customer = $this->customer->all();
        $ticketType = $this->ticketType->all();
        //Check trong suat chieu nay da co bao nhieu ve duoc ban ra
        $movieTitleTicketInTicket = $this->movieTitleTicket->where('movie_title_id', $id)->get();
        $ticketIsHave = array();
        foreach ($movieTitleTicketInTicket as $movieTitleTicketInTicketItem) {
            $ticketIsHave[] = $this->ticket->find($movieTitleTicketInTicketItem->ticket_id);
        }

        return view('admin.bookticket.add', compact('customer', 'ticketType', 'movieTitle', 'ticketIsHave'));
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            foreach ($request->chair_numbers as $chair_number) {


                $dataTicketCrate = [
                    'ticket_type_id' => $request->ticket_type_id,
                    'chair' => $chair_number,
                    'user_id' => auth()->id(),
                    'ticket_sale_date' => Carbon::now(),
                ];
                if (!empty($request->customer_id)) {
                    $dataTicketCrate['customer_id'] = $request->customer_id;
                }

                $ticket = $this->ticket->create($dataTicketCrate);

                $ticket->movieTitle()->attach($request->title_movie_id);
            }

            DB::commit();
            return redirect()->route('listticket.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            $id = $request->title_movie_id;
            return redirect()->route('bookticket.create', compact('id'));
        }
    }
}
