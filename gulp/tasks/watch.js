var gulp = require('gulp'),
    watch = require('gulp-watch'),
    browserSync = require('browser-sync').create(),
    settings = require('../settings');   
    console.log(settings.urlToPreview);
    
    gulp.task('watch', function(done) {
        browserSync.init({
          notify: false,
          proxy: settings.urlToPreview,
          ghostMode: false
        });
      
        gulp.watch(settings.themeLocation + '/*.php', function(){browserSync.reload();});
        gulp.watch(settings.themeLocation + '/css/*.css', function(){browserSync.reload();});
        gulp.watch([settings.themeLocation + '/js/modules/*.js', settings.themeLocation + '/js/*.js'], gulp.series('waitForScripts'));
        done();
    });

    gulp.task('waitForScripts', gulp.series('scripts'), function(done) {
        browserSync.reload();
        done();
    });
