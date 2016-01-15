<?php

namespace App\Http\Controllers;

use App\Music;
use App\MusicStyle;
use App\UploadedFile;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

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
            ->select('musics.title', 'musics.is_accepted', 'musics.band','musics.id','musics.style_id', 'musics.reason')
            ->get();
        return view('musics')->with('musics', $musics);
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
        // if ($file->isValid()) {
        //     if ($file->getClientOriginalExtension() != "*.mp3")
        //         return view('suggestmusic')->with('success', "Bad file extension!")->with('MusicStyle', $music_style->get());
        //     
            $music = new Music;
            $music->title = $request->get('song_title');
            $music->band = $request->get('band_name');
            $music->style_id = $request->get('music_style');
            $music->user_id = Auth::id();
            $music_style = new MusicStyle;
            
            
            // $music->addMedia($file)->toCollection('images');
            $music->save();
            return view('suggestmusic')->with('success', 0)->with('MusicStyle', $music_style->get());
        // }
        // return view('suggestmusic')->with('success', "Unknown error")->with('MusicStyle', $music_style->get());
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
}
