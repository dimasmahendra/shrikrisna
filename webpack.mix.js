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
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

mix.sass('resources/cms/scss/app.scss', 'public/cms/css')
    .sass('resources/cms/scss/pages/auth.scss', 'public/cms/css/pages')
    .sass('resources/cms/scss/pages/error.scss', 'public/cms/css/pages')
    .sass('resources/cms/scss/pages/email.scss', 'public/cms/css/pages')
    .sass('resources/cms/scss/pages/chat.scss', 'public/cms/css/pages')
    .sass('resources/cms/scss/widgets/chat.scss', 'public/cms/css/widgets')
    .sass('resources/cms/scss/widgets/todo.scss', 'public/cms/css/widgets')
    .options({
        processCssUrls: false
    });