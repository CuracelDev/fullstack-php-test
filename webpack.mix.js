const mix = require('laravel-mix');
const path = require('path')
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

mix.js('resources/js/app.js', 'public/js').vue()
    .sass('resources/sass/app.scss', 'public/css')
    .version();

// mix.webpackConfig({
//     plugins: [
//         // new BundleAnalyzerPlugin()
//     ],
//     resolve: {
//         extensions: ['.js', '.json', '.vue'],
//         alias: {
//             '~': path.join(__dirname, './resources/js')
//         }
//     },
//     output: {
//         chunkFilename: 'dist/js/[chunkhash].js',
//         path: mix.config.hmr
//             ? '/'
//             : path.resolve(__dirname, mix.inProduction() ? './public/build' : './public')
//     }
// })
