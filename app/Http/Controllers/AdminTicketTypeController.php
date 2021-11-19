<?php

namespace App\Http\Controllers;

use App\TicketType;
use App\Traits\DeleteModelTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminTicketTypeController extends Controller
{
    use DeleteModelTraits;

    private $ticketType;

    public function __construct(TicketType $ticketType)
    {
        $this->ticketType = $ticketType;
    }

    public function index()
    {
        $ticketType = $this->ticketType->latest()->paginate(20);
        return view('admin.tickettype.index', compact('ticketType'));
    }

    public function create()
    {
        return view('admin.tickettype.add');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->ticketType->create([
                'ticket_type_name' => $request->ticket_type_name,
                'price' => $request->price,
            ]);
            DB::commit();
            return redirect()->route('tickettype.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('tickettype.create');
        }
    }

    public function edit($id)
    {
        $ticketType = $this->ticketType->find($id);
        return view('admin.tickettype.edit', compact('ticketType'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->ticketType->find($id)->update([
                'ticket_type_name' => $request->ticket_type_name,
                'price' => $request->price,
            ]);
            DB::commit();
            return redirect()->route('tickettype.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('tickettype.edit');
        }
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->ticketType);
    }
}
