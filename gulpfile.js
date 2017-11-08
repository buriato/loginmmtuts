var gulp        = require('gulp');
var browserSync = require('browser-sync').create();


gulp.task('serve', function() {
  browserSync.init({
    proxy: "http://loginmmtuts"
  });
  gulp.watch("**/*.php").on('change', browserSync.reload);
  gulp.watch("css/main.css").on('change', browserSync.reload);
  gulp.watch("js/main.js").on('change', browserSync.reload);
});

gulp.task('default', ['serve']);