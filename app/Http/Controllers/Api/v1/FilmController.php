<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\FilmStoreRequest;
use App\Http\Requests\v1\FilmUpdateRequest;
use App\Http\Resources\v1\FilmCollection;
use App\Http\Resources\v1\FilmResource;
use App\Models\Film;
use App\Models\generi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return JsonResource
     */
    public function index(Request $request){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $titolo = request('titolo');

                $genere = $request->input('genere');
                if($genere){       
                    $film =Film::all()->where('idGenere',$genere);
                }else if($titolo){
                    $film = Film::where('titolo','like',"{$titolo}%")
                    ->get();
                    return new FilmCollection($film);
                }else{
                    $film  = Film::all();
                   return new FilmCollection($film); 
                }
            }
        }
    }



    /**
     * Funzione che ritorna la lista dei film appartenenti al genere passato
     * 
     */
    public function indexGenere( $idGenere){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                 return new FilmCollection(Film::where('idGenere','=',$idGenere)->get());
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
                return new FilmResource($film);
            }
        }
    }


    /**
     * 
     * 
     * 
     */
    public function ricerca()
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $titolo = request('titolo');
                if($titolo){
                        $film = Film::where('titolo','like',"{$titolo}%")
                        ->get();
                        return new FilmCollection($film);
                    }else{
                       return null;
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
                $img = $new->path_img;
                move_uploaded_file($img,'C:\Users\manue\Desktop\NUOVO ESAME\Esame-6-angular\src\assets\film_cover');
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


    /**
     * 
     * 
     * 
     */
    

}
