<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('posts');
});


Route::get('posts/{post_name}',function($slug){
    $path = __DIR__ . "/../resources/posts/{$slug}.html";

    if(!file_exists($path)){
        // ddd("File Does Not Exist");
        abort(404);
    }

    $post = file_get_contents($path);

    return view('single-post',[
        'post' => $post
    ]);
});