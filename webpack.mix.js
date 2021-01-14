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
    // .js('resources/js/app.js', 'public/js')
    // .js('resources/js/plugins/users_datatable.js', 'public/js/plugins')
    .js('resources/js/plugins/uppy_uploader.js', 'public/js/plugins')
    // .js('resources/js/plugins/enrolment.js', 'public/js/plugins')
   // .sass('resources/sass/app.scss', 'public/css');
