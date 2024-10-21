const gulp = require('gulp');
const sass = require('gulp-dart-sass');
const cleanCSS = require('gulp-clean-css');

gulp.task('sass', function() {
    return gulp.src('styles/**/*.scss')
               .pipe(sass().on('error', sass.logError))
               .pipe(cleanCSS({
                   compatibility: 'ie8',
                   level: {
                       1: {
                           specialComments: 0
                       },
                   },
               }))
               .pipe(gulp.dest('styles'));
});

gulp.task('watch', function() {
    gulp.watch('styles/**/*.scss', gulp.series('sass'));
});
