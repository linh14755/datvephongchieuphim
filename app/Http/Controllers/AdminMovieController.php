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
        $movie = DB::select("select m.id, m.movie_name, type_of_movies.type_name, movie_formats.format_name, m.producer, m.feature_image_path  from movies m, type_of_movies, movie_formats" .
            " where m.typeofmovie_id = type_of_movies.id and" .
            " m.movieformat_id = movie_formats.id and m.deleted_at is null");

        return view('admin.movie.index', compact('movie'));
    }

    public function create()
    {
        $typeOfMovie = DB::select("select * from type_of_movies where deleted_at is null");
        $movieFormat = DB::select("select * from movie_formats where deleted_at is null");

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
            $cre = $dataMovieCreate;

            $movie = DB::select("insert into movies(movie_name, producer, content, typeofmovie_id, movieformat_id, publishing_year, user_id, feature_image_name, feature_image_path)" .
                " values('" . $cre['movie_name'] . "', '" . $cre['producer'] . "', '" . $cre['content'] . "', " . $cre['typeofmovie_id'] . "" .
                ", " . $cre['movieformat_id'] . ", '" . $cre['publishing_year'] . "', " . $cre['user_id'] . ", " .
                "'" . $cre['feature_image_name'] . "', '" . $cre['feature_image_path'] . "') ");

            $mnew = DB::select("SELECT * FROM movies ORDER BY id DESC LIMIT 1");
            //Insert data to product_images
            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $fileItem) {
                    $dataImageImageDetail = $this->storageTraitUploadMultipe($fileItem, 'movies');

                    $arr = [
                        'image_path' => $dataImageImageDetail['file_path'],
                        'image_name' => $dataImageImageDetail['file_name'],
                        'movie_id' => $mnew[0]->id
                    ];
                    DB::select("insert into movie_images(image_path, image_name, movie_id) values('" . $arr['image_path'] . "', '" . $arr['image_name'] . "', " . $arr['movie_id'] . ")");
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
        $movie = DB::select("select m.id, m.movie_name, type_of_movies.type_name, movie_formats.format_name, m.producer, m.feature_image_path, m.publishing_year, type_of_movies.id as typeofmovie_id, movie_formats.id as movie_format_id, m.content  from movies m, type_of_movies, movie_formats" .
            " where m.typeofmovie_id = type_of_movies.id and" .
            " m.movieformat_id = movie_formats.id and m.deleted_at is null and m.id=" . $id . "");

        $images = DB::select("select * from movie_images where movie_id=" . $id . "");

        $typeOfMovie = DB::select("select * from type_of_movies where deleted_at is null");
        $movieFormat = DB::select("select * from movie_formats where deleted_at is null");

        return view('admin.movie.edit', compact('movie', 'typeOfMovie', 'movieFormat', 'images'));
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

                $up = $dataMovieUpdate;

                DB::select("update movies set movie_name='" . $up['movie_name'] . "', producer='" . $up['producer'] . "', " .
                    "content='" . $up['content'] . "', typeofmovie_id=" . $up['typeofmovie_id'] . ", movieformat_id=" . $up['movieformat_id'] . ", " .
                    "publishing_year='" . $up['publishing_year'] . "', user_id=" . $up['user_id'] . ", feature_image_name='" . $up['feature_image_name'] . "', feature_image_path='" . $up['feature_image_path'] . "' where id=" . $id . "");

                $movie = DB::select("select * from movies where id=" . $id . "");
            } else {
                $up = $dataMovieUpdate;

                DB::select("update movies set movie_name='" . $up['movie_name'] . "', producer='" . $up['producer'] . "', " .
                    "content='" . $up['content'] . "', typeofmovie_id=" . $up['typeofmovie_id'] . ", movieformat_id=" . $up['movieformat_id'] . ", " .
                    "publishing_year='" . $up['publishing_year'] . "', user_id=" . $up['user_id'] . " where id=" . $id . "");
            }

            $movie = DB::select("select * from movies where id=" . $id . "");

            //Update data to product_images
            $this->movieImage->where('movie_id', $id)->delete();
            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMultipe($fileItem, 'movies');

                    DB::select("insert into movie_images(image_path, image_name, movie_id) values('" . $dataProductImageDetail['file_path'] . "', '" . $dataProductImageDetail['file_name'] . "', " . $movie->id . ")");
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

    public function search()
    {
        if (!empty($_GET['txt'])) {
            $txt = $_GET['txt'];

            $result = DB::select("select * from movies where match(movie_name)  against('" . $txt . "') and deleted_at is null");
        } else {
            $result = DB::select("select * from movies where  deleted_at is null");
        }

        foreach ($result as $value) {
            echo ' ?>
            <tr>
                <th scope="row">' . $value->id . '</th>
                <th scope="row">' . $value->movie_name . '</th>
                <th scope="row">' . optional($value->typeofmovie_id)->type_name . '</th>
                <th scope="row">' . optional($value->movieformat_id)->format_name . '</th>
                <th scope="row">' . $value->producer . '</th>
                <th scope="row"><img style="width: 100%;height: auto;max-width: 150px;"
                                     src="' . $value->feature_image_path . '"
                                     class="img-fluid img-thumbnail"></th>
                <td>

                    <a href="' . route('movie.edit', ['id' => $value->id]) . '"
                       class="btn btn-default">Edit</a>


                    <a href="javascript:void(0)"
                       data-url="' . route('movie.delete', ['id' => $value->id]) . '"
                       class="btn btn-outline-danger action_delete">Delete</a>

                </td>
            </tr>
            <?php
            ';
        }

    }
}
