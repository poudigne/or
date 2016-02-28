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
        return view('musics')->with('musics', $musics)->with('music_style', $music_style->orderBy('name')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $music_style = new MusicStyle;
        return view('suggestmusic')->with('music_style', $music_style->orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestedSong = $this->GetUploadSongData($request->get('song_title'), $request->get('band_name'));
        $returnMsg = "";
        if ($requestedSong != null && $requestedSong->is_accepted == 1){
            $returnMsg = "Congratulation, you've picked a song that has been approved already by Organic Radio";
            return redirect()->route('suggest')->with('success', $returnMsg);
        }
        else if ($requestedSong != null && $requestedSong->is_accepted == 0){
            $returnMsg = "Song already suggested but got rejected";
            return redirect()->route('suggest')->with('error', $returnMsg);
        }else if ($requestedSong != null && $requestedSong->is_accepted == null){
            $returnMsg = "Song already suggested but is pending acceptance";
            return redirect()->route('suggest')->with('error', $returnMsg);
        }


        if ($request->file('song_file') != null)
            $file = $request->file('song_file');
        $music_style = new MusicStyle;
        $musicPath = "";
        if (isset($file) && $file->isValid()) {
            if ($file->getClientOriginalExtension() != "mp3") {
                return redirect()->route('suggest')->with('error', "Bad file extension!");
            }
            if (file_exists("medias/" . $file->getClientOriginalName())) {
                return redirect()->route('suggest')->with('error', "File already exist.");
            }
            $musicPath = $file->getClientOriginalName();
            $file->move("medias/", $file->getClientOriginalName());
        }
        $music = new Music;
        $music->title = $request->get('song_title');
        $music->band = $request->get('band_name');
        $music->style_id = $request->get('music_style') != "" ? $request->get('music_style') : null ;
        $music->user_id = Auth::id();
        $music->path = $musicPath;

        $music->save();
        return redirect()->route('suggest')->with('success', "success");
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
        $music = Music::where('id',$id)->first();
        return view('editsuggestmusic')->with('music_style', MusicStyle::get())->with("music", $music);
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
        if ($request->file('song_file') != null)
            $file = $request->file('song_file');
        $music_style = new MusicStyle;
        $musicPath = "";
        if (isset($file) && $file->isValid()) {
            if ($file->getClientOriginalExtension() != "mp3") {
                return redirect()->route('suggest')->with('error', "Bad file extension!");
            }
            $musicPath = $file->getClientOriginalName();
            $file->move("medias/", $file->getClientOriginalName());
        }
        $music = Music::find($id);
        $music->title = $request->get('song_title');
        $music->band = $request->get('band_name');
        $music->style_id = $request->get('music_style') != "" ? $request->get('music_style') : null ;
        $music->user_id = Auth::id();
        $music->path = $musicPath;

        $music->save();
        return redirect()->route('musics.edit', $id)->with('success', "success");
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
        $music_style = new Musicstyle;
        $music_styles = $music_style->orderBy('name')->get();
        return view('products')->with('products', $musics)->with('categories', $music_styles)->with('deleted', 1);
    }
    
    
    public function suggest()
    {
        $music_style = new MusicStyle;
        $music_styles = $music_style->orderBy('name')->get();
        return view('suggestmusic')->with('music_style', $music_styles);
        
    }
    
    public function accept_songs(Request $request){
        $arr = array();

        foreach($request->music as $test){
            $music = new Music;
            $db_music = $music->find($test['id']);
            $db_music->style_id = $test['style'] != "" ? $test['style'] : null;
            $db_music->is_accepted = $test['is_accepted'];
            $db_music->reason = $test['reason'];
            $db_music->save();
            $arr[] = $test['id'];
        }

        return json_encode($arr);
    }

    private function GetUploadSongData($title, $band)
    {
        $song = Music::where('title','like','%'.$title.'%')->where('band','like','%'.$band.'%')->first();
        return $song;
    }
}
