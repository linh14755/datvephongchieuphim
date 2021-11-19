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
        $cinema = $this->cinema->latest()->paginate(20);
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
            $this->cinema->create([
                'cinema_name' => $request->cinema_name,
                'chair_number' => $request->chair_number,
            ]);
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
        $cinema = $this->cinema->find($id);
        return view('admin.cinema.edit', compact('cinema'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->cinema->find($id)->update([
                'cinema_name' => $request->cinema_name,
                'chair_number' => $request->chair_number,
            ]);
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
