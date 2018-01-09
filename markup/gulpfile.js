require('events').EventEmitter.prototype._maxListeners = 9999;

/**
 * Settings
 */
var buildDirectory = 'build';
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
var cssmin = require('gulp-cssmin');
var jsmin = require('gulp-jsmin');
var watch = require('gulp-watch');
var fs = require('fs');
var panini = require('panini');
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

    var assetsData = "assets/html/data/assets.json";

    return fs.writeFileSync(assetsData, "{\"version\":\"" + getVersion() + "\"}", 'utf8');

});

gulp.task('default', ['compileHtmlData'], function () {
    gulp.src('assets/html/*.html')
        .pipe(plumber())
        .pipe(panini({
            root: './',
            layouts: 'assets/html/layouts',
            data: 'assets/html/data',
            helpers: 'assets/html/helpers',
            partials: 'assets/html/partials'
        }))
        .pipe(gulp.dest('./'));
});

gulp.task('refresh', ['default'], function () {
    panini.refresh();
});


gulp.task('watch', ['default'], function () {
    gulp.watch([
        mapFile,
        'assets/**/*.js',
        'assets/**/*.json',
        '!assets/**/assets.json',
        'assets/**/*.html',
        'assets/**/*.scss',
        'assets/**/*.css'
    ], ['refresh'])
});





