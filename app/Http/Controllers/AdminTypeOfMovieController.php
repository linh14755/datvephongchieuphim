<?php

namespace App\Http\Controllers;

use App\Traits\DeleteModelTraits;
use App\TypeOfMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminTypeOfMovieController extends Controller
{
    use DeleteModelTraits;

    private $typeOfMovie;

    public function __construct(TypeOfMovie $typeOfMovie)
    {
        $this->typeOfMovie = $typeOfMovie;
    }

    public function index()
    {
//        $typeOfMovie = $this->typeOfMovie->latest()->paginate(20);
        $typeOfMovie = DB::select("select * from type_of_movies where deleted_at is null");
        return view('admin.typeofmovie.index', compact('typeOfMovie'));
    }

    public function create()
    {
        return view('admin.typeofmovie.add');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            DB::select("insert into type_of_movies(type_name) values('" . $request->name . "')");

            DB::commit();
            return redirect()->route('typeofmovie.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('typeofmovie.create');
        }
    }

    public function edit($id)
    {
        $typeOfMovie = DB::select("select * from type_of_movies where id=" . $id . "");
        return view('admin.typeofmovie.edit', compact('typeOfMovie'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            DB::select("update type_of_movies set type_name='" . $request->name . "' where id=" . $id . "");

            DB::commit();
            return redirect()->route('typeofmovie.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('typeofmovie.edit');
        }
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->typeOfMovie);
    }
}
