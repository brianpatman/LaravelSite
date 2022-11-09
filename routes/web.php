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
        return redirect("/");
    }

    // Use this for anything under PHP 7.4, which doesn't provide arrow functions
    //
    // $post = cache()->remember("posts.{$slug}",now()->addSeconds(5),function() use ($path){
    //     // var_dump('file_get_contents');
    //     return file_get_contents($path);
    // });

    $post = cache()->remember("posts.{$slug}",now()->addSeconds(5), fn() => file_get_contents($path));

    return view('single-post',[
        'post' => $post
    ]);
})->where('post_name','[A-z_\-]+');