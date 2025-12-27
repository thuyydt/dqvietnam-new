let mix = require('laravel-mix');
const webpack = require('webpack');

mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false,
            __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
        }),
    ],
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */
// mix.autoload({
//     jquery: ['$', 'window.jQuery']
// });

mix.js('public/guide/vue/vue.js', 'public/guide/js').vue();
mix.js('public/game/vue/vue.js', 'public/game/js').vue();
//
mix.combine(
    [
        'public/vendor/jquery-3.3.1.min.js',
        'public/vendor/popper.min.js',
        'public/vendor/bootstrap/bootstrap.min.js',
        'public/vendor/fancyapps/jquery.fancybox.min.js',
        'public/js/main.js',
        'public/js/utils.js',
        'public/js/custom.js',
        'public/js/common.js',
    ],
    'public/js/app.js');

mix.styles(
    [
        'public/vendor/bootstrap/bootstrap.min.css',
        'public/vendor/fancyapps/jquery.fancybox.min.css',
        'public/css/common.css',
    ],
    'public/css/app.css').options({
    processCssUrls: false
}).sourceMaps();

mix.combine(
    [
        'public/vendor/jquery-3.3.1.min.js',
        'public/vendor/toastr/toastr.js',
        'public/vendor/slick.min.js',
        'public/auth/js/main.js',
        'public/js/utils.js',
        'public/js/common.js',
        // 'public/auth/js/custom.js',
    ],
    'public/auth/js/app.js');

mix.styles(
    [
        'public/vendor/toastr/toastr.min.css',
        'public/auth/css/custom.css',
        'public/css/common.css',
    ],
    'public/auth/css/app.css').options({
    processCssUrls: false
}).sourceMaps();

// CSS GUIDE
mix.styles(
    [
        'public/css/common.css',
    ],
    'public/guide/css/app.css').options({
    processCssUrls: false
}).sourceMaps();

// JS GUIDE
mix.combine(
    [
        'public/vendor/jquery-3.3.1.min.js',
        'public/guide/js/main.js',
        'public/js/common.js',
        // 'public/auth/js/custom.js',
    ],
    'public/guide/js/app.js');

// CSS GAME
mix.styles(
    [
        'public/vendor/slick/slick.css',
        'public/game/css/custom.css',
        'public/css/common.css',
    ],
    'public/game/css/app.css').options({
    processCssUrls: false
}).sourceMaps();

// JS GAME
mix.combine(
    [
        'public/vendor/jquery-3.3.1.min.js',
        'public/vendor/slick/slick.min.js',
        'public/game/list/js/chart.js',
        'public/game/js/main.js',
        'public/js/common.js',
    ],
    'public/game/js/app.js');

// CSS LIST GAME
mix.styles(
    [
        'public/vendor/toastr/toastr.min.css',
        'public/vendor/slick/slick.css',
        'public/game/list/css/animate.min.css',
        'public/css/common.css',
    ],
    'public/game/list/css/app.css').options({
    processCssUrls: false
}).sourceMaps();

// JS LIST GAME
mix.combine(
    [
        'public/vendor/jquery-3.3.1.min.js',
        'public/vendor/toastr/toastr.js',
        'public/vendor/slick.min.js',
        'public/game/list/js/chart.js',
        'public/js/utils.js',
        'public/game/list/js/main.js',
        'public/js/common.js',
    ],
    'public/game/list/js/app.js');

// CSS REPORT
mix.styles(
    [
        'public/report/css/main.css',
        'public/css/common.css',
    ],
    'public/report/css/app.css').options({
    processCssUrls: false
}).sourceMaps();

// JS REPORT
mix.combine(
    [
        'public/vendor/jquery-3.3.1.min.js',
        'public/game/list/js/chart.js',
        'public/game/list/js/chart-label.js',
        'public/report/js/custom.js',
        'public/js/common.js',
    ],
    'public/report/js/app.js');

mix.setPublicPath('/');
