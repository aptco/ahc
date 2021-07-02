var gulp = require('gulp');
var plumber = require('gulp-plumber');
//var compass = require('gulp-compass');
var sass = require('gulp-sass');
var cssmin = require('gulp-cssmin');

var themepath = "./wp-content/themes/ahc/";
var scsspath = "./_src/scss/";
var csspath = "./assets/css/";
var distpath = "./_dist/";

var ap_options =
{
	browse: ["last 2 versions", "ie >= 9", 'iOS >= 9', 'Android >= 4.4'],
	cascade: false
}
 
gulp.task('compass', function()
{
	gulp.src([scsspath + '*.scss', '!' + scsspath + '_*.scss'])
	.pipe(plumber())
	.pipe(compass({
		config_file: 'config.rb',
        comments: false,
        css: distpath,
        sass: scsspath
	})
	);
}
);

gulp.task('sass', function()
{
	return gulp.src([scsspath + '*.scss', '!' + scsspath + '_*.scss'])
	.pipe(plumber())
	.pipe(sass({
		outputStyle: 'expanded'
	}))
	.pipe(autoprefixer(ap_options))
	.pipe(gulp.dest(distpath));
}
);

gulp.task('cssmin', function()
{
	gulp.src(distpath + 'style.css')
	.pipe(plumber())
	//.pipe(cssmin())
	.pipe(gulp.dest(themepath));

	gulp.src([distpath + '*.css', '!' + distpath + 'style.css'])
	.pipe(plumber())
	.pipe(cssmin())
	.pipe(gulp.dest(csspath));

	done();
}
);

gulp.task('watch', function()
{
	gulp.watch(scsspath + '*.scss', gulp.task('sass'));
	//gulp.watch(scsspath + '*.scss', gulp.task('compass'));
	gulp.watch(distpath + '*.css', gulp.task('cssmin'));
}
);

//gulp.task('default', ['sass', 'cssmin']);