const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir.config.assetsPath = 'src';
elixir.config.publicPath = 'dist';

elixir(function (mix) {

    /*
     |--------------------------------------------------------------------------
     | Build scss files
     |--------------------------------------------------------------------------
     */
    mix.sass('app.scss');

    /*
     |--------------------------------------------------------------------------
     | Build JS files
     |--------------------------------------------------------------------------
     */
   /* mix.webpack('app.js', 'dist/js/app.js');*/

    /*
     |--------------------------------------------------------------------------
     | Copy fonts and other files
     |--------------------------------------------------------------------------
     */
    mix.copy([
        'node_modules/bootstrap-sass/assets/fonts'
    ], 'dist/fonts');

    mix.copy(['src/images'], 'dist/images');
});
