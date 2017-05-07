var buildDirectory = 'inc/build';
var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var replace = require('gulp-replace');
var clean = require('gulp-clean');
var mergeStream = require('merge-stream');
var stream = require('stream');
var tap = require('gulp-tap');
var concat = require('gulp-concat');
var less = require('gulp-less');
var cssmin = require('gulp-cssmin');
var gulpIf = require('gulp-if');
var jsmin = require('gulp-jsmin');
var coffee = require('gulp-coffee');
var watch = require('gulp-watch');
var path = require('path');
var pumpify = require('pumpify');
var order = require('gulp-order');
var typescript = require('gulp-typescript');
var fs = require('fs');
var streamqueue = require('streamqueue');
var extReplace = require('gulp-ext-replace');
var autoprefixer = require('gulp-autoprefixer');

function getMapFile() {
    return 'gulp.map.json';
}

function getMap() {
    return JSON.parse(fs.readFileSync(getMapFile(), 'utf-8'))
}

function getVersionFileName() {
    return "version.txt";
}

function getVersion() {
    return fs.readFileSync(getVersionFileName(), 'utf-8');
}

function say(text) {
    console.log(text);
}

gulp.task('default', ['clearAfter'], function () {
    console.log('Compiled!');
});

gulp.task('clearAfter', ['compile'], function () {

});

gulp.task('compile', ['updateVersion'], function () {

    var sourceMap = getMap();

    for (var outputFileName in sourceMap) {

        var outputStream = streamqueue({objectMode: true});

        for (var partFile in sourceMap[outputFileName]) {
            outputStream.queue(gulp.src(sourceMap[outputFileName][partFile], {buffer: true})
                    //SWALLOW ERRORs
                    .pipe(plumber())
                    //JS
                    .pipe(gulpIf(['*.js', '!*.min.js'], jsmin())) //minify js
                    // Coffee
                    .pipe(gulpIf(['*.coffee'], coffee())) //compile coffee
                    .pipe(gulpIf(['*.coffee'], jsmin())) //minify coffee
                    //SASS
                    .pipe(gulpIf(['*.sass', '*.scss'], sass())) //compile sass
                    .pipe(gulpIf(['*.sass', '*.scss'], autoprefixer({
                        browsers: ['last 2 versions'],
                        cascade: false
                    }))) //autoprefixer
                    .pipe(gulpIf(['*.sass', '*.scss'], cssmin())) //minify sass
                    //LESS
                    .pipe(gulpIf(['*.less'], less())) //compile less
                    .pipe(gulpIf(['*.less'], autoprefixer({
                        browsers: ['last 2 versions'],
                        cascade: false
                    }))) //autoprefixer
                    .pipe(gulpIf(['*.less'], cssmin())) //minify less
                    //CSS
                    .pipe(gulpIf(['*.css', '!*.min.css'], autoprefixer({
                        browsers: ['last 2 versions'],
                        cascade: false
                    }))) //autoprefixer
                    .pipe(gulpIf(['*.css', '!*.min.css'], cssmin())) //minify css
            );
        }

        outputStream.done()
            .pipe(plumber())
            .pipe(concat(outputFileName.replace('--version--', getVersion())))
            .pipe(gulp.dest(buildDirectory));
    }

});

gulp.task('updateVersion', ['clearBefore'], function () {
    return fs.writeFileSync(getVersionFileName(), Math.floor(Date.now() / 1000), 'utf8');
});

gulp.task('clearBefore', function () {
    if (fs.existsSync(buildDirectory)) {
        return gulp.src([buildDirectory + '/**.js', buildDirectory + '/**.css'])
            .pipe(plumber())
            .pipe(clean());
    }
    return false;
});

gulp.task('watch', ['default'], function () {

    var watches = [
        "gulp.map.json",
        "inc/assets/**",
        "inc/system/**",
        "inc/images/**"
    ];

    gulp.watch(watches, ['default']);
});
