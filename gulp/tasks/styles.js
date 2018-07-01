var gulp = require('gulp'),
    Project  = require('../settings'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssvars = require('postcss-simple-vars'),
    nested = require('postcss-nested'),
    cssImport = require('postcss-import'),
    mixins =require('postcss-mixins'),
    hexrgba = require('postcss-hexrgba'),
    colorFunctions = require('postcss-color-function'),
    del = require('del');

gulp.task('processStyles', function(){
//   return  gulp.src(Project.themeLocation + '**/*.css', {base: Project.cssLocation})
   return  gulp.src(Project.cssLocation + '**/*.css')
   .pipe(postcss([cssImport, mixins, cssvars, nested, hexrgba, colorFunctions, autoprefixer]))
   .on('error', function(errorInfo) {
   console.log(errorInfo.toString());
   this.emit('end');
   })
   .pipe(gulp.dest(Project.projectDir + '/temp/')) 
});


gulp.task('moveStyles', ['processStyles'], function() {
 return gulp.src('./app/temp/css/*.css')
  .pipe(gulp.dest('./app/wp-content/themes/resonance_theme/'));
});

gulp.task('rmtemp', function() {
 return del('./app/temp/');
});

gulp.task('styles', ['rmtemp', 'processStyles', 'moveStyles', 'rmtemp']);
