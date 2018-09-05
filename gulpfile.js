var gulp = require('gulp');
var concat = require('gulp-concat');
var cleanCSS = require('gulp-clean-css');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');

/***** CONFIG PARAMS *****/
var config = {
    scss_to_compile : [
        'frontend/web/css/**/*.scss',
        'frontend/core/widgets/langswitcher/css/switcher-widget.scss'
    ]
};

/***** COMPILE FRONT CSS *****/
gulp.task('build-frontend-css', function() {
    return gulp.src(config.scss_to_compile)
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(function(file){
            return file.base;
        }));
});

/***** DEFAULT *****/
gulp.task('default', [
    'build-frontend-css'
]);

/***** WATCH *****/
gulp.task('watch', function () {
    gulp.watch(config.scss_to_compile , ['build-frontend-css']);
});
