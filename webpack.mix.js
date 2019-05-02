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
  .copy('resources/images', 'public/images')
  .copy('resources/vendor/font-awesome/fonts', 'public/fonts')
;

mix.styles([
  'resources/vendor/bootstrap/css/bootstrap.min.css',
  'resources/css/style.css',
  'resources/vendor/animate/animate.css',
  'resources/vendor/datepicker/datepicker3.css',
  'resources/vendor/font-awesome/css/font-awesome.css',
  'resources/vendor/dataTables/datatables.css',
  'resources/vendor/select2/select2.min.css',
  'resources/vendor/toastr/toastr.min.css',
  'resources/vendor/dropzone/dropzone.css',
  'resources/vendor/dropzone/basic.css',
  'resources/vendor/touchspin/jquery.bootstrap-touchspin.min.css',
], 'public/css/vendor.css', './');

mix.scripts([
    'resources/vendor/jquery/jquery-3.1.1.min.js',
    'resources/js/popper.min.js',
    'resources/js/bootstrap.min.js',
    'resources/vendor/metisMenu/jquery.metisMenu.js',
    'resources/vendor/dataTables/datatables.js',
    'resources/vendor/slimscroll/jquery.slimscroll.min.js',
    'resources/vendor/datepicker/bootstrap-datepicker.js',
    'resources/vendor/select2/select2.full.min.js',
    'resources/vendor/toastr/toastr.min.js',
    'resources/vendor/pace/pace.min.js',
    'resources/vendor/dropzone/dropzone.js',
    'resources/vendor/touchspin/jquery.bootstrap-touchspin.min.js',
    'resources/js/inspinia.js'
  ], 'public/js/app.js', './');