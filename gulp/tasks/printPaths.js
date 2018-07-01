var gulp = require('gulp'),
    Project = require("../settings");


gulp.task('printPaths', function(done){
    console.log('Project.rootFolder  ' + Project.rootFolder)  ;
    console.log('Project.projectDir  '+ Project.projectDir);
    console.log('Project.wpContent  '  + Project.wpContent) ;
    console.log('Project.themeLocation  '+ Project.themeLocation) ;
    console.log('Project.urlToPreview  '+ Project.urlToPreview) ;
    console.log('Project.cssLocation  '+Project.cssLocation);
    console.log('Project.styleModules  '+ Project.styleModules);
    console.log('Project.baseStyles' + Project.baseStyles);
    console.log('Project.images  '+ Project.images);
    console.log('Project.icons  '+ Project.icons);
    console.log('Project.finalStyleSheet  '+ Project.finalStyleSheet);
    done();
});
