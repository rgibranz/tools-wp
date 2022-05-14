var gulp = require('gulp');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var minify = require('gulp-minify');
var cleanCSS = require('gulp-clean-css');

async function cssTask() {
    gulp.src([
        // data tables
        'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        'plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
        // sweet alert
        'plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
        // toastr
        'plugins/toastr/toastr.min.css',
        // daterange picker
        'plugins/daterangepicker/daterangepicker.css',
        // icheck for checkboxes and radio inputs
        'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        // bootstrap colorpicker
        'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
        // tempusdominus bootstrap
        'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        // select 2
        'plugins/select2/css/select2.min.css',
        'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
        // bootstrap dual list box
        'plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css',
        // bs stepper
        'plugins/bs-stepper/css/bs-stepper.min.css',
        // dropzone js
        'plugins/dropzone/min/dropzone.min.css',
        // chart js
        'plugins/chart.js/chart.min.css',
        // theme style
        'dist/css/adminlte.min.css',
    ]).pipe(concat('app.css')).pipe(cleanCSS({ compatibility: 'ie8' })).pipe(sourcemaps.write()).pipe(gulp.dest('dist'));
}

async function jsTask() {
    gulp.src([
        // jQuery
        'plugins/jquery/jquery.min.js',
        // bootstrap 4
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
        // 'datatables & plugins'
        "plugins/datatables/jquery.dataTables.min.js",
        "plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
        "plugins/datatables-responsive/js/dataTables.responsive.min.js",
        "plugins/datatables-responsive/js/responsive.bootstrap4.min.js",
        "plugins/datatables-buttons/js/dataTables.buttons.min.js",
        "plugins/datatables-buttons/js/buttons.bootstrap4.min.js",
        "plugins/jszip/jszip.min.js",
        "plugins/pdfmake/pdfmake.min.js",
        "plugins/pdfmake/vfs_fonts.js",
        "plugins/datatables-buttons/js/buttons.html5.min.js",
        "plugins/datatables-buttons/js/buttons.print.min.js",
        "plugins/datatables-buttons/js/buttons.colVis.min.js",
        // sweeralert 2
        'plugins/sweetalert2/sweetalert2.min.js',
        // toastr
        'plugins/toastr/toastr.min.js',
        // select 2
        'plugins/select2/js/select2.full.min.js',
        // bootstrap4-duallistbox
        'plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js',
        // inputmask
        "plugins/moment/moment.min.js",
        'plugins/inputmask/jquery.inputmask.min.js',
        // daterangepicker	
        'plugins/daterangepicker/daterangepicker.js',
        // bootstrap colorpicker
        'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js',
        // tempusdominus bootstrap
        'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
        // bootstrap-switch
        'plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        // bs-stepper
        'plugins/bs-stepper/js/bs-stepper.min.js',
        // dropzone js
        'plugins/dropzone/min/dropzone.min.js',
        // chartjs
        'plugins/chart.js/Chart.bundle.min.js',
        'plugins/d3/*.js',
        // admin js
        'dist/js/adminlte.min.js',
    ]).pipe(concat('app.js')).pipe(minify()).pipe(gulp.dest('dist'));

    gulp.src('dist/app.js')
        .pipe(sourcemaps.init())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('dist'));
}

async function defaultTask() {
    cssTask();
    jsTask();
}

exports.default = defaultTask
exports.css = cssTask
exports.js = jsTask
