<?php

namespace App\Http\Controllers;

use App\MovieFormat;
use App\Traits\DeleteModelTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminMovieFormatController extends Controller
{
    use DeleteModelTraits;

    private $movieFormat;

    public function __construct(MovieFormat $movieFormat)
    {
        $this->movieFormat = $movieFormat;
    }

    public function index()
    {
//        $movieFormat = $this->movieFormat->latest()->paginate(20);
        $movieFormat = DB::select("select * from movie_formats where deleted_at is null");
        return view('admin.movieformat.index', compact('movieFormat'));
    }

    public function create()
    {
        return view('admin.movieformat.add');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            DB::select("insert into movie_formats(format_name) values('" . $request->format_name . "');");

            DB::commit();
            return redirect()->route('movieformat.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('movieformat.create');
        }
    }

    public function edit($id)
    {
        $movieFormat = DB::select("select * from movie_formats where id=" . $id . "");
        return view('admin.movieformat.edit', compact('movieFormat'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            DB::select("update movie_formats set format_name='" . $request->format_name . "' where id='" . $id . "'");

            DB::commit();
            return redirect()->route('movieformat.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('movieformat.index');
        }
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->movieFormat);
    }
}
