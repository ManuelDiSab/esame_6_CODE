<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\FilmStoreRequest;
use App\Http\Requests\v1\FilmUpdateRequest;
use App\Http\Resources\v1\collection\FilmCollection;
use App\Http\Resources\v1\FilmResource;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return JsonResource
     */
    public function index(){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){

                 return new FilmCollection(Film::all(
                    "idFilm",
                    "idGenere",
                    "titolo",
                    "regista",
                    "durata",
                    "anno",
                ));
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show(Film $film)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $resource = new FilmResource($film);
                if($resource){
                    return response()->json($resource, 200);
                }else{
                    return response()->json(['message' => 'Film non trovato'], 404);
                }
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return JsonResource
     */
    public function store(FilmStoreRequest $request){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){

                $data = $request->validated();
                $resource = Film::create($data);

                $new =  new FilmResource($resource);
                return response()->json(["nuova risorsa"=> $new],201);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param $idFilm 
     * @return JsonResource
     */
    public function update(FilmUpdateRequest $request, Film $film){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $data = $request->validated();
                $film -> fill($data);
                $film->save();
                $new = new FilmResource($film); 

                return response()->json(["risorsa" => $new], 200);      
            }
        }
    }

    /**
     * Elimina una risorsa
     * 
     * @param integer $idFilm 
     * @return 
     */
    public function destroy($idFilm){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $film = Film::findOrFail($idFilm);
                $film->delete();

                return response()->json("Film eliminato",204);
            }
        }
    }

}
