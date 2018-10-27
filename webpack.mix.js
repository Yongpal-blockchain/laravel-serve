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

mix.browserSync({
    proxy: {
      // artisan serve시의 주소
      target: 'localhost:8000',
      reqHeaders: function() {
        // host를 직접 지정해준다.
        return {
          host: 'localhost:3000'
        };
      }
    }
  });
  