<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\SerieTVStoreRequest;
use App\Http\Requests\v1\SerieTVUpdateRequest;
use App\Http\Resources\v1\SerieTvCollection;
use App\Http\Resources\v1\SerieTvResource;
use App\Models\serieTv;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class serieTvController extends Controller
{
 /**
     * Display a listing of the resource.
     * 
     * @return JsonResource
     */
    public function index(){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $resource = serieTv::all();
                $serie = new SerieTvCollection($resource);
                return $serie;
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show($serie)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $resource = serieTv::where('idSerie',$serie)
                ->get()
                ->first();
                if($resource){
                    return new SerieTvResource($resource);  
                }else{
                    return response()->json(['message' => 'SerieTv non trovata'], 404);
                }
            }
        }
    }
    public function seriePerGenere($genere){
        $resource = serieTv::where('idGenere',$genere)->get();
        if($resource){
            return $resource;
        }else{
            return response('Nessun genere trovato', 404);
        }
    }   


    /**
     * Funzione per la ricerca delle serie tv attraverso il titolo
     */
    public function ricerca()
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $titolo = request('titolo');
                if($titolo){
                        $serie = serieTv::where('titolo','like',"{$titolo}%")
                        ->get();
                        return new SerieTvCollection($serie);
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
    public function store(SerieTVStoreRequest $request){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $data = $request->validated();
                $img = $request->file('path');
                $filename = time().'.'.$img->extension();
                $path = $request->file('path')->storeAs('img/',$filename,'public');
                $data['path'] = $filename;
                $resource = SerieTV::create($data);
                $new =  new SerieTvResource($resource);
                return response()->json(["nuova risorsa"=> $new],201);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param $idSerie 
     * @return JsonResource
     */
    public function update(SerieTVUpdateRequest $request, serieTv $serie){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $data = $request->validated();
                $serie -> fill($data);
                $serie->save();
                return new SerieTvResource($serie); 
            }
        }
    }

    /**
     * Funzione per fare un update dell'immagine
     * @param App\Http\Requests\v1\SerieTVUpdateRequest $request
     * @param $idSerie ID della serie
     * @return Array
     */
    public function UpdateImage($idSerie,SerieTVUpdateRequest $request){
        $serie = serieTv::where('idSerie',$idSerie)->first();
        if($request->file('path')){
            if($serie->path){
                $path_img= $serie->path;
                unlink(storage_path('app/public/img/'.$path_img));
            }
        }
        $img = $request->file('path');
        $filename =time().'.'.$img->extension();
        $path = $request->file('path')->storeAs('img/',$filename,'public');    
        $serie['path'] = $filename;
        $serie->save();
        return new SerieTvResource($serie);
    }

    /**
     * Elimina una risorsa
     * 
     * @param integer $idSerie 
     * @return 
     */
    public function destroy($idSerie){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $serie = serieTv::findOrFail($idSerie);
                $serie->delete();
                return response()->json(['message'=>'serie eliminata con successo'],204);
            }
        }
    }

}
