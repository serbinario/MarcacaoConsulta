var gulp = require('gulp');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var cleanCss = require('gulp-clean-css');

var scripts = [
    'public/lib/jquery/dist/jquery.js',
    'public/lib/bootstrap/dist/js/bootstrap.min.js',
    'public/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
    'public/lib/Waves/dist/waves.min.js',
    'public/dist/jquery.datetimepicker.js',
    'public/lib/sweetalert2/dist/sweetalert2.min.js',
    'public/lib/datatables.net/js/jquery.dataTables.min.js',
    'public/lib/jquery-validation/dist/jquery.validate.js',
    'public/lib/jquery-validation/src/additional/cpfBR.js',
    'public/dist/js/adicional/unique.js',
    'public/dist/js/fileinput/fileinput.min.js',
    'public/dist/js/krajee/js/fileinput.js',
    'public/dist/js/krajee/js/locales/pt-BR.js',
    'public/lib/jquery-mask-plugin/dist/jquery.mask.js',
    'public/lib/select2/dist/js/select2.full.js',
    'public/js/bootstrapvalidator.js',
    'public/js/zabuto_calendar.min.js',
    'public/lib/moment/min/moment.min.js',
    'public/lib/fullcalendar/dist/fullcalendar.js',
    'public/lib/fullcalendar/dist/locale/pt-br.js',
    'public/lib/jquery-placeholder/jquery.placeholder.min.js',
    'public/dist/js/app.js',
    'public/lib/chosen/chosen.jquery.js',
    'public/js/jasny-bootstrap.js',
    'public/js/jquery.mask.js',
    'public/js/mascaras.js',
    'public/js/laroute.js',
    'public/js/plugins/highcharts.js',
    'public/js/plugins/exporting.js',
];

var styles = [
    'public/dist/css/btnLoadind.css',
    'public/lib/animate.css/animate.min.css',
    'public/lib/sweetalert2/dist/sweetalert2.min.css',
    'public/lib/material-design-iconic-font/dist/css/material-design-iconic-font.min.css',
    'public/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css',
    'public/lib/datatables.net-dt/css/jquery.dataTables.min.css',
    'public/dist/css/datetimepicker/build/jquery.datetimepicker.min.css',
    'public/dist/js/krajee/css/fileinput.css',
    'public/lib/select2/dist/css/select2.css',
    'public/css/zabuto_calendar.min.css',
    'public/lib/fullcalendar/dist/fullcalendar.css',
    'public/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css',
    'public/dist/css/load.css',
    'public/lib/chosen/chosen.css',
    'public/lib/summernote/dist/summernote.css',
    'public/dist/css/app_1.min.css',
    'public/dist/css/app_2.min.css',
    'public/dist/css/demo.css'
];

gulp.task('default', ['js', 'css']);

gulp.task('js', function () {
    return gulp.src(scripts)
        .pipe(concat('prod.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/'));
});

gulp.task('css', function () {
    return gulp.src(styles)
        .pipe(concat('prod.min.css'))
        .pipe(cleanCss())
        .pipe(gulp.dest('public/'))
});