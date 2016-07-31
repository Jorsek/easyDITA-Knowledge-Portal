var gulp          = require('gulp');
var source        = require('vinyl-source-stream');
var buffer        = require('vinyl-buffer');
var ftp           = require('vinyl-ftp');
var gutil         = require('gulp-util');
var sourcemaps    = require('gulp-sourcemaps');
var sass          = require('gulp-sass');
var cleanCSS      = require('gulp-clean-css');
var autoprefixer  = require('gulp-autoprefixer');

var globs = [
  'sass/**',
  'js/**',
  'inc/**',
  'skins/**',
  'template-parts/**',
  './*.php',
  'style.css'
];


// ////////////////////////////////////////////////
// Styles Tasks
// ///////////////////////////////////////////////

gulp.task('styles', function() {
  gulp.src('sass/style.scss')
    .pipe(sourcemaps.init())
      .pipe(sass())
      // .on('error', errorlog)
      .on('error', gutil.log.bind(gutil, gutil.colors.red(
         '\n\n*********************************** \n' +
        'SASS ERROR:' +
        '\n*********************************** \n\n'
        )))
      .pipe(autoprefixer({
              browsers: ['last 3 versions'],
              cascade: false
          }))
    .pipe(sourcemaps.write('../maps'))
    .pipe(gulp.dest('./css/'));
});


// ////////////////////////////////////////////////
// Minifiy Tasks
// ///////////////////////////////////////////////

gulp.task('minify-css', function() {
  return gulp.src('./css/style.css')
    .pipe(cleanCSS({compatibility: 'ie8'}))
    .pipe(gulp.dest('./'));
});


// ////////////////////////////////////////////////
// FTP Tasks
// ////////////////////////////////////////////////

gulp.task( 'deploy', function () {
 
    var conn = ftp.create( {
        host:     'documentation.easydita.com',
        user:     'demo-docs@documentation.easydita.com',
        password: 'docstesting2015!',
        parallel: 10,
        log:      gutil.log
    } );
 
    // using base = '.' will transfer everything to /public_html correctly 
    // turn off buffering in gulp.src for best performance 
 
    return gulp.src( globs, { base: '.', buffer: false } )
        .pipe( conn.newer( '/wp-content/themes/easydita-knowledge-portal' ) ) // only upload newer files 
        .pipe( conn.dest( '/wp-content/themes/easydita-knowledge-portal' ) );
 
} );


// ////////////////////////////////////////////////
// Watch Tasks
// ////////////////////////////////////////////////

gulp.task('watch', function() {
  gulp.watch('sass/**/*.scss', ['styles']);
  gulp.watch(globs, ['deploy']);
});


gulp.task('default', ['styles', 'minify-css', 'deploy', 'watch']);
