var bower = require('bower');
var concat = require('gulp-concat');
var gulp = require('gulp');
var inject = require('gulp-inject');
var minify = require('gulp-minify');
var minifyCss = require('gulp-minify-css');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var underscore = require('underscore');
var underscoreStr = require('underscore.string');
var uglify = require('gulp-uglify');
var clean = require('gulp-clean');
var gulpsync = require('gulp-sync')(gulp);
var watch = require('gulp-watch');


gulp.task('bower', function (cb) {
  bower.commands.install([], { save: true }, {})
    .on('end', function (installed) {
      cb();
    });
});

gulp.task('ninja-modules-auto-load', ['bower'], function () {
  
  var bowerDir = './bower_components';
  var bowerFile = require('./bower.json');
  var bowerPackages = bowerFile.dependencies;
  var exclude = [];
  var packagesOrder = [];
  var mainFiles = [];

  function addPackage(name) {
    
    var dependencies = require(bowerDir + '/' + name + '/bower.json').dependencies;
    
    if (!!dependencies) {
      underscore.each(dependencies, function (value, key) {
        if (exclude.indexOf(key) === -1) {
          addPackage(key);
        }
      });
    }
    
    if (packagesOrder.indexOf(name) === -1) {
      packagesOrder.push(name);
    }
    
  }

  underscore.each(bowerPackages, function (value, key) {
    if (exclude.indexOf(key) === -1) {
      addPackage(key);
    }
  });

  underscore.each(packagesOrder, function(bowerPackage){
    
    var main = require(bowerDir + '/' + bowerPackage + '/bower.json').main;
    var mainFile = main;

    if (underscore.isArray(main)) {
      underscore.each(main, function (file) {
        if (underscoreStr.endsWith(file, '.js')) {
          mainFile = file;
        }
      });
    }

    mainFile = bowerDir + '/' + bowerPackage + '/' + mainFile;

    if (underscoreStr.endsWith(mainFile, '.js')) {
      mainFiles.push(mainFile);
    }
    
  });

  return gulp.src(mainFiles)
             .pipe(concat('ninja.min.js'))
             .pipe(uglify())
             .pipe(gulp.dest('./dest'));

});

gulp.task('ninja-polyfill', function () {

  return gulp.src(['./bower_components/webcomponentsjs/webcomponents.min.js'])
             .pipe(gulp.dest('./dest/'));

});

gulp.task('ninja-uHealth', function () {

  return gulp.src(['./components/*.js','./controllers/*.js', './modules/*.js', './setups/*.js'])
             .pipe(concat('ninja-uHealth.min.js').on('error', function(){ console.log('error concat js'); concat().end(); gulp.start('watch');}))
             .pipe(uglify().on('error', function(){ console.log('erro uglify js'); uglify().end(); gulp.start('watch');}))
             .pipe(gulp.dest('./dest'));

});

gulp.task('clean', function () {
    return gulp.src('dest', {read: true})
        .pipe(clean().on('error', function(){ console.log('erro clean'); clean().end(); gulp.start('watch');}));
});

gulp.task('ninja-script', function () {

  return gulp.src('./script.txt')
             .pipe(inject(gulp.src(['./dest/ninja.min.js']), {
                starttag: "javascript:(function () {",
                endtag: "}).call({})",
                transform: function (filePath, file) {
                  return file.contents.toString('utf8');
                }
             }))
             .pipe(gulp.dest('./dest'));
  
});

gulp.task('ninja-base-url', function () {

  return gulp.src('./dest/ninja-uHealth.min.js')
             .pipe(inject(gulp.src(['./base_url.json']), {
                starttag: '"<inject:base_url',
                endtag: '>"',
                removeTags: true,
                transform: function (filePath, file) {
                  return '{' + file.contents.toString('utf8').slice(1, -1) + '}';
                }
             }))
             .pipe(gulp.dest('./dest'));
  
});

gulp.task('ninja-git-version-templates', function () {

  return gulp.src('./dest/ninja-uHealth.min.js')
             .pipe(inject(gulp.src(['../githead.json']), {
                starttag: '<git_version',
                endtag: '>',
                removeTags: true,
                transform: function (filePath, file) {
                  json = JSON.parse(file.contents.toString('utf8'));
                  return json.githead;
                }
             }))
             .pipe(gulp.dest('./dest'));
  
});


gulp.task('ninja-smoke-bomb', gulpsync.sync([

  'ninja-modules-auto-load',
  'ninja-uHealth',
  'ninja-polyfill',
  'ninja-script',
  'ninja-base-url',
  //'ninja-git-version-templates',
  'sass',
  'ninja-copy',
  'ninja-copy-images',
  'ninja-move',
  'clean'

]));

gulp.task('ninja-copy', function(){

    gulp.src('./sass/vendors/fonts/font-awesome-4.4.0/fonts/*')
    .pipe(gulp.dest('./dest/fonts'));

    gulp.src('./index.html')
    .pipe(gulp.dest('./dest'));

    gulp.src('./pages/*.html')
    .pipe(gulp.dest('./dest/pages'));


    return gulp.src('./templates/*')
    .pipe(gulp.dest('./dest/templates'));

});

gulp.task('ninja-copy-images', function(){

    return gulp.src('./images/*')
        .pipe(gulp.dest('./dest/images'));

});



gulp.task('ninja-move', function(){

    return gulp.src('./dest/**')
    .pipe(gulp.dest('./../userinterface/www/public/front/'));

});

gulp.task('sass', function() {
    var s = sass();
    return gulp.src('sass/**/*.scss')
        .pipe(s.on('error', function(){ console.log('erro sass'); s.end(); gulp.start('watch'); gulp.start('watch');}))
        .pipe(concat('uhealth.min.css'))
        .pipe(minifyCss().on('error', function(){ console.log('erro minify css'), minifyCss().end(); gulp.start('watch');}))
        .pipe(gulp.dest('dest/css'))
});

gulp.task('watch', function () {
   gulp.watch('./sass/**/*.scss', gulpsync.sync(['sass', 'ninja-copy-images', 'ninja-move']));
   gulp.watch(['./templates/*.html', './pages/*.html'], gulpsync.sync(['ninja-copy', 'ninja-copy-images', 'ninja-move']));
   gulp.watch('./index.html', gulpsync.sync(['ninja-copy', 'ninja-copy-images', 'ninja-move']));
   gulp.watch('./tests/*.html', gulpsync.sync(['ninja-copy', 'ninja-copy-images', 'ninja-move']));
   gulp.watch(['./components/*.js', './controllers/*.js', './modules/*.js', './setups/*.js'], gulpsync.sync(['ninja-uHealth', 'ninja-base-url', 'ninja-git-version-templates', 'ninja-copy-images', 'ninja-move']));
});

gulp.task('default', ['ninja-smoke-bomb']);
gulp.task('css', gulpsync.sync(['ninja-copy-images', 'ninja-copy', 'sass', 'ninja-move']));

