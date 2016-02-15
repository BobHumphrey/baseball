var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    mix.sass([
      'app.scss'
    ], 'resources/assets/css');

    mix.styles([
      'libs/bootstrap-3-3-5.min.css',
      'app.css'
    ]);

    mix.scripts([
      'libs/bootstrap-3-3-5.min.js',
      'app.js'
    ]);

});
