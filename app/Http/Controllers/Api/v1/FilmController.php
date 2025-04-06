<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\FilmStoreRequest;
use App\Http\Requests\v1\FilmUpdateRequest;
use App\Http\Resources\v1\FilmCollection;
use App\Http\Resources\v1\FilmResource;
use App\Models\Film;
use App\Models\generi;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
                    $film  = Film::all()->take(10);
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
                $img = $request->file('path_img');
                $filename = time().'.'.$img->extension();
                $path = $request->file('path_img')->storeAs('img/',$filename,'public');
                $data['path_img'] = asset('storage/img/'.$filename);
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

    public function UpdateImage($idFilm,FilmUpdateRequest $request){
        $film = Film::where('idFilm',$idFilm)->first();
        if($film->path_img){
            Storage::delete('public/img/'.$film->path_img); 
        }
        $img = $request->file('path_img');
        $filename =time().'.'.$img->extension();
        $path = $request->file('path_img')->storeAs('img/',$filename,'public');    
        $film['path_img'] = "http://localhost/ESAMI/ESAME%20SESSIONE%206%20ACCADEMIA%20CODE%20DI%20SABATINO%20MANUEL/esame_6_CODE/public/storage/img/".$filename;
        $film->save();
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
    public function check(Request $request, $idFilm){
        $film = Film::where('idFilm',$idFilm)->first();
        $img = $film->path_img;
        // Storage::delete('public/img'.$img);
        return asset('storage/img/'.$img);
    }
    

}
