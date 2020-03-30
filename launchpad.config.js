/**
 * Launchpad Configuration
 *
 * 1. Edit the variables as per your project requirements.
 * 2. In paths you can add <<glob or array of globs>>.
 */

module.exports = {
    /**
     * BrowserSync Options
     */
    port: 8000,

    /**
     * HTML Handling Options
     */
    htmlSource: './html/**/*',

    /**
     * PHP Handling Options
     */
    phpSource: './src/**/*',

    /**
     * CSS Handling Options
     */

    // Path to main .scss file.
    styleEntry: './assets/scss/main.scss', // Path to main .scss file.
    watchStyles: './assets/scss/**/*.scss',

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
    jsEntry: './assets/js/index.js',
    watchScripts: './assets/js/**/*.js',

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
};
