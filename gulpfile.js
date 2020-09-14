let gulp = require('gulp'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    browserSync = require('browser-sync').create(),
    concatCss = require('gulp-concat-css'),
    cleanCSS = require('gulp-clean-css');

const paths = {
  scss: {
    src: 'scss/**/style.scss',
    dest: 'css',
    watch: 'scss/**/*.scss'
  },
  
}

// Compile sass into CSS & auto-inject into browsers
function compile () {
    return gulp.src([paths.scss.src])
    .pipe(sourcemaps.init())//initiate SOURCEMAP FILE
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer({
      overrideBrowserslist: [
            'Chrome >= 35',
            'Firefox >= 38',
            'Edge >= 12',
            'Explorer >= 10',
            'iOS >= 8',
            'Safari >= 8',
            'Android 2.3',
            'Android >= 4',
            'Opera >= 12']
        })]
    ))
    .pipe(cleanCSS({ compatibility: 'ie8' }))
    .pipe(sourcemaps.write('.'))//WRITE THE SOURCE IN CSS
    .pipe(gulp.dest(paths.scss.dest))
    .pipe(browserSync.stream())
    .pipe(browserSync.reload({
        stream: true
    }))
}



// Watching scss files
function watch () {
  gulp.watch([paths.scss.watch], compile)
}

const build = gulp.series(compile,gulp.parallel(watch))

exports.compile = compile

exports.watch = watch

exports.default = build
