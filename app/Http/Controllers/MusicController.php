<?php

namespace App\Http\Controllers;

use App\Music;
use App\MusicStyle;
use App\UploadedFile;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $music = new Music;
        $musics = $music
            ->select('musics.title', 'musics.is_accepted', 'musics.band','musics.id','musics.style_id', 'musics.reason','musics.path')
            ->where('musics.is_accepted', null)
            ->get();
        $music_style = new MusicStyle;
        return view('musics')->with('musics', $musics)->with('music_style', $music_style->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $music_style = new MusicStyle;
        return view('suggestmusic')->with('music_style', $music_style->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('song_file');
        $music_style = new MusicStyle;
        
        if ($file->isValid()) 
        {
            if ($file->getClientOriginalExtension() != "mp3"){
                return redirect()->route('suggest')->with('error', "Bad file extension!");
            }
                // return view('suggestmusic')->with('error', "Bad file extension!")->with('music_style', $music_style->get());
            if (file_exists("medias/" . $file->getClientOriginalName()))
            {
                return redirect()->route('suggest')->with('error', "File already uploaded!");
            }
            $file->move("medias/", $file->getClientOriginalName());     
            $music = new Music;
            $music->title = $request->get('song_title');
            $music->band = $request->get('band_name');
            $music->style_id = $request->get('music_style');
            $music->user_id = Auth::id();
            $music->path = $file->getClientOriginalName();
            $music->save();
            return redirect()->route('suggest')->with('error', "success");
            // return view('suggestmusic')->with('error', 0)->with('music_style', $music_style->get());
        }
        return redirect()->route('suggest')->with('error', "Unknown error");
        // return Route::get('suggest')view('suggestmusic')->with('error', "Unknown error")->with('music_style', $music_style->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $music = new Product;
        Product::find($id)->delete();
        $musics = $music
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.title', 'products.description', 'products.price','products.id','categories.name')
        ->get();
        $music_style = new Category;
        $music_styles = $category->get();
        return view('products')->with('products', $musics)->with('categories', $music_styles)->with('deleted', 1);
    }
    
    
    public function suggest()
    {
        $music_style = new MusicStyle;
        $music_styles = $music_style->get();
        return view('suggestmusic')->with('music_style', $music_styles);
        
    }
    
    public function accept_songs(Request $request){
        
        foreach($request->music as $test){
            // dd($test);
            $music = new Music;
            $db_music = $music->find($test['id']);
            $db_music->style_id = $test['style'];
            $db_music->is_accepted = $test['is_accepted'];
            $db_music->reason = $test['reason'];
            $db_music->save();
        }
    }
}
