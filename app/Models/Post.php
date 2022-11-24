<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
	public $title;
	public $excerpt;
	public $date;
	public $slug;
	public $body;

	public function __construct($title,$excerpt,$date,$slug,$body)
	{
		$this->title = $title;
		$this->excerpt = $excerpt;
		$this->date = $date;
		$this->slug = $slug;
		$this->body = $body;
	}

	public static function all(){
		$files = File::files(resource_path("posts/"));
	    $posts = [];

	    return cache()->rememberForever('posts.all',function(){
	    	///////////////////////////////////////
		    // USING LARAVEL COLLECTIONS TO LOOP //
		    ///////////////////////////////////////
		    //
		    $posts = collect(File::files(resource_path("posts/")))
		        ->map(fn($f) => YamlFrontMatter::parseFile($f))
		        ->map(fn($doc) => new Post(
		            $doc->title,
		            $doc->excerpt,
		            $doc->date,
		            $doc->slug,
		            $doc->body()
		        ))
		        ->sortByDesc('date');

		    return $posts;
	    });

	    
	    /////////////////////////////
	    // USING ARRAY_MAP TO LOOP //
	    /////////////////////////////
	    //
	    // $posts = array_map(function($f){
	    //     $doc = YamlFrontMatter::parseFile($f);
	    //     return new Post(
	    //         $doc->title,
	    //         $doc->excerpt,
	    //         $doc->date,
	    //         $doc->slug,
	    //         $doc->body()
	    //     );
	    // },$files);

	    ///////////////////////////
	    // USING FOREACH TO LOOP //
	    ///////////////////////////
	    //
	    // foreach($files as $f){
	    //     $doc = YamlFrontMatter::parseFile($f);
	    //     $posts[] = new Post(
	    //         $doc->title,
	    //         $doc->excerpt,
	    //         $doc->date,
	    //         $doc->slug,
	    //         $doc->body()
	    //     );
	    // }
	}

	public static function find($slug){
	    return static::all()->firstWhere('slug',$slug);
	}
}