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
Route::get('/',               function(){ return redirect()->route('suggest'); });
Route::get('/musics',         ['as' => 'musics',          'middleware' => 'auth', 'uses' => 'MusicController@index']);
Route::get('/musics/{id}',    ['as' => 'musics.edit',          'middleware' => 'auth', 'uses' => 'MusicController@edit']);

Route::get('/music/suggest',  ['as' => 'suggest',         'middleware' => 'auth', 'uses' => 'MusicController@suggest']);

Route::post('/music/suggest', ['as' => 'save-suggestion', 'middleware' => 'auth', 'uses' => 'MusicController@store']);
Route::post('/music/edit/{id}', ['as' => 'edit-suggestion', 'middleware' => 'auth', 'uses' => 'MusicController@update']);
Route::post('/accept-song',   ['as' => 'accept-song',     'middleware' => 'auth', 'uses' => 'MusicController@accept_songs']);

Route::get("/CreateDefaultCredential", function(){
    return User::create([
           'firstname' => 'Pier-Luc',
           'lastname' => 'audet',
           'username' => 'poudigne',
           'country' => 'Canada',
           'city' => 'Montréal',
           'age' => 27,
           'sexe' => 'm',
           'email' => 'pierluc@organicradio.com',
           'password' => bcrypt('admin321')
       ]);
});
//login 
Route::get('/auth/login',   ['as' => 'get-login',  'uses' => 'Auth\AuthController@getLogin']);
Route::post('/auth/login',  ['as' => 'post-login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('/auth/logout',  ['as' => 'logout',     'uses' => function(){ if (Auth::check()) { Auth::logout(); return redirect()->route('suggest'); }  }]);




//register
// Route::get('/auth/register', 'Auth\AuthController@getRegister');
// Route::post('/auth/register', 'Auth\AuthController@postRegister');