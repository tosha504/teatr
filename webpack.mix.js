const mix = require('laravel-mix');
const sassFiles = [
  'gutenberg/banner.scss',
  'gutenberg/news.scss',
  'gutenberg/head_block.scss',
  'gutenberg/shows.scss',
  'gutenberg/search.scss',
];

mix.sass('scss/index.scss', 'src')
.options({
  processCssUrls: false,
  postCss: [
    require('autoprefixer')({
      overrideBrowserslist: ['last 2 versions'],
      cascade: false,
    }),
    require('cssnano')({
      preset: 'default',
    }),
  ],
}).webpackConfig({
  module: {
    rules: [
      {
        test: /\.scss/,
        loader: 'import-glob-loader',
      },
    ],
  },
}).babel('src/index.js', 'src/js/index.js')
.browserSync( {
	proxy: "http://teater/",
	files: [
	`**/*.php`,
	`src/*.js`,
	`src/*.css`,
]});
// for Wordpress



sassFiles.forEach(sassFile => {
  mix.sass(sassFile, 'blocks/css');
});