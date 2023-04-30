const mix = require('laravel-mix');
// mix.setPublicPath('public/assets');
// mix.setResourceRoot('../../');
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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css')
//     .sourceMaps();

mix
    .js([
        'resources/js/app.js',
        // 'public/assets/js/app.js',
        // 'public/fontawesome/js/brands.min.js',
        // 'public/fontawesome/js/solid.min.js',
        // 'public/fontawesome/js/fontawesome.min.js',
        // 'public/assets/js/pages/horizontal-layout.js',
        // 'public/assets/js/pages/dashboard.js',
        // 'public/assets/extensions/choices.js/public/assets/scripts/choices.min.js',
        // 'public/select2/dist/js/select2.min.js',
        // 'public/assets/js/pages/form-element-select.js',
        // 'public/js/jquery.number.js',
        // 'public/assets/extensions/toastify-js/src/toastify.js'
    ], 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();


mix.autoload({
    jquery: ['$', 'window.$', 'window.jQuery', 'jQuery']
});
