var gulp = require('gulp'),
    $ = require('gulp-load-plugins')();

var assets = {
    styles: {
        src: [
            'src/FrontBundle/Resources/css/*.css',
            'src/AdminBundle/Resources/css/*.css',
            ],
        vendors: [
            'bower_components/bootstrap/dist/css/bootstrap.css',
        ],
        dest: 'web/css'
    },
    scripts: {
        src: [
            'src/AdminBundle/Resources/js/*.js',
            'src/FrontBundle/Resources/js/*.js'
        ],
        vendors: [
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/bootstrap/dist/js/bootstrap.js',
            'bower_components/tinymce/**/*',
        ],
        dest: 'web/js'
    },
    images: {
        src: [
            'src/AdminBundle/Resources/images/**/*',
            'src/FrontBundle/Resources/images/**/*',
        ],
        dest: 'web/img'
    },
    dest: 'web'
};

gulp.task('build', [
    'copy-vendor-css',
    'copy-vendor-js',
    'scripts',
    'styles',
    'images',
]);

gulp.task('copy-vendor-js', function () {
    gulp.src(assets.scripts.vendors)
        .pipe(gulp.dest(assets.scripts.dest));
});

gulp.task('scripts', function () {
    return gulp.src(assets.scripts.src)
        .pipe($.concat('main.js'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('styles', function () {
    return gulp.src(assets.styles.src)
        .pipe($.concat('main.css'))
        .pipe(gulp.dest('web/css'));
});

gulp.task('copy-vendor-css', function () {
    gulp.src(assets.styles.vendors)
        .pipe(gulp.dest(assets.styles.dest));
});

gulp.task('images', function () {
    return gulp.src(assets.images.src)
        .pipe(gulp.dest(assets.images.dest))
});

gulp.task('watch-scripts', function () {
    gulp.watch(assets.scripts.src, ['scripts']);
});