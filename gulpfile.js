const { src, dest, watch, series, parallel }  = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const plumber = require('gulp-plumber'); //エラー時処理を止めない
const notify = require('gulp-notify'); //エラー通知
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssdeclsort = require('css-declaration-sorter');
const browserSync = require('browser-sync');
const gcmq = require('gulp-group-css-media-queries');
const imagemin = require('gulp-imagemin');
const mode = require('gulp-mode')();
const themeName = "uchino"; // WordPress theme name
const destPath = {
	css: `./${themeName}/css`,
	img: `./${themeName}/img`,
}

const compileSass = (done) => {
  const postcssPlugins = [
    autoprefixer({ cascade: false }),
    cssdeclsort({ order: 'alphabetical' })
  ];
  src('./src/scss/**/*.scss', { sourcemaps: true }) //入力先フォルダ  scssファイルのマップソースを作成
    .pipe(
      plumber({ errorHandler: notify.onError('Error: <%= error.message %>') })//エラー通知を出す処理
    )
    .pipe(sass({ outputStyle: 'expanded'})) //圧縮方式
    .pipe(postcss(postcssPlugins))
    .pipe(mode.production(gcmq()))
    .pipe(dest(destPath.css, { sourcemaps: './sourcemaps' })); //出力先フォルダ
  done();
};

const compressImages = (done) => {
  src('./src/img/**/*.{jpg,jpeg,png,gif,svg,webp}') //入力先フォルダ 画像ファイル
    .pipe(
      plumber({ errorHandler: notify.onError('Error: <%= error.message %>') })//エラー通知を出す処理
    )
    .pipe(imagemin()) // デフォルト設定で圧縮（プラグインなしでも動作）
    .pipe(dest(destPath.img)); //出力先フォルダ（フォルダ構造を維持）
  done();
};

// 自動更新不要ならoff
const buildServer = (done) => {
  browserSync.init({
    port: 5150,
    files: [
      "./**/*.php",
    ],
    proxy: "http://localhost:10015",
    open: false,
    watchOptions: {
      debounceDelay: 800,
    },
  });
  done();
};

const browserReload = done => {
  browserSync.reload();
  done();
};

//scssファイルに変更があったらcompilesassとbrowserreloadを実行
const watchFiles = () => {
  watch( './src/scss/**/*.scss', series(compileSass, browserReload));
  watch( './src/img/**/*.{jpg,jpeg,png,gif,svg,webp}', series(compressImages, browserReload));
};

module.exports = {
  sass: compileSass,
  images: compressImages,
  default: series(parallel(compileSass, compressImages), parallel(buildServer, watchFiles)),
};
