<?php

namespace App\Http\Controllers;

use App\Cinema;
use App\Traits\DeleteModelTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminCinemaController extends Controller
{
    use DeleteModelTraits;

    private $cinema;

    public function __construct(Cinema $cinema)
    {
        $this->cinema = $cinema;
    }

    public function index()
    {
        $cinema = DB::select("select * from cinemas where deleted_at is null");
        return view('admin.cinema.index', compact('cinema'));
    }

    public function create()
    {
        return view('admin.cinema.add');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            DB::select("insert into cinemas(cinema_name, chair_number) values('" . $request->cinema_name . "','" . $request->chair_number . "')");

            DB::commit();
            return redirect()->route('cinema.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('cinema.create');
        }
    }

    public function edit($id)
    {
//        $cinema = $this->cinema->find($id);
        $cinema = DB::select("select * from cinemas where id=" . $id . "");

        return view('admin.cinema.edit', compact('cinema'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            DB::select("update cinemas set cinema_name='" . $request->cinema_name . "', chair_number='" . $request->chair_number . "' where id=" . $id . "");

            DB::commit();
            return redirect()->route('cinema.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('cinema.index');
        }
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->cinema);
    }
}
