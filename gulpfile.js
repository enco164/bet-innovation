/**
 * Created by enco on 27.7.16..
 */
var gulp = require('gulp');
var less = require('gulp-less');

var lessPath = './src/less/style.less';

gulp.task('less', function() {
    return gulp.src(lessPath)
        .pipe(less())
        .pipe(gulp.dest('./public/content/styles'));
});

gulp.task('watch-less', ['less'], function() {
    gulp.watch('./src/less/**/*.less', ['less']);
});