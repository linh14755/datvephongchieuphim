<?php

namespace App\Http\Controllers;

use App\Cinema;
use App\Movie;
use App\MovieTitle;
use App\Traits\DeleteModelTraits;
use Hamcrest\Thingy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminScreeningTitleController extends Controller
{
    use DeleteModelTraits;

    private $cinema;
    private $movie;
    private $movieTitle;

    public function __construct(Cinema $cinema, Movie $movie, MovieTitle $movieTitle)
    {
        $this->cinema = $cinema;
        $this->movie = $movie;
        $this->movieTitle = $movieTitle;
    }

    public function index()
    {
        $movieTitle = $this->movieTitle->latest()->paginate(20);
        return view('admin.screeningtitle.index', compact('movieTitle'));
    }

    public function create()
    {
        $cinema = $this->cinema->all();
        $movie = $this->movie->all();
        return view('admin.screeningtitle.add', compact('cinema', 'movie'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->movieTitle->create([
                'movie_id' => $request->movie_id,
                'cinema_id' => $request->cinema_id,
                'movie_screening' => $request->movie_screening,
            ]);
            DB::commit();
            return redirect()->route('screeningtitle.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('screeningtitle.create');
        }
    }

    public function edit($id)
    {
        $cinema = $this->cinema->all();
        $movie = $this->movie->all();
        $movieTitle = $this->movieTitle->find($id);
        return view('admin.screeningtitle.edit', compact('movieTitle', 'cinema', 'movie'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataMovieTitleUpdate = [
                'movie_id' => $request->movie_id,
                'cinema_id' => $request->cinema_id,
            ];
            if (!empty($request->movie_screening)) {
                $dataMovieTitleUpdate = [
                    'movie_screening' => $request->movie_screening,
                ];
            }
            $this->movieTitle->find($id)->update($dataMovieTitleUpdate);
            DB::commit();
            return redirect()->route('screeningtitle.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('screeningtitle.index');
        }
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->movieTitle);
    }
}
