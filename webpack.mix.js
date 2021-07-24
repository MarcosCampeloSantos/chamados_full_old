const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .scripts(['node_modules/jquery/dist/jquery.js','node_modules/bootstrap/dist/js/bootstrap.js'],'public/js/app.js')
    .scripts('resources/js/app.js', 'public/js/app2.js')
    .styles('resources/css/app.css','public/css/app2.css')
    .sass('resources/scss/style.scss', 'public/css/app.css')
    .version();
