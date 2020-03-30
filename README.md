# Launchpad for WordPress Theme Development

---

Launchpad is a Gulp-powered development kit for WordPress themes.

## How to Get Started

Launchpad requires [Node.js](https://nodejs.org/) v12+ to run.

To get started, clone and install the project.

```sh
$ git clone https://github.com/jdaio/launchpad-wp.git
$ cd launchpad-wp
$ npm install
$ npm run start
```

## Settings

Launchpad's default paths and options can be found and modified in `launchpad.config.js`.

The options are pretty self-explanatory.

## Commands

Below are a list of all of the commands that can be used to run Launchpad.

### Development

**Primary Scripts:**

-   `npm run dev` - Starts Launchpad in development mode (include unminified CSS and JS with maps and start browserSync).
-   `npm run prod` - Compiles theme to distribution directory.

**Component Scripts:**

-   `npm run src:dev` - Copies source files to theme build directory.
-   `npm run styles:dev` - Processes SCSS, generates sourcemaps and copies to build directory.
-   `npm run scripts:dev` - Bundles scripts, generates sourcemaps, copies scripts to build directory.
-   `npm run images:dev` - Optimizes images and copies to build directory.
-   `npm run includes:dev` - Copies included files to build directory.

To run the individual tasks for production, simply replace `:dev` with `:prod` and the respective files will be minified without sourcemaps and/or optimized and copied to the distribution directory.

## To Do

-   [ ] Implement proper versioning and auto-changelog.
-   [ ] Implement automatic WP translations.
-   [ ] Implement automatic replacement for package names in PHP.

## License

This project is licensed under GPL v3.
