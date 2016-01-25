<?php
use App\User;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//home 
//Route::get('/home', 'HomeController@index');
//Route::get('/home/{id}', 'HomeController@show');

Route::get('/phpinfo', function() { phpinfo(); });

// Musics
Route::get('/', ['middleware' => 'auth', 'uses' => 'MusicController@suggest']);
Route::get('/musics', ['middleware' => 'auth', 'uses' => 'MusicController@index']);
Route::get('/music/suggest', ['middleware' => 'auth', 'uses' => 'MusicController@suggest']);

Route::post('/save-suggestion', ['middleware' => 'auth', 'uses' => 'MusicController@store']);
Route::post('/accept-song', ['middleware' => 'auth', 'uses' => 'MusicController@accept_songs']);

Route::get("/CreateDefaultCredential", function(){
    return User::create([
           'firstname' => 'Pier-Luc',
           'lastname' => 'audet',
           'username' => 'poudigne',
           'country' => 'Canada',
           'city' => 'Montréal',
           'age' => 27,
           'sexe' => 'm',
           'email' => 'shenrok@lcdj.com',
           'password' => bcrypt('test123')
       ]);
});
//login 
Route::get('/auth/login','Auth\AuthController@getLogin');
Route::post('/auth/login','Auth\AuthController@postLogin');




//register
// Route::get('/auth/register', 'Auth\AuthController@getRegister');
// Route::post('/auth/register', 'Auth\AuthController@postRegister');