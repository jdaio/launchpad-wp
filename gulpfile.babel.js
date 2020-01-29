/**
 * -----------------------------------------------------------------------------
 * Launchpad Gulpfile
 *
 * Inspired by Ahmad Awais' WPGulp Setup:
 * https://github.com/ahmadawais/WPGulp
 *
 * Licensed under GPL v3.0:
 * https://github.com/jdaio/launchpad/blob/master/LICENSE
 *
 * @license GPL-3.0-or-later
 *
 * @overview Handles all file processing tasks, as well as BrowserSync, etc.
 *
 * @author Jamal Ali-Mohammed <https://jdaio.github.io>
 *
 * @version 2.1.0
 * -----------------------------------------------------------------------------
 */


/**
 * -----------------------------------------------------------------------------
 * Module Import & Settings
 * -----------------------------------------------------------------------------
 */

// Import Gulp
import gulp from 'gulp';

// Import CSS Modules
import easings from 'postcss-easings';
import mqp from 'css-mqpacker';
import nano from 'cssnano';
import postcss from 'gulp-postcss';
import sass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';

// Import Javascript Modules
import babel from 'babelify';
import browserify from 'browserify';
import buffer from 'vinyl-buffer';
import plumber from 'gulp-plumber';
import source from 'vinyl-source-stream';
import uglify from 'gulp-uglify';
import watchify from 'watchify';

// Import Image Related Modules
import imagemin from 'gulp-imagemin';

// Import Wordpress Related Modules
import sort from 'gulp-sort';
import wpPot from 'gulp-wp-pot';

// Import Utility Modules
import browserSync from 'browser-sync';
import cache from 'gulp-cache';
import exit from 'gulp-exit';
import lineec from 'gulp-line-ending-corrector';
import log from 'fancy-log';
import rename from 'gulp-rename';

// Import Launchpad Gulp Configuration
import config from './launchpad.config';


/**
 * -----------------------------------------------------------------------------
 * Custom Error Handling
 *
 * @param Mixed err
 * -----------------------------------------------------------------------------
 */

const errorHandler = (r) => {
    log.error('❌ ERROR: <%= error.message %>')(r);
};


/**
 * -----------------------------------------------------------------------------
 * Task: `browser-sync`.
 *
 * @description Handles live reloads, CSS injections, and Localhost tunneling.
 * @link http://www.browsersync.io/docs/options/
 *
 * @param {Mixed} done Done.
 * -----------------------------------------------------------------------------
 */

// Setup Browser Sync.
function runBrowserSync() {
    browserSync.init({
        ghostMode: false,
        injectChanges: true,
        logPrefix: 'launchpad',
        notify: false,
        open: false,
        scrollProportionally: false,
        server: ['./', './html'],
        watchEvents: ['change', 'add', 'unlink', 'addDir', 'unlinkDir'],
    });
}

/**
 * -----------------------------------------------------------------------------
 * Task: `styles`.
 *
 * @description Compiles SCSS, Autoprefixes and minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source SCSS file.
 *    2. Compiles SCSS to CSS.
 *    3. Combines media queries and autoprefixes with PostCSS.
 *    4. Writes the sourcemaps for it.
 *    5. Renames the CSS file to style.min.css.
 *    7. Injects CSS via Browser Sync.
 * -----------------------------------------------------------------------------
 */

gulp.task('styles', () => gulp.src(config.styleEntry, {
        allowEmpty: true,
    })
    .pipe(plumber(errorHandler))
    .pipe(rename('style.min.css'))
    .pipe(sourcemaps.init({
        loadMaps: true,
    }))
    .pipe(sass({
        errorLogToConsole: true,
        indentWidth: 4,
        outputStyle: 'compressed',
        precision: 10,
    }))
    .on('error', sass.logError)
    .pipe(postcss([
        mqp({
            sort: true,
        }),
        nano({
            autoprefixer: {
                browsers: config.BROWSERS_LIST,
            },
        }),
        easings(),
    ]))
    .pipe(sourcemaps.write('./'))
    .pipe(lineec())
    .pipe(gulp.dest('./dist/css'))
    .pipe(browserSync.stream())
    .on('end', () => log('✅ STYLES — completed!')));


/**
 * -----------------------------------------------------------------------------
 * Task: `scripts`.
 *
 * @description Bundles javascript with Browserify.
 *
 * @todo Fill out a description for this section.
 * -----------------------------------------------------------------------------
 */

function compileScripts(watch) {
    const bundler = watchify(browserify(config.jsEntry, {
            debug: true,
        })
        .transform(babel));

    function rebundle() {
        log('-> Bundling scripts...');

        return bundler
            .bundle()
            .pipe(plumber(errorHandler))
            .pipe(source('build.js'))
            .pipe(buffer())
            .pipe(rename('app.min.js'))
            .pipe(sourcemaps.init({
                loadMaps: true,
            }))
            .pipe(uglify())
            .pipe(sourcemaps.write('./'))
            .pipe(lineec())
            .pipe(gulp.dest('./dist/js'))
            .on('end', () => log('✅ JS — completed!'));
    }

    if (watch) {
        bundler.on('update', () => rebundle());

        rebundle();
    } else {
        rebundle()
            .pipe(exit());
    }
}

function watchScripts() {
    return compileScripts(true);
}

gulp.task('scripts:build', gulp.series(compileScripts));
gulp.task('scripts:dev', gulp.series(watchScripts), done => done());


/**
 * -----------------------------------------------------------------------------
 * Task: `images`.
 *
 * @description Minifies PNG, JPEG, GIF and SVG images.
 *
 * This task does the following:
 *     1. Gets the source of images raw folder.
 *     2. Minifies PNG, JPEG, GIF and SVG images.
 *     3. Generates and saves the optimized images.
 * -----------------------------------------------------------------------------
 */

gulp.task('images', () => gulp.src(config.imgSource)
    .pipe(cache(
        imagemin([
            imagemin.gifsicle({
                interlaced: true,
                optimizationLevel: 2,
                colors: 256,
            }),
            imagemin.jpegtran({
                progressive: true,
                arithmetic: false,
            }),
            imagemin.optipng({
                optimizationLevel: 3,
                bitDepthReduction: true,
                colorTypeReduction: true,
                paletteReduction: true,
            }),
            imagemin.svgo({
                plugins: [{
                        removeViewBox: false,
                    },
                    {
                        cleanupIDs: false,
                    },
                ],
            }),
        ])
    ))
    .pipe(gulp.dest('./dist/img/'))
    .pipe(browserSync.stream())
    .on('end', () => log('✅ IMAGES — completed!')));


/**
 * -----------------------------------------------------------------------------
 * Task: `clear-images-cache`.
 *
 * @description Deletes the images cache. By running the next "images" task,
 *              each image will be regenerated.
 * -----------------------------------------------------------------------------
 */

gulp.task('clearCache', done => cache.clearAll(done));


/**
 * -----------------------------------------------------------------------------
 * Task: `includes`.
 *
 * @description Copies included files to the distribution folder.
 * -----------------------------------------------------------------------------
 */

gulp.task('includes', () => gulp.src(config.incSource)
    .pipe(gulp.dest('./dist/inc/'))
    .pipe(browserSync.stream())
    .on('end', () => log('✅ INCLUDES — completed!')));


/**
 * -----------------------------------------------------------------------------
 * Task: `views:dev`.
 *
 * @description Watch HTML files for changes and inject the new code.
 * -----------------------------------------------------------------------------
 */

function renderViews() {
    return gulp.src(config.watchViews)
        .pipe(browserSync.stream());
}


/**
 * -----------------------------------------------------------------------------
 * Task: `translate`.
 *
 * @description Generates WP POT Translation files.
 *
 * This task does the following:
 *    1. Gets the source of all the PHP files.
 *    2. Sort files in stream by path or any custom sort comparator.
 *    3. Applies wpPot with the variable set at the top of this file.
 *    4. Generate a .pot file of i18n that can be used for l10n to build .mo
 *       file.
 * -----------------------------------------------------------------------------
 */

gulp.task('translate', () => gulp.src(config.translationSource)
    .pipe(sort())
    .pipe(wpPot({
        domain: config.textDomain,
        package: config.packageName,
        bugReport: config.bugReport,
        lastTranslator: config.lastTranslator,
        team: config.team,
    }))
    .pipe(gulp.dest(`${config.translationDestination}/${config.translationFile}`))
    .on('end', () => log('✅ TRANSLATE — completed!')));


/**
 * -----------------------------------------------------------------------------
 * Task: `watch`.
 *
 * @description Watch tasks for the gulp processes.
 * -----------------------------------------------------------------------------
 */

gulp.task('watch', () => {
    gulp.watch(config.watchViews, gulp.series(renderViews));
    gulp.watch(config.watchStyles, gulp.series('styles'));
    gulp.watch(config.watchScripts, gulp.series('scripts:dev'));
    gulp.watch(config.imgSource, gulp.series('images'));
    gulp.watch(config.incSource, gulp.series('includes'));
});

gulp.task('default', gulp.parallel('styles', 'scripts:dev', 'images', 'includes', runBrowserSync, 'watch'));
