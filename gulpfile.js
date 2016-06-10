var gulp = require('gulp'),
  concat = require('gulp-concat'),
  ts = require('gulp-typescript'),
  uglify = require('gulp-uglify'),
  sourcemaps = require('gulp-sourcemaps'),
  zip = require('gulp-zip'),
  sass = require('gulp-sass'),
  minHtml = require('gulp-htmlmin'),
  // compress = require('gulp-compress'),
  manifest= require('./manifest.json');





gulp.task('sass', function(){
  gulp.src(manifest.sass)
  .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
  .pipe(gulp.dest('scripts/css'))
});

gulp.task('compress', ['copylibs', 'sass', 'angular:concatjs',
'angular:minifyhtml'], function(){
  gulp.src(manifest.compress, {base: '.'}).pipe(zip('jump-links-plugin.zip'))
  .pipe(gulp.dest('dist'));
});

gulp.task('angular:concatjs', function(){
  gulp.src(['components/app.js','components/routes.js', 'components/directives.js'])
  .pipe(concat('app.js'))
  //.pipe(uglify())
  .pipe(gulp.dest('./app'));

  gulp.src(['components/controllers/**.js'])
  .pipe(concat('controllers.js'))
//  .pipe(uglify())
  .pipe(gulp.dest('./app'));

  gulp.src(['components/services/**.js'])
  .pipe(concat('services.js'))
  //.pipe(uglify())
  .pipe(gulp.dest('./app'));

});

gulp.task('angular:minifyhtml', function(){
  gulp.src(['components/views/**/*.html'], {base: './components'})
  .pipe(minHtml({collapseWhitespace: true}))
  .pipe(gulp.dest('./app'));
});


gulp.task('watch', function(){
  gulp.watch('components/views/**/*', ['angular:minifyhtml']);
  gulp.watch('scripts/sass/**/*', ['sass']);
  gulp.watch([
    'components/*.js',
    'components/**/*.js'
  ], ['angular:concatjs']);

});


gulp.task('copylibs', function(){
  gulp.src('node_modules/semantic-ui/dist/themes/**/*', {base:'./node_modules/semantic-ui/dist'})
  .pipe(gulp.dest('scripts/css/libs'));

  gulp.src(manifest.copylibs.js)
  .pipe(gulp.dest('scripts/js/libs'));
  gulp.src(manifest.copylibs.css)
  .pipe(gulp.dest('scripts/css/libs'));
});

gulp.task('default', ['copylibs', 'sass']);
