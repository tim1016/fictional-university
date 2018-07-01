var gulp = require('gulp'),
    imagemin = require('gulp-imagemin'),
    del = require('del'),
    usemin = require('gulp-usemin'),
    rev = require('gulp-rev'), 
    cssnano = require('gulp-cssnano'),
        browserSync = require('browser-sync').create(),
    uglify = require('gulp-uglify');


gulp.task('previewDist', function(){
     browserSync.init({
      server: {
      baseDir: "docs"}
   });
});

gulp.task('deleteDistFolder', function(){
  return del("./docs");
})

gulp.task('copyGeneralFiles', ['deleteDistFolder'], function(){
  var pathsToCopy = [
    './app/**/*',
    '!./app/index.html',
    '!./app/assets/images/**',
    '!./app/assets/styles/**',
    '!./app/assets/scripts/**',
    '!./app/temp/',
    '!./app/temp/**'
  ]
  return gulp.src(pathsToCopy)
  .pipe(gulp.dest("./docs"));
})

gulp.task('optimizeImages', ['deleteDistFolder', 'icons'], function(){
  return gulp.src([
    './app/assets/images/**/*',
    '!./app/assets/images/icons', 
    '!./app/assets/images/icons/**/*'
  ])
  .pipe(imagemin({
    pregressive:true, //improves jpg compression
    interlaced: true, //improves gif compression
    multipass: true // help with svg files
  }))
  .pipe(gulp.dest('./docs/assets/images'));
});

gulp.task('usemin',['deleteDistFolder', 'styles', 'scripts'] ,function(){
  return gulp.src('./app/index.html')
  .pipe(usemin({
    css: [function(){return rev()},function(){return cssnano()}],
    js: [function(){return rev()}, function(){return uglify()}]
  }))
  .pipe(gulp.dest("./docs"));
})

gulp.task('build', ['deleteDistFolder', 'copyGeneralFiles','optimizeImages', 'usemin']);
