<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\MusicStyle;

class AddingMusicStyle extends Migration
{

    private $style_list = array(
        'Alternative',
        'Classical',
        'Anime',
        'Blues',
        'Children’s Music',
        'Comedy',
        'Country',
        'Dance',
        'Hip-hop/Rap',
        'Disney',
        'Easy listening',
        'Holiday',
        'Electronic',
        'Enka',
        'French pop',
        'Fitness & workout',
        'Indie',
        'Industrial',
        'Pop'
    );
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->style_list as $style){
            $Music_style = new MusicStyle;
            $Music_style->name = $style;
            $Music_style->save();
        }
        
        // DB::table('music_styles')->insert(['name' => 'country',   'created_at' => $dt->format('m-d-y H:i:s'), 'updated_at' => $dt->format('m-d-y H:i:s')]);
//        DB::table('music_styles')->insert([
//        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('music_styles')->delete();
    }
}
