# CONSOLE COMMANDS
"php artisan serve" - start up laravel server
"php artisan tinker" - start up your laravel app's PHP shell
"php artisan migrate" - Triggers default "migrations" to the current database defined in the .env file; not sure what this is used for so far.


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


## Caching
+ cache->remember($cache_key,$time,$function_to_cache)
	+ Use a now()->addSeconds(5) or other similar function calls to set the time
+ cache->rememberForever($cache_key,$function_to_cache)
+ cache->forget($cache_key)
+ cache('posts.all') or cache->get('posts.all')
+ cache->put('foo','bar')
+ cache(['foo','bar'],now->addSeconds(3))


## Collections
Collections are kind of like Laravel's method of arrays "on steriods". Collections seem to give you some object oriented syntax to do various things on arrays (map them, merge them, filter them, etc...)

You create a collection with the "collect($object)" function, and that underlying collection object has tons of methods that spring off of it.

### Functions
+ firstWhere($key,$value) - grab the first value in the collection with the given key/value pair

### Map Arrays
You can use collections to map arrays through Laravel (like the array_map() function), and even chain the map() calls off of one another. Like so:

	$posts = collect(File::files(resource_path("posts/")))
        ->map(fn($f) => YamlFrontMatter::parseFile($f))
        ->map(fn($doc) => new Post(
            $doc->title,
            $doc->excerpt,
            $doc->date,
            $doc->slug,
            $doc->body()
        ));

### Sort Arrays
You can use collections to also sort by a certain key:

	->sortBy('date')

But it sorts in Ascending order by default, so to sort by Descending:

	->sortByDesc('date')


# ROUTE WILDCARDS/VARIABLES

## The second argument in the view() function is an array of variables passed to the view along with the request

	Route::get('/post',function(){
	    return view('single-post',[
	        'post' => "<h1>Hello World</h1>"
	    ]);
	});

## {post_name} is a wildcard in Laravel and is passed through the variable $slug

	Route::get('post/{post_name}',function($slug){
	    $path = __DIR__ . "/../resources/posts/{$slug}.html";
	    $post = file_get_contents($path);

	    return view('single-post',[
	        'post' => $post
	    ]);
	});


# WHERE clause
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

# Blade Templating Engine Notes
Laravel actually does support general PHP files, and doesn't always need the \*.blade.php files. But the blade templating engine adds in a ton of useful features that can benefit us as we're writing code.

## Where does this get compiled
The blade syntax gets compiled in the end to straight PHP code. You can find the output vanilla PHP files under storage/framework/views in your laravel project

## Output Variables
You can instead of using the general PHP syntax, use a set of double curly braces to output variables. So, instead of this:

	<?= $post->title; ?>

You can use this in Blade:

	{{ $post->title }}

But, this escapes everything, which can be a problem if you have a value that is HTML that you'd rather not be escaped. 

So, for that reason, you use the following syntax. Think of the exclamation points as "Hey, make SURE this data is safe to output!!! Because we're not excaping this data!!!" This might be a problem with user-supplied content, for example:

	{!! $post->body !!}

## Blade Directives
A blade directive is basically a function or loop statement in Blade syntax. Pretty much any common PHP directive has a cooresponding Blade Directive

	@foreach ($posts as $p)
		{{ $p->title }}
	@endforeach

Or you can use functions like dd!

	@foreach($posts as $p)
		@dd($loop)
	@endforeach

Also, there's an "@unless" directive, which is essentially the opposite of "@if". "Unless this is true, do this"

Also, loops have the following properties built into an automatically assigned "$loop" element:
+ iteration
+ index
+ remaining
+ count
+ first
+ last
+ odd
+ even
+ depth
+ parent


## Layout Files
Layout files are basically Laravel's version of PHP's include/require, but way more powerful. Whereas PHP might have a header and footer file for you to separately include, Laravel's layout file basically just will allow you to define places for content that each main view can define.

Now, there are two ways to do this; template files and blade components. Neither is better than the other, though! They are both valid ways to achieve this task! There is no better or worse option here.

When you use blade components, you're thinking your way top down, while template files are thinking from the bottom up.

### Template Files
This is just another blade file within the views directory; perhaps named something like "layout.blade.php". Then, you use @yield to show where the main view's content will be embedded.

+ @extends($layout_file) - When included in a blade file, this signals that this blade file extends off of that layout file; so it just defines the sections that the layout file @yields
+ @yield($section_name) - This is the place where a blade file that extends this blade file will insert a section with the given section name
+ @section($section_name)/@endsection - This creates a section that will be put into place where the @yield directive is.

### Blade Components
A blade component, at the simplest level, allows you to wrap some HTML. But they have a lot more powerful features.

Create a directory named "components" within your "resources/views" directory. Then, any blade files in this folder will automatically be available as blade components.

Instead of using @yield, just use the blade syntax for outputting variables 

	{{ $content }}

And, instead of using an @extends and @section variables, you just create a html tag that is the name of your component, preceded by "x-". So, in this case, a layout.blade.php file in your /components directory would be called by another blade file via something like this:

	<x-layout></x-layout>

To pass in variables, you can use attributes on this:

	<x-layout content="hello there!"></x-layout>

Or you can use a slot syntax

	<x-layout>
		<x-slot name="content">
			Hello again!
		</x-slot>
	</x-layout>

But you can also do a default slot, which is just HTML right within the component element

	<x-layout>
		<article class="main-article">
			<h1>My blog</h1>
			...
	</x-layout>

This slot will be referred to with the $slot variable. So you will just define this in the component itself like so:

	<body>
		{{ $slot }}
	</body>


# .ENV file
This file is a place to put application secrets or other config dtails, and exists in the root of your project. This file is by default included in .gitignore, and each variable can be called from the .env file by using the following function

	env("DB_CONNECTION",'mysql')

Where the first argument is the key the function is looking for, and the second argument is a fallback argument if that variable isn't specified in the .env file.

The variables contained in this file will never be exposed to the outside world, so this is the best place to put keys or secrets that shouldn't be publicly available


# Migrations
Migrations are essentially ways for your application to define the database structure of your tables. The migrations are kept in the /database/migrations directory and laravel, by default, comes with 4 migrations.

If you look into these files, you'll see an "up()" method and a "down()" method. "up()" is what is called when the migration is executed, while "down()" is called when the migration is rolled back or the table is dropped.

You can set your database to run these migrations with the command "php artisan migrate".

Roll back a migration with "php artisan migrate:rollback"

Get yourself a clean start; all tables but zero data inside of them with "php artisan migrate:fresh". NEVER USE THIS ON PRODUCTION!!!!

This stuff probably makes it really easy to setup a laravel local environment. Or, in the case of production environments, perhaps a system that uses the same code for all sites but those sites are branded differently. 



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

You can use array_map($callback,$array) to return a new array from an existing object. Good to use whenever you are using a loop on an array/object to build a new array/object.

	array_map(function($file){
		return $file->getContents();
	},$files);