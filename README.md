# Launchpad

---

Launchpad is a Gulp-powered development kit for simple HTML + CSS + JS projects.

## How to Get Started

Launchpad requires [Node.js](https://nodejs.org/) v12+ to run.

To get started, clone and install the project's dependencies:

```sh
$ git clone https://github.com/jdaio/launchpad.git
$ cd launchpad
$ npm install
$ node app
```

Alternatively, you can download the latest release or repository zip and run `npm install` or `yarn install`.

## Settings

Launchpad's default paths and options can be found and modified in `launchpad.config.js`.

## Commands

Below are a list of all of the commands that can be used to run Launchpad.

### Development

* `npm run start` - Runs Launchpad in its default state of processing CSS, JS and HTML.
* `npm run styles` - Compiles, autoprefixes and minifies SCSS.
* `npm run scripts:build` - Bundles scripts.
* `npm run scripts:dev` - Bundles scripts and activates file watcher for changes.
* `npm run images` - Minifies and processes images.
* `npm run clearCache` - Clears out the image cache, forcing each image to be regenerated the next time `npm run images` is run.
* `npm run translations` - Processes translation files for theme use.

### Releases

Launchpad uses [Release-it](https://github.com/release-it/release-it) for it's package release and versioning workflow.

**Note:** *This part is still under development for now, but it shouldn't take much to get it working yourself if you absolutely need it.*

* `npm run log` - Updates the project Changelog.
* `npm run release` - Releases a new version of the project on Github and bumps project version number.
* `npm run release-minor` - Releases the latest project as a minor (*.x.x) update.
* `npm run release-major` - Releases the latest project as a major (x.*.*) update.
* `npm run release-dry` - Runs release it as a dry run, showing the interactivity and the commands it *would* execute.
* `npm run release-beta` - Releases the latest project as a pre-release (beta) version.

## To Do

* Update Gulp workflow to improve development between "development" and "production" environments.
* Utilize argument-based commands to minimize the number of needed script commands.
* Complete release-it features.

## License

This project is licensed under GPL v3.
