/**
 * -----------------------------------------------------------------------------
 * Launchpad for WordPress Development
 *
 * Licensed under GPL v3.0:
 * https://github.com/jdaio/launchpad-wp/blob/master/LICENSE
 *
 * @license GPL-3.0-or-later
 *
 * @overview Handles all file processing tasks, as well as BrowserSync, etc.
 *
 * @author Jamal Ali-Mohammed <jamal@digitalheat.co>
 *
 * @version 3.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * -----------------------------------------------------------------------------
 * Module Import & Settings
 * -----------------------------------------------------------------------------
 */

// Import Gulp
import gulp from 'gulp';
import { argv } from 'yargs';
import del from 'del';

// Import Browser Sync
import browserSync from 'browser-sync';

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

// Import Utility Modules
import cache from 'gulp-cache';
import lineec from 'gulp-line-ending-corrector';
import log from 'fancy-log';
import rename from 'gulp-rename';

// Import Launchpad Gulp Configuration
import pkg from './package.json';
import config from './launchpad.config';

/**
 * -----------------------------------------------------------------------------
 * Custom Error Handling
 *
 * @param Mixed err
 * -----------------------------------------------------------------------------
 */

const errorHandler = r => {
    log.error('❌ ERROR: <%= error.message %>')(r);
};

/**
 * -----------------------------------------------------------------------------
 * Global Runtime Variables
 * -----------------------------------------------------------------------------
 */

const isDev = argv.dev === undefined ? false : true;
const watchScripts = argv.noWatch === undefined ? true : false;
const buildDirectory = isDev ? `./build/${pkg.name}` : `./dist/${pkg.name}`;

/**
 * -----------------------------------------------------------------------------
 * Task: `init`.
 *
 * @description Initializes the gulp task runner.
 * @param { boolean } runBrowserSync Initialize browserSync on start.
 * -----------------------------------------------------------------------------
 */

async function init() {
    log('🚀 — Initializing gulp tasks...');

    await del([buildDirectory]);

    if (isDev) {
        return browserSync.init({
            ghostMode: false,
            injectChanges: true,
            logPrefix: 'launchpad',
            notify: false,
            open: false,
            port: config.port ? config.port : 8000,
            scrollProportionally: false,
            server: ['./', './html'],
            ui: {
                port: config.port ? config.port + 1 : 8001,
            },
            watchEvents: ['change', 'add', 'unlink', 'addDir', 'unlinkDir'],
        });
    }
}

gulp.task('init', gulp.series(init));

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

gulp.task('styles', () => {
    log('⚡️ — Processing stylesheets...');

    let gulpTask = gulp
        .src(config.styleEntry, {
            allowEmpty: true,
        })
        .pipe(plumber(errorHandler))
        .pipe(rename('style.min.css'));

    if (isDev) {
        gulpTask = gulpTask.pipe(rename('style.css')).pipe(
            sourcemaps.init({
                loadMaps: true,
            })
        );
    }

    gulpTask = gulpTask
        .pipe(
            sass({
                errorLogToConsole: true,
                indentWidth: 4,
                outputStyle: isDev ? 'expanded' : 'compressed',
                precision: 10,
            })
        )
        .on('error', sass.logError)
        .pipe(
            postcss([
                mqp({
                    sort: true,
                }),
                nano({
                    autoprefixer: {
                        browsers: config.BROWSERS_LIST,
                    },
                    preset: [
                        'default',
                        {
                            normalizeWhitespace: isDev ? false : true,
                        },
                    ],
                }),
                easings(),
            ])
        );

    if (isDev) {
        gulpTask = gulpTask.pipe(sourcemaps.write('./'));
    }

    gulpTask = gulpTask
        .pipe(lineec())
        .pipe(gulp.dest(`${buildDirectory}/assets/css`));

    if (isDev) {
        gulpTask = gulpTask.pipe(browserSync.stream());
    }

    gulpTask = gulpTask.on('end', () => log('✅ STYLES — completed!'));

    return gulpTask;
});

/**
 * -----------------------------------------------------------------------------
 * Task: `scripts`.
 *
 * @description Bundles javascript with Browserify.
 *
 * @todo Fill out a description for this section.
 * -----------------------------------------------------------------------------
 */

async function compileScripts() {
    log('⚡️ — Bundling scripts...');

    let bundler = browserify(config.jsEntry, {
        debug: true,
    }).transform(babel);

    if (isDev && watchScripts) {
        bundler = watchify(bundler);
    }

    let bundleScripts = await bundler
        .bundle()
        .pipe(plumber(errorHandler))
        .pipe(source('build.js'))
        .pipe(buffer())
        .pipe(rename('app.min.js'));

    if (isDev) {
        bundleScripts = bundleScripts.pipe(rename('app.js')).pipe(
            sourcemaps.init({
                loadMaps: true,
            })
        );
    }

    bundleScripts = bundleScripts.pipe(uglify());

    if (isDev) {
        bundleScripts = bundleScripts.pipe(sourcemaps.write('./'));
    }

    bundleScripts = bundleScripts
        .pipe(lineec())
        .pipe(gulp.dest(`${buildDirectory}/assets/js`))
        .on('end', () => log('✅ JS — completed!'));

    if (isDev && watchScripts) {
        bundler.on('update', () => bundleScripts);

        return bundleScripts;
    }

    return bundleScripts;
}

gulp.task('scripts', gulp.series(compileScripts));

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

gulp.task('images', () => {
    log('⚡️ — Processing images...');

    let gulpTask = gulp
        .src(config.imgSource)
        .pipe(
            cache(
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
                        plugins: [
                            {
                                removeViewBox: false,
                            },
                            {
                                cleanupIDs: false,
                            },
                        ],
                    }),
                ])
            )
        )
        .pipe(gulp.dest(`${buildDirectory}/assets/img`));

    if (isDev) {
        gulpTask = gulpTask.pipe(browserSync.stream());
    }

    gulpTask = gulpTask.on('end', () => log('✅ IMAGES — completed!'));

    return gulpTask;
});

/**
 * -----------------------------------------------------------------------------
 * Task: `clearCache`.
 *
 * @description Deletes the images cache. By running the next "images" task,
 *              each image will be regenerated.
 * -----------------------------------------------------------------------------
 */

gulp.task('clearImageCache', done => cache.clearAll(done));

/**
 * -----------------------------------------------------------------------------
 * Task: `html`.
 *
 * @description Watches html files for changes.
 * -----------------------------------------------------------------------------
 */

gulp.task('html', () => {
    log('⚡️ — Updating browser to reflect HTML changes...');

    const gulpTask = gulp
        .src(config.htmlSource)
        .pipe(browserSync.stream())
        .on('end', () => log('✅ HTML — completed!'));

    return gulpTask;
});

/**
 * -----------------------------------------------------------------------------
 * Task: `src`.
 *
 * @description Copies php source files to the distribution folder.
 * -----------------------------------------------------------------------------
 */

gulp.task('src', () => {
    log('⚡️ — Processing source files...');

    const gulpTask = gulp
        .src(config.phpSource)
        .pipe(gulp.dest(`${buildDirectory}`))
        .on('end', () => log('✅ SOURCE — completed!'));

    return gulpTask;
});

/**
 * -----------------------------------------------------------------------------
 * Task: `includes`.
 *
 * @description Copies included files to the distribution folder.
 * -----------------------------------------------------------------------------
 */

gulp.task('includes', () => {
    log('⚡️ — Processing included files...');

    let gulpTask = gulp
        .src(config.incSource)
        .pipe(gulp.dest(`${buildDirectory}/assets/includes`));

    if (isDev) {
        gulpTask = gulpTask.pipe(browserSync.stream());
    }

    gulpTask = gulpTask.on('end', () => log('✅ INCLUDES — completed!'));

    return gulpTask;
});

/**
 * -----------------------------------------------------------------------------
 * Task: `watch`.
 *
 * @description Watch tasks for the gulp processes.
 * -----------------------------------------------------------------------------
 */

gulp.task('watch', () => {
    log('🔍 — Watching files for changes...');

    gulp.watch(config.watchStyles, gulp.series('styles'));
    gulp.watch(config.watchScripts, gulp.series('scripts'));
    gulp.watch(config.htmlSource, gulp.series('html'));
    gulp.watch(config.phpSource, gulp.series('src'));
    gulp.watch(config.imgSource, gulp.series('images'));
    gulp.watch(config.incSource, gulp.series('includes'));
});

/**
 * -----------------------------------------------------------------------------
 * Task: `build`.
 *
 * @description Build theme without initializing browserSync or file watchers.
 * -----------------------------------------------------------------------------
 */

gulp.task(
    'prod',
    gulp.series(
        init,
        'clearImageCache',
        gulp.parallel('styles', 'scripts', 'src', 'images', 'includes')
    )
);

/**
 * -----------------------------------------------------------------------------
 * Task: `default`.
 *
 * @description Runs gulp tasks and initializes browserSync and watches files.
 * -----------------------------------------------------------------------------
 */

gulp.task(
    'default',
    gulp.series(
        init,
        'clearImageCache',
        gulp.parallel(
            'styles',
            'scripts',
            'html',
            'src',
            'images',
            'includes',
            'watch'
        )
    )
);
