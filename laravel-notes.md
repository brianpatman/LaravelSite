# CONSOLE COMMANDS
	"php artisan serve" - start up laravel server


# LARAVEL FUNCTIONS
	## Error Handling
		+ dd  - Dump and Die
		+ ddd - Dump, Die, and Debug
	## Other
		+ abort($code) - Aborts with a certain response code
		+ redirect($route) - Redirects to a certain route


# ROUTE WILDCARDS/VARIABLES

	##Second argument are variables passed to the view file along with the request

	```Route::get('/post',function(){
	    return view('single-post',[
	        'post' => "<h1>Hello World</h1>"
	    ]);
	});```


	## {$post_name} is a wildcard in Laravel and is passed through the variable $slug

	```Route::get('post/{post_name}',function($slug){
	    $path = __DIR__ . "/../resources/posts/{$slug}.html";
	    $post = file_get_contents($path);

	    return view('single-post',[
	        'post' => $post
	    ]);
	});```


	## WHERE clause
	Where clauses are tacked onto the end of routes (->where) to restrict what URLs can access that route
		+ where($regex) - where regex restricts the Route
		+ whereAlpha - where wildcard is only alphabet chracters
		+ whereAlphaNumeric - where wildcard is only alphabet and numeric characteres
		+ whereNumber - where wildcard is only numbers


# SWEET SHORTHAND

	## PHP 7.4 or higher - You can use arrow functions!

		```fn() => file_get_contents($path);```

		```$post = cache()->remember("posts.{$slug}",now()->addSeconds(5), fn() => file_get_contents($path));```


		Use that instead of:

		```function() use $path{
			return file_get_contents($path);
		}```

		```$post = cache()->remember("posts.{$slug}",5,function() use ($path){
	        return file_get_contents($path);
	    });```