<?php

namespace App\Http\Controllers;

use App\Movie;
use App\MovieFormat;
use App\MovieImage;
use App\Traits\DeleteModelTraits;
use App\Traits\StorageImageStrait;
use App\TypeOfMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class AdminMovieController extends Controller
{
    use StorageImageStrait;
    use DeleteModelTraits;

    private $movie;
    private $typeOfMovie;
    private $movieFormat;
    private $movieImage;

    public function __construct(Movie $movie, TypeOfMovie $typeOfMovie, MovieFormat $movieFormat, MovieImage $movieImage)
    {
        $this->movie = $movie;
        $this->movieFormat = $movieFormat;
        $this->typeOfMovie = $typeOfMovie;
        $this->movieImage = $movieImage;
    }

    public function index()
    {
        $movie = $this->movie->latest()->paginate(20);
        return view('admin.movie.index', compact('movie'));
    }

    public function create()
    {
        $typeOfMovie = $this->typeOfMovie->all();
        $movieFormat = $this->movieFormat->all();

        return view('admin.movie.add', compact('typeOfMovie', 'movieFormat'));

    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            //Insert data to products
            $dataMovieCreate = [
                'movie_name' => $request->movie_name,
                'producer' => $request->producer,
                'content' => $request->contents,
                'typeofmovie_id' => $request->type_of_movie_id,
                'movieformat_id' => $request->movie_format_id,
                'publishing_year' => $request->publishing_year,
                'user_id' => auth()->id(),
            ];


            $dataUploadfeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'movies');

            if (!empty($dataUploadfeatureImage)) {
                $dataMovieCreate['feature_image_name'] = $dataUploadfeatureImage['file_name'];
                $dataMovieCreate['feature_image_path'] = $dataUploadfeatureImage['file_path'];
            }
            $movie = $this->movie->create($dataMovieCreate);


            //Insert data to product_images
            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $fileItem) {
                    $dataImageImageDetail = $this->storageTraitUploadMultipe($fileItem, 'movies');

                    $movie->images()->create([
                        'image_path' => $dataImageImageDetail['file_path'],
                        'image_name' => $dataImageImageDetail['file_name']
                    ]);
                }
            }

            DB::commit();

            //Sau khi thêm sản phẩm xong quay lại trang danh sách sản phẩm
            return redirect()->route('movie.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();

        }
    }

    public function edit($id)
    {
        $movie = $this->movie->find($id);
        $typeOfMovie = $this->typeOfMovie->all();
        $movieFormat = $this->movieFormat->all();
        return view('admin.movie.edit', compact('movie', 'typeOfMovie', 'movieFormat'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            //Update data to products
            $dataMovieUpdate = [
                'movie_name' => $request->movie_name,
                'producer' => $request->producer,
                'content' => $request->contents,
                'typeofmovie_id' => $request->type_of_movie_id,
                'movieformat_id' => $request->movie_format_id,
                'publishing_year' => $request->publishing_year,
                'user_id' => auth()->id(),
            ];
            $dataUploadfeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'movies');

            if (!empty($dataUploadfeatureImage)) {
                $dataMovieUpdate['feature_image_name'] = $dataUploadfeatureImage['file_name'];
                $dataMovieUpdate['feature_image_path'] = $dataUploadfeatureImage['file_path'];
            }

            $this->movie->find($id)->update($dataMovieUpdate);
            $movie = $this->movie->find($id);

            //Update data to product_images
            $this->movieImage->where('movie_id', $id)->delete();
            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMultipe($fileItem, 'movies');

                    $movie->images()->create([
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name']
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('movie.index');

        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
//            return redirect()->route('movie.index');
        }
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->movie);
    }
}
