var gulp = require('gulp'),
svgSprite = require('gulp-svg-sprite'),
rename = require('gulp-rename'),
del = require('del'),
svg2png = require('gulp-svg2png'),
Project = require('../settings');

var config = {
  shape: {
    spacing: {
      padding: 1 // This will apply a 1 px padding between the icons
    }
  },
  mode: {
    css: {
      variables:{
        replaceSvgWithPng: function(){
          return function(sprite, render){
            return render(sprite).split('.svg').join('.png');
          }
        }
      },
      sprite: 'sprite.svg',
      render: {
        css: {
          template: './gulp/templates/sprite.css'
        }
      }
    },
     symbol:true
  }
}

gulp.task('beginClean', function() {
 return del(['./app/temp/sprite', Project.sprites]);
});

gulp.task('createSprite', ['beginClean'], function() {
  return gulp.src(Project.icons)
    .pipe(svgSprite(config))
    .pipe(gulp.dest('./app/temp/sprite/'));
});

gulp.task('createPngCopy', ['createSprite'], function(){
  return gulp.src('./app/temp/sprite/css/*.svg')
  .pipe(svg2png())
  .pipe(gulp.dest('./app/temp/sprite/css'));
})


gulp.task('copySpriteGraphic', ['createPngCopy'], function() {
  return gulp.src(['./app/temp/sprite/css/**/*.{svg,png}', './app/temp/sprite/symbol/svg/*.svg'])
    .pipe(gulp.dest(Project.sprites));
});

gulp.task('copySpriteCSS', ['createSprite'], function() {
  return gulp.src('./app/temp/sprite/css/*.css')
//    .pipe(rename('_sprite.css'))
    .pipe(gulp.dest(Project.styleModules));
});

gulp.task('endClean', ['copySpriteGraphic', 'copySpriteCSS'], function() {
  return del('./app/temp/sprite');
});

gulp.task('icons', ['beginClean', 'createSprite', 'createPngCopy','copySpriteGraphic', 'copySpriteCSS', 'endClean']);

