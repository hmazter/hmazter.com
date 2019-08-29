let mix = require('laravel-mix');
let build = require('./tasks/build.js');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets');
mix.setResourceRoot('/assets/');
mix.webpackConfig({
    plugins: [
        build.jigsaw,
        build.browserSync(),
        build.watch(['source/**/*.md', 'source/**/*.php', 'source/**/*.scss', 'source/**/*.xml', '!source/**/_tmp/*', 'config.php']),
    ]
});

mix.js('source/_assets/js/main.js', 'js')
    .sass('source/_assets/sass/main.scss', 'css/main.css')
    .version()
    .sourceMaps(false, 'source-map');
