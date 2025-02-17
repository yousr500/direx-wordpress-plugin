import gulp from 'gulp';
import sass from 'gulp-sass';
import * as dartSass from 'sass';
import autoprefixer from 'gulp-autoprefixer';
import sourcemaps from 'gulp-sourcemaps';
import cleanCSS from 'gulp-clean-css';
import uglify from 'gulp-uglify';
import babelify from 'babelify';
import source from 'vinyl-source-stream';
import buffer from 'vinyl-buffer';
import browserify from 'browserify';
import browserSync from 'browser-sync';
import dotenv from 'dotenv';
dotenv.config();


const browserSyncInstance = browserSync.create();

const sassCompiler = sass(dartSass);
const projectURL = 'http://localhost/wordpress/wp-admin/plugins.php';

const paths = {
    styles: {
        src: ['./src/scss/mystyle.scss', './src/scss/auth.scss', './src/scss/order.scss'],    
        dest: './assets/css'
       
    },
    scripts: {
        src: ['./src/js/myscript.js', './src/js/auth.js', './src/js/order.js'],
        dest: './assets/js'
        
    },
    php: './**/*.php'
};
gulp.task( 'browser-sync', function() {
	browserSyncInstance.init({
		proxy: projectURL,
		injectChanges: true,
		open: false
	});
});

gulp.task('style', function() {
    return gulp.src( paths.styles.src )
    .pipe( sourcemaps.init() )
    .pipe(sassCompiler.sync({
     errLogToConsole: true,
     outputStyle: 'compressed'       
     }).on('error', sassCompiler.logError))
     .pipe( autoprefixer({ overrideBrowserslist: [ 'last 2 versions', '> 5%', 'Firefox ESR' ] }) )
     
     .pipe(cleanCSS({ compatibility: 'ie8' }))
     
     .pipe( sourcemaps.write( '.' ) )
     .pipe( gulp.dest( paths.styles.dest ))
     .pipe(browserSyncInstance.stream());
     
     
 });

 
gulp.task('js', function(done) {
    const tasks = paths.scripts.src.map(function(entry) {
        return browserify({ entries: [entry] })
            .transform(babelify, { presets: ['@babel/preset-env'] })
            .bundle()
            .on('error', console.error.bind(console))
            .pipe(source(entry.replace(/^.*[\\\/]/, ''))) // Get the file name
            .pipe(buffer())
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(uglify())
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest(paths.scripts.dest))
            .pipe(browserSyncInstance.stream());
    });

    // Ensure all tasks are completed before signaling done
    Promise.all(tasks).then(() => done()).catch(done);
});



gulp.task('watch', function() {
   
    gulp.watch( paths.styles.src, gulp.series('style') );
    gulp.watch( paths.scripts.src, gulp.series('js') );
    gulp.watch( paths.php ).on('change', browserSyncInstance.reload);
});

gulp.task('default', gulp.series('style', 'js', 'browser-sync', 'watch'));
