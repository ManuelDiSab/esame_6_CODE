<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\EpisodiStoreRequest;
use App\Http\Requests\v1\EpisodiUpdateRequest;
use App\Http\Resources\v1\EpisodiCollection;
use App\Http\Resources\v1\EpisodiResource;
use App\Models\episodi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class episodiController extends Controller
{
     /**
     * Display a listing of the resource.
     * 
     * @return JsonResource
     */
    public function index($idSerie){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                // $resource = episodi::where('idSerie',$idSerie)->get();
                $request = request('stagione');
                if($request){
                    $resource = episodi::all()->where('stagione','=',$request);
                    return new EpisodiCollection($resource);
                }else{
                    $resource = DB::table('episodi')->where('idSerie','=',$idSerie)->get();
                    return new EpisodiCollection($resource);   
                }
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show($idSerie, $episodio)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $resource = episodi::where('idSerie',$idSerie)->where('idEpisodio',$episodio)->first();
                $ep = new EpisodiResource($resource);
                return $ep;
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return JsonResource
     */
    public function store(EpisodiStoreRequest $request){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $data = $request->validated();
                $img = $request->file('path_img');
                $filename = time().'.'.$img->extension();
                $path = $request->file('path_img')->storeAs('imgEpisodi/',$filename,'public');
                $data['path_img'] = $filename;
                $video = $request->file('path_video');
                $filename_video = time().'.'.$video->extension();
                $data['path_video'] = $filename_video;
                $request->file('path_video')->storeAs('videoEp/',$filename,'public');
                $resource = episodi::create($data);
                //Versione con episodio selezionato
                // $new =  new EpisodiResource($resource); 
                // return $new;

                //Versione con gruppo di episodi
                $id = $resource->idSerie;
                return new EpisodiCollection(episodi::all()->where('idSerie',$id));
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
    public function update(EpisodiUpdateRequest $request,episodi $episodio){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $data = $request->validated();
                $episodio -> fill($data);
                $episodio->save();
                $new = new EpisodiResource($episodio); 
                return $data;
                // return response()->json(["risorsa" => $new], 200);  
            }
        }
    }

        /**
     * Funzione per fare un update dell'immagine
     * @param App\Http\Requests\v1\SerieTVUpdateRequest $request
     * @param $idSerie ID della serie
     * @return Array
     */
    public function UpdateImage($idEpisodio,EpisodiUpdateRequest $request){
        $episodio = episodi::where('idEpisodio',$idEpisodio)->first();
        $img_request = $request->file('path_img');
        if($img_request){
            if($episodio->path_img){
                $path_img= $episodio->path_img;
                unlink(storage_path('app/public/imgEpisodi/'.$path_img));
            }
        }
        $img = $request->file('path_img');
        $filename = time().'.'.$img->extension();
        $path = $request->file('path_img')->storeAs('imgEpisodi/',$filename,'public');    
        $episodio['path_img'] = $filename;
        $episodio->save();
        return new EpisodiResource($episodio);
    }

    /**
     * 
     * @param App\Http\Requests\v1\EpisodiUpdateRequest;
     * @param $idEpisodio ID 
     */
    public function UpdateVideo($idEpisodio, EpisodiUpdateRequest $request){
        $episodio = episodi::where('idEpisodio',$idEpisodio)->first();
        $video_request = $request->file('path_video');
        if($video_request){
            if($episodio->path_video){
                $path_video= $episodio->path_video;
                unlink(storage_path('app/public/videoEp/'.$path_video));
            }
        }
        $video = $request->file('path_video');
        $filename_video = time().'.'.$video->extension();
        $path = $request->file('path_video')->storeAs('videoEp/',$filename_video,'public');  
        $episodio['path_video'] = $filename_video;
        $episodio->save();
        return AppHelpers::rispostaCustom($episodio['path_video']);
    }

    /**
     * Elimina una risorsa
     * 
     * @param integer $idSerie 
     * @return 
     */
    public function destroy($idEpisodio){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $Episodio = episodi::findOrFail($idEpisodio);
                $Episodio->delete();
                return response()->json(['message'=>'Episodio eliminato con successo'],204);
            }
        }
    }
}
