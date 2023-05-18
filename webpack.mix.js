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

mix.styles([
    'public/assets/css/sb-admin-2.css',
    'public/assets/css/custom.css',
    'public/assets/css/select2/select2.css',
    'public/assets/vendor/datatables/dataTables.bootstrap4.css',
], 'public/css/all.css');

mix.scripts([
    'public/assets/index/vendors/jquery/jquery-3.4.1.js',
    'public/assets/index/vendors/bootstrap/bootstrap.bundle.js',
    'public/assets/index/vendors/bootstrap/bootstrap.affix.js',
    'public/assets/index/js/creative-design.js',
], 'public/js/home.js');

mix.minify([
    'public/css/all.css',
    'public/js/home.js'
]);