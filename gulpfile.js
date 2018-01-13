require('events').EventEmitter.prototype._maxListeners = 9999;

/**
 * Settings
 */
var buildDirectory = 'public/build';
var mapFile = 'gulpfile.map.json';
var versionFile = 'gulpfile.version.txt';

/**
 * Script
 */

var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var streamqueue = require('streamqueue');
var clean = require('gulp-clean');
var concat = require('gulp-concat');
var gulpIf = require('gulp-if');
var watch = require('gulp-watch');
var fs = require('fs');
var autoprefixer = require('gulp-autoprefixer');

function getMap() {
    return JSON.parse(fs.readFileSync(mapFile, 'utf-8'))
}

function getVersion() {
    return fs.readFileSync(versionFile, 'utf-8');
}

gulp.task('clean', function () {
    if (fs.existsSync(buildDirectory)) {
        return gulp.src([buildDirectory + '/*.*'])
            .pipe(plumber())
            .pipe(clean());
    }

    return false;
});

gulp.task('updateVersion', ['clean'], function () {
    return fs.writeFileSync(versionFile, Math.floor(Date.now() / 1000), 'utf8');
});

gulp.task('compile', ['updateVersion'], function () {

    var sourceMap = getMap();

    for (var outputFileName in sourceMap) {

        var outputStream = streamqueue({objectMode: true});

        for (var partFile in sourceMap[outputFileName]) {
            outputStream.queue(gulp.src(sourceMap[outputFileName][partFile], {buffer: true})
                    .pipe(plumber())
                    // .pipe(gulpIf(['*.js', '!*.min.js'], jsmin()))
                    .pipe(gulpIf(['*.sass', '*.scss'], sass()))
                    .pipe(gulpIf(['*.sass', '*.scss'], autoprefixer({browsers: ['last 2 versions'], cascade: false})))
                    // .pipe(gulpIf(['*.sass', '*.scss'], cssmin()))
                    .pipe(gulpIf(['*.css', '!*.min.css'], autoprefixer({browsers: ['last 2 versions'], cascade: false})))
                // .pipe(gulpIf(['*.css', '!*.min.css'], cssmin()))
            );
        }

        outputStream.done()
            .pipe(plumber())
            .pipe(concat(outputFileName.replace('--version--', getVersion())))
            .pipe(gulp.dest(buildDirectory));
    }
});

gulp.task('compileHtmlData', ['compile'], function () {

});

gulp.task('default', ['compileHtmlData'], function () {

});

gulp.task('refresh', ['default'], function () {

});


gulp.task('watch', ['default'], function () {
    gulp.watch([
        mapFile,
        'resources/assets/**/*.js',
        'resources/assets/**/*.json',
        '!resources/assets/**/assets.json',
        'resources/assets/**/*.html',
        'resources/assets/**/*.scss',
        'resources/assets/**/*.css'
    ], ['refresh'])
});





