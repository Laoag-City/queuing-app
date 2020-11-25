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

mix.js('resources/js/app.js', 'public/js')
	.styles(['resources/css/globals.css'], 'public/css/globals.css')
	.babel(['resources/js/custom/tablesort.js'], 'public/js/tablesort.js')
	.babel(['resources/js/custom/window.js'], 'public/js/window.js')
	.babel(['resources/js/custom/client.js'], 'public/js/client.js')
	.version();
