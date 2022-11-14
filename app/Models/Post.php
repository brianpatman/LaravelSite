<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\File;

class Post
{
	public static function all(){
		$files = File::files(resource_path("posts/"));

		// return array_map(function($file){
		// 	return $file->getContents();
		// }, $files);

		return array_map(fn($file) => $file->getContents(),$files);
	}

	public static function find($slug){
		// $path = __DIR__ . "/../resources/posts/{$slug}.html";
		$path = resource_path("posts/{$slug}.html");

		 if(!file_exists($path)){
	        // return redirect("/");
	        throw new ModelNotFoundException();
	    }

	    // // Use this for anything under PHP 7.4, which doesn't provide arrow functions
	    // //
	    // // $post = cache()->remember("posts.{$slug}",now()->addSeconds(5),function() use ($path){
	    // //     // var_dump('file_get_contents');
	    // //     return file_get_contents($path);
	    // // });


	    $post = cache()->remember("posts.{$slug}",now()->addSeconds(5), fn() => file_get_contents($path));
	    return $post;
	}
}