/*
1. Поставить NODE.JS и NPM
2. Выполнить npm install
3. Запустить gulp
*/

const {src, dest, parallel, series, watch} = require('gulp');

//css
const sass = require('gulp-sass')(require('sass')),
  cleanCSS = require('gulp-clean-css'),
  //sourcemaps = require('gulp-sourcemaps'),
  postcss = require('gulp-postcss'),
  mqpacker = require('css-mqpacker'),
  autoprefixer = require('autoprefixer'),

  //js
  concat = require('gulp-concat'),
  //uglify = require('gulp-uglify'),
  uglify = require('gulp-uglify-es').default,
  //babel = require('gulp-babel'),
  webpack = require('webpack-stream'),

  //common
  rename = require("gulp-rename"),
  ftp = require('vinyl-ftp'),
  sftp = require('gulp-sftp-up4'),
  chalk = require('chalk'),
  log = require('fancy-log'),
  colors = require('ansi-colors'),
  notify = require('gulp-notify'),


  //img compress
  // image = require('gulp-image'),
  // imagemin = require('gulp-imagemin'),
  //cache = require('gulp-cache'),
  newer = require('gulp-newer'),
  tinypng = require('gulp-tinypng'),


  //png sprite
  spritesmith = require('gulp.spritesmith'),
  merge = require('merge-stream'),


  //svg sprite
  svgstore = require('gulp-svgstore'),
  svgo = require('gulp-svgo'),
  svgmin = require('gulp-svgmin'),
  path = require('path'),


  //fonts
  ttf2woff = require('gulp-ttf2woff'),
  ttf2woff2 = require('gulp-ttf2woff2')
;

//sass.compiler = require('sass'); //Dart Sass
//
// const
//   // host = '',
//   // user = '',
//   // pass = '',
//   // port = '21';

//FTP
// const conn = ftp.create({
//   // host: host,
//   // user: user,
//   // password: pass,
//   //secure: true,
//   //reload: true,
//   //parallel: 10,
//   //idleTimeout: 1200000,
//   //log: log
// });


const
  themeFolder = 'wp-content/themes/bov/',
  //ftpSubFolder = 'http/';
  ftpSubFolder = '/';

const
  themeDeployPath = '/' + ftpSubFolder + themeFolder,
  cssDeployPath = themeDeployPath + 'css/',
  jsDeployPath = themeDeployPath + 'js/dist/';


function startWatch() {

  watch(themeFolder + 'scss/**/*.scss', styles);


  // Наблюдение за sass файлом типографики для TinyMCE  админке
  watch(themeFolder + 'scss/global/editor-style.scss', editorStyle);
  watch(themeFolder + 'scss/global/_typography.scss', editorStyle);

  // Наблюдение за js файлами
  watch(themeFolder + 'js/src/**/*.js', js);
  //gulp.watch(themeFolder + 'js/dist/all-plugins.min.js', gulp.parallel('js'));

  //Сжатие изображений
  watch(themeFolder + 'img/decor/src/**/*', tinyImg);

  //Наблюдение за svg иконками для спрайта
  watch(themeFolder + 'img/svg-sprite/*.svg', svgSprite);

  //Наблюдение за контентными СВГ (будут загружатся как изображения через
  // админку)
  watch(themeFolder + 'img/svg/src/**/*.svg',optimizeSvg);

  //Наблюдение за png иконками для спрайта
  watch(themeFolder + 'img/png-sprite/*.png', pngSprite);
}


function styles() {
  let sftpConn = sftpPath(cssDeployPath);

  return src(themeFolder + 'scss/styles.scss')
    .pipe(sass.sync()) // sync is 2x faster (check this on local)
    .on('error', catchErr)
    .pipe(postcss([
      autoprefixer({grid: true}),
      mqpacker({sort: true})
    ]))
    .pipe(cleanCSS({level: 2}))
    .pipe(rename("styles.min.css"))
    .pipe(dest(themeFolder + 'css'))
    // .pipe(conn.dest(cssDeployPath))
    //.pipe(sftp(sftpConn))
}


function editorStyle() {
  let sftpConn = sftpPath(themeDeployPath);

  return src(themeFolder + 'scss/global/editor-style.scss')
    .pipe(sass.sync())
    .on('error', catchErr)
    .pipe(postcss([autoprefixer()]))
    .pipe(cleanCSS())
    .pipe(rename("editor-style.css"))
    .pipe(dest(themeFolder))
    // .pipe(conn.dest(themeDeployPath))
    //.pipe(sftp(sftpConn))
}


function js() {
  let sftpConn = sftpPath(jsDeployPath);

  return src([
    themeFolder + 'js/src/main.js',
  ])
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(rename("app.min.js"))
    //.pipe(uglify()) see "mode" in webpack config
    .pipe(dest(themeFolder + 'js/dist'))
    // .pipe(conn.dest(jsDeployPath))
    //.pipe(sftp(sftpConn))
    .on('end', function () {
      log(colors.bold(colors.green('all.js uploaded!')));
    });
}

//Запускать вручную в превый раз когда создал проект, и потом каждый раз
// когда добавляешь новый плагин
function jsPlugins() {
  let sftpConn = sftpPath(jsDeployPath);

  return src([
    //'node_modules/jquery/dist/jquery.min.js',
    'node_modules/lazysizes/lazysizes.js',
    'node_modules/lazysizes/plugins/unveilhooks/ls.unveilhooks.js', //data-bg + .lazyload class
    //'node_modules/fontfaceobserver/fontfaceobserver.js',
    'node_modules/d_js/d.js',
    'node_modules/swiper/swiper-bundle.min.js',
    //'node_modules/jquery.maskedinput/dist/jquery.maskedinput.min.js',
    'node_modules/vanilla-text-mask/dist/vanillaTextMask.js',
    //'node_modules/rellax/rellax.js',
    //'node_modules/aos/dist/aos.js',
    //'node_modules/infinite-scroll/dist/infinite-scroll.pkgd.js',
    //'node_modules/perfect-scrollbar/js/perfect-scrollbar.min.js',
    //'node_modules/lity/dist/lity.min.js',

    'node_modules/vanilla-modal/dist/index.js',
    //'node_modules/lightgallery/dist/js/lightgallery.min.js',
    //themeFolder + 'js/src/jquery.form-validator/jquery.form-validator.min.js',
  ])
    .pipe(concat('plugins.min.js'))
    .pipe(uglify())
    .on('error', function (err) {
      log.error(colors.red(err.toString()));
      notify('Error in task "js-plugins"');
      this.emit('end');
    })
    .pipe(dest(themeFolder + 'js/dist'))
    // .pipe(conn.dest(jsDeployPath))
    //.pipe(sftp(sftpConn))
    .on('end', function () {
      log(colors.bold(colors.green('js plugins compiled and uploaded')));
    });
}


//Склейка свг спрайта
function svgSprite() {
  let sftpConn = sftpPath(themeDeployPath + 'img/');

  return src(themeFolder + 'img/svg-sprite/*.svg')
    .pipe(svgo(
      {
        plugins: [
          {
            removeViewBox: false
          },
          {
            removeAttrs: {
              "attrs": "*:(stroke|fill):((?!^currentColor$).)*"
            }
          }
        ]
      }
    ))
    .pipe(svgstore())
    .pipe(dest(themeFolder + 'img/'))
    // .pipe(conn.dest(themeDeployPath + 'img/'))
     //.pipe(sftp(sftpConn));
}

function optimizeSvg() {
  let sftpConn = sftpPath(themeDeployPath + 'img/svg/dist');

  return src(themeFolder + 'img/svg/src/**/*.svg')
  .pipe(newer(themeFolder + 'img/svg/dist/'))
    .pipe(svgo({
      js2svg: {
        indent: 2,
        pretty: true
      },
      plugins: [
        {
          removeViewBox: false
        },
        {
          cleanupIDs: {
            remove: true,
            minify: true,
            force: true
          },
        }
      ]
    }))
    .pipe(dest(themeFolder + 'img/svg/dist'))
    // .pipe(conn.dest(themeDeployPath + 'img/svg/dist'));
      //.pipe(sftp(sftpConn));
}

