const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .copy('resources/css', 'public/css')
  .copy('resources/images', 'public/images');

mix.styles([
  'resources/vendor/bootstrap/css/bootstrap.css',
  'resources/vendor/animate/animate.css',
  'resources/vendor/font-awesome/css/font-awesome.css',
  'resources/vendor/dataTables/datatables.css',
], 'public/css/vendor.css', './');

mix.scripts([
    'resources/vendor/jquery/jquery-3.1.1.min.js',
    'resources/vendor/bootstrap/js/bootstrap.js',
    'resources/vendor/metisMenu/jquery.metisMenu.js',
    'resources/vendor/dataTables/datatables.js',
    'resources/vendor/slimscroll/jquery.slimscroll.min.js',
    'resources/vendor/pace/pace.min.js',
    'resources/js/app.js'
  ], 'public/js/app.js', './');