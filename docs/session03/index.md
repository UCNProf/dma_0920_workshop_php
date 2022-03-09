---
title: Session03
layout: default
---

## Resources

- [Laravel docs](https://laravel.com/docs/9.x)
- [PHP Laravel Project Example for Beginners](https://phppot.com/php/php-laravel-project-example/) (the tutorial is fine, but does not use Docker, so skip to step 2)

## Exercises

The objective with the following exercises is to get experience with Laravel. After installing the framework you will create a simple setup for a todo list with a model, database table, controller and a view.

A prerequesit is that you already have Docker and WSL up and running. Help and more documentation can be found at [Laravel docs](https://laravel.com/docs/9.x).

Before installing Laravel
:   Before we get started read the section [Getting started on Windows](https://laravel.com/docs/9.x/installation#getting-started-on-windows). Don't execute the install script yet, but try to open a terminal and start the WSL session: Write `wsl` and hit enter. Can you execute the command `$ curl`?

Installing a Laravel example app using Docker (and Sail)
:   Go further down on the install page: [Choosing your sail services](https://laravel.com/docs/9.x/installation#choosing-your-sail-services) and read the section.

    1. Open up a terminal and start the WSL session.
    2. Move to the directory where you would like the project to be stored.
    3. We just need to install Laravel with MySql, so execute the command:
        ```
        $ curl -s "https://laravel.build/example-app?with=mysql" | bash
        ```

Configur a bash alias
:   The installation (example app) includes all the tools necessary for setting up and running Laravel. In the section [Configuring A Bash Alias](https://laravel.com/docs/9.x/sail#configuring-a-bash-alias) it explains how to configure a bash alias. This only works for the current session in bash, to make the alias permanent add the alias code to the file `~/.bashrc`:

    1. Open the file in nano: `nano ~/.bashrc`.
    2. move to the last line in the file and paste/write the alias code:
        ```
        alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
        ```
    3. Ctrl+o to save, Ctrl+x to exit.

Start and stop the project
:   Now you should be able to start and stop the project using sail (almost just like you do with docker-compose):
    
    - Start in detached mode: `$ sail up -d`
    - Stop: `$ sail down`

Create a new model
:   Create a model and a migration file for a todo list.

    1. Run `$ sail php artisan make:model Todo --migration`.
    2. Open the new migration file and alter the `up()` function:

        ```
        public function up()
        {
          Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->date('due_at');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
          });
        }
        ```
    3. Run `$ sail php artisan migrate` to update the database with the new changes.

Seed the database with todo items
:   Create a Seeder class and add it to the DatabaseSeeder file:

    1. Run `$ sail php artisan make:seeder TodoSeeder`.
    2. Open `/database/seeders/TodoSeeder.php` and alter the `run()` function:

        ```
        public function run()
        {
          Todo::create([
            'title' => 'Item 1',
            'description' => 'Description for item 1',
            'due_at' => '2022-03-06'
          ]);

          Todo::create([
            'title' => 'Item 2',
            'description' => 'Description for item 2',
            'due_at' => '2022-03-06'
          ]);
        }
        ```
    3. Open `/database/seeders/DatabaseSeeder.php` and alter the `up()` function:

        ```
        public function run()
        {
          $this->call([
            TodoSeeder::class,
          ]);
        }
        ```
    4. Run `$ sail php artisan db:seed` to seed the database.

    If something goes wrong the the above, run `php artisan migrate:refresh --seed` to remove all the tables, add them again and seed the database.

Create a controller
:   Create a controller (with resources) and route requests. See the table in [Controllers - Laravel](https://laravel.com/docs/9.x/controllers#actions-handled-by-resource-controller) -- this is the structure of any request mapped to the different functions that you find in the controller.

    1. Run `$ sail php artisan make:controller TodoController --resource`.
    2. Open `/routes/web.php` and add:

        ```
        use App\Http\Controllers\TodoController;

        Route::resource('todos', TodoController::class);
        ```
    3. Open `/Http/Controllers/TodoController.php` and add the type in the top of the file:
        ```
        use App\Models\Todo;
        ```
        and alter the `index()` function:
        ```
        public function index()
        {
            $todos = Todo::all();
            return view('todos/index', ['todos' => $todos]);
        }
        ```

        and the `show()` function:

        ```
        public function show($id)
        {
            $item = Todo::find($id);
            return view('todos/show', ['item' => $item]);
        }
        ```        

Create two views
:   In the above exercise we refer to two different views; `todos/index` and `todos/show`.

    1. In the directory `/resources/views/`, create a directory `todos` and two views in that directory (`index.blade.php` and `show.blade.php`).
    2. In the directory `/resources/views/` create a file `app.blade.php`.
    3. Add the following to the `app.blade.php` view file:
        ```
        <!DOCTYPE html>
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Todo - @yield('title')</title>
          </head>
          <body>
            <nav></nav>
            <main>
              @yield('content')
            </main>
          </body>
        </html>
        ```
    4. Add the following to the `todos/index.blade.php` view file:
        ```
        @extends('app') @section('content')
          <ul>
            @foreach ($todos as $item)
              <li>{{ $item->title }}</li>
            @endforeach
          </ul>
        ```
    3. Test in the browser to see you you get a list of todo items (`http://localhost/todos`).
    4. Write your own `show.blade.php` view file.
    5. Alter the `todos` view file so that it links to the `todo` route (`http://localhost/todos/[id]`).