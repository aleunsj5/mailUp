<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use App\Models\Photo;
use Carbon\Carbon;

class PhotoController extends Controller
{
    public function index(){
        try{
            $countInserts=0;
            $response = Http::get('http://jsonplaceholder.typicode.com/photos');
            
            if($response->failed()){
                $response = Http::retry(5,100)->get('https://jsonplaceholder.typicode.com/photos');
            }

            $cantRegistros = count($response->json());
            if($response->failed() || !$response->successful() || count($response->json())==0){
                return response('Not connected with external api',500);
            }else{
                $photosInBD = Photo::limit(10)->get();
                
                if(count($photosInBD)==0){
                    if(Arr::accessible($response->json())){
                    
                        foreach ($response->json() as $key=>$value) {
                            $photo= new Photo;
        
                            $photo->albumId = $value['albumId'];
                            $photo->title=$value['title'];
                            $photo->url=$value['url'];
                            $photo->thumbnailUrl=$value['thumbnailUrl'];
                            $photo->created_at=Carbon::now();
        
                            if($photo->save()){
                                $countInserts++;
                            }
                        }
        
                        if($countInserts>0){
                            return response('Of '.$cantRegistros.' records '.$countInserts.' were inserted');
                        }else{
                            return response('Error inserting data',500);
                        }
                    }else{
                        return response('Does not have access to the data',403);
                    }
                }else{
                    return response('The table already contains records',204);
                }
                
            }
        }catch(Exception $e){
            return response($e,500);
        }
        
    }
}