function tinyImg() {
  let sftpConn = sftpPath(themeDeployPath + 'img/decor/dist');

  return src([
    themeFolder + 'img/decor/src/**/*.jpg',
    themeFolder + 'img/decor/src/**/*.jpeg',
    themeFolder + 'img/decor/src/**/*.png'])
    .pipe(newer(themeFolder + 'img/decor/dist/')) //path to dist to compare
    .pipe(tinypng('GjTWchAWTWfsBDKInE72m1wI30RyYebI'))
    .pipe(dest(themeFolder + 'img/decor/dist/'))
    // .pipe(conn.dest(themeDeployPath + 'img/decor/dist'));
    //.pipe(sftp(sftpConn));
}

function ttfToWoff() {
  let sftpConn = sftpPath( themeDeployPath + 'fonts/');

  return src([themeFolder + 'fonts/*.ttf'])
    .pipe(ttf2woff())
    .pipe(dest(themeFolder + 'fonts/'))
    // .pipe(conn.dest(themeDeployPath + 'fonts/'));
    //.pipe(sftp(sftpConn));
}

function ttfToWoff2() {
  sftpConn.remotePath = themeDeployPath + 'fonts/';

  return src([themeFolder + 'fonts/*.ttf'])
    .pipe(ttf2woff2())
    .pipe(dest(themeFolder + 'fonts/'))
    // .pipe(conn.dest(themeDeployPath + 'fonts/'));
      //.pipe(sftp(sftpConn));
}

//Склейка пнг спрайта
function pngSprite() {
  let sftpConn = sftpPath(themeDeployPath + 'img/');

  // Generate our spritesheet
  let spriteData = src(themeFolder + 'img/png-sprite/*.png').pipe(spritesmith({
    imgName: 'sprite.png',
    cssName: '_sprite.scss',
    imgPath: '/' + themeFolder + 'img/sprite.png'
  }));

  // Pipe image stream through image optimizer and onto disk
  let imgStream = spriteData.img
    .pipe(dest(themeFolder + 'img/'))
    // .pipe(conn.dest(themeDeployPath + 'img/'));
     //.pipe(sftp(sftpConn));

  // Pipe CSS stream through CSS optimizer and onto disk
  let cssStream = spriteData.css
    .pipe(dest(themeFolder + 'scss/common/'))
    // .pipe(conn.dest(themeDeployPath + 'scss/common/'));

  // Return a merged stream to handle both `end` events
  return merge(imgStream, cssStream);
}


function catchErr(e) {
  notify('Error in task ' + e.messageFormatted);
  log(colors.red(e.messageFormatted));
  this.emit('end');
}

//SFTP
function sftpPath(path){
  return {
    // host: host,
    // user: user,
    // pass: pass,
    // port: port,
    // remotePath: path
  }
}

// gulp.task('img-compress', function () {
//   return gulp.src([themeFolder + 'img/src/**/*.jpg',
//     themeFolder + 'img/src/**/*.jpeg',
//     themeFolder + 'img/src/**/*.png'])
//     .pipe(cache(imagemin([
//         imagemin.gifsicle({interlaced: true}),
//         imagemin.jpegtran({progressive: true}),
//         imagemin.optipng({optimizationLevel: 7})
//       ],
//       {
//         verbose: true
//       })
//     ))
//     .pipe(gulp.dest(themeFolder + 'img/dist/compressed'));
// });

exports.styles = styles;
exports.editorStyle = editorStyle;

exports.js = js;
exports.jsPlugins = jsPlugins;

exports.svgSprite = svgSprite;
exports.optimizeSvg = optimizeSvg;

exports.tinyImg = tinyImg;
exports.pngSprite = pngSprite;
exports.ttfToWoff = ttfToWoff;
exports.ttfToWoff2 = ttfToWoff2;

exports.default = parallel(startWatch);
exports._compileAll = parallel(styles, editorStyle,
  js, jsPlugins,
  svgSprite, optimizeSvg,
  tinyImg);