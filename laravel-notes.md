# CONSOLE COMMANDS
"php artisan serve" - start up laravel server


# LARAVEL FUNCTIONS
## Error Handling
+ dd  - Dump and Die
+ ddd - Dump, Die, and Debug

## Other
+ abort($code) - Aborts with a certain response code
+ redirect($route) - Redirects to a certain route

## Path Functions
+ base_path($path='') - Gives you the path to the base of your laravel project; appends $path onto the end
+ app_path($path='') - Gives you the path to the "app" folder of your laravel project; appends $path onto the end
+ resource_path($path='') - Gives you the path to the "resources" folder of your laravel project; appends $path onto the end


# ROUTE WILDCARDS/VARIABLES

##Second argument are variables passed to the view file along with the request

	Route::get('/post',function(){
	    return view('single-post',[
	        'post' => "<h1>Hello World</h1>"
	    ]);
	});


## {$post_name} is a wildcard in Laravel and is passed through the variable $slug

	Route::get('post/{post_name}',function($slug){
	    $path = __DIR__ . "/../resources/posts/{$slug}.html";
	    $post = file_get_contents($path);

	    return view('single-post',[
	        'post' => $post
	    ]);
	});


## WHERE clause
Where clauses are tacked onto the end of routes (->where) to restrict what URLs can access that route
	+ where($regex) - where regex restricts the Route
	+ whereAlpha - where wildcard is only alphabet chracters
	+ whereAlphaNumeric - where wildcard is only alphabet and numeric characteres
	+ whereNumber - where wildcard is only numbers


# YAML Front Matter
## A way to add metadata to straight HTML

### Installation

	composer require spatie/yaml-front-matter

### Use

Add in values to your HTML file between 3 dashes

	---
	title: My First Post
	date: 05/21
	---

	Lorem Ipsum...

Then use your PHP to grab those values

	$object = YamlFrontMatter::parse(file_get_contents(__DIR__."example.html"));

	$object->matter('title');  // My First Post
	$object->body();           // Lorem Ipsum...

	// You can also retrieve a property like so:
	$object->title; // My First Post


# General PHP Notes

## Sweet Shorthand on PHP 7.4 or higher - You can use arrow functions!

	fn() => file_get_contents($path);

	$post = cache()->remember("posts.{$slug}",now()->addSeconds(5), fn() => file_get_contents($path));

Use that instead of:

	function() use $path{
		return file_get_contents($path);
	}

	$post = cache()->remember("posts.{$slug}",5,function() use ($path){
        return file_get_contents($path);
    });

## Array Map

You can use array_map($callback,$array) to return a new array from an existing object.

	array_map(function($file){
		return $file->getContents();
	},$files);