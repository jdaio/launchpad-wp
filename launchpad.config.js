/**
 * Launchpad Configuration
 *
 * 1. Edit the variables as per your project requirements.
 * 2. In paths you can add <<glob or array of globs>>.
 *
 * @package Launchpad
 */

module.exports = {
    /**
     * Project Options
     */

    // URL to local WordPress site.
    projectURL: '127.0.0.1',

    // Theme/Plugin URL. Leave as default if gulpfile is in root folder.
    productURL: './',


    /**
     * CSS Handling Options
     */

    // Path to main .scss file.
    styleEntry: './assets/scss/main.scss', // Path to main .scss file.

    // Browser Compatibility
    BROWSERS_LIST: [
        '> 1%',
        'last 2 versions',
        'not dead',
        'last 2 Chrome versions',
        'las2 2 Firefox versions',
        'last 2 Safari versions',
        'last 2 Edge versions',
        'last 2 Opera versions',
        'last 2 iOS versions',
        'last 1 Android versions',
        'last 1 ChromeAndroid versions',
        'ie >= 11',
    ],


    /**
     * Javascript Handling Options
     */

    // Javascript Entry File
    jsEntry: './assets/js/main.js',


    /**
     * Image Handling Options
     */

    // Image Source Folder
    imgSource: './assets/img/**/*',


    /**
     * Included File Options
     */

    // Includes Source Folder
    incSource: './assets/inc/**/*',


    /**
     * Translation Options
     */

    // Theme textdomain
    textDomain: 'launchpad',

    // Translation File Name
    translationFile: 'launchpad.pot',

    // Translation File Directory
    translationSource: './translations/**/*.*',
    translationDestination: './src/translations',

    // Package Name
    packageName: 'launchpad',

    // Bug Report URL
    bugReport: '#',

    // Last Translator Email ID
    lastTranslator: 'Jamal Ali-Mohammed <jamal@digitalheat.co>',

    // Team's Email ID
    team: 'Digital Heat <hello@digitalheat.co>',


    /**
     * Watch File Paths
     */

    // CSS Files
    watchStyles: './assets/scss/**/*.scss',

    // Scripts
    watchScripts: './assets/js/**/*.js',

    // HTML Files
    watchViews: './html/**/*.html',

    // PHP Files
    watchPHP: './src/**/*.php',
};
