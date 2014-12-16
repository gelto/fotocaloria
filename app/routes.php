<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('uses'=>'InicioController@inicio'));
Route::get('/bienvenido', array('before' => 'logeado', 'uses'=>'InicioController@bienvenido'));

// *********** //
// ** LOGEO ** //
// *********** //

Route::filter('logeado', function()
{
    if ( ! Sentry::check())
    {
        if(isset($_SERVER['REQUEST_URI'])){
            Session::put('redireccion', $_SERVER['REQUEST_URI']);
        }
        
        return Redirect::to('/login');
    }
});

Route::get('/login/{error?}', array('uses'=>'InicioController@login'));
Route::post('/loginback', array('before' => 'csrf', 'uses'=>'InicioController@loginback'));

Route::get('/logout', function()
{
    if ( Sentry::check())
    {
        Sentry::logout();
    }
    
    return Redirect::to('/');
});

Route::post('/registro', array('before' => 'csrf', 'uses' => 'InicioController@registro'));
Route::get('/validacion/{codigo?}', array('uses' => 'InicioController@validacion'));

Route::post('/recuperarback', array('before' => 'csrf', 'uses'=>'InicioController@recuperarback'));
Route::get('/recuperarpassword/{id}/{resetcode}/{error?}', array('uses' => 'InicioController@recuperarpassword'));
Route::post('/finderecuperarpassword', array('before' => 'csrf', 'uses'=>'InicioController@finderecuperarpassword'));



// *************** //
// ** LOGEO FIN ** //
// *************** //
