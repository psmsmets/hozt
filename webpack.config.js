var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public_html/assets/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/assets/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addStyleEntry('easy_admin', './assets/css/easy_admin.scss')
    .addStyleEntry('security', './assets/css/security.scss')
    .addStyleEntry('animate', './assets/css/animate.css')
    .addStyleEntry('bootstrap', './assets/css/bootstrap.scss')
    .addStyleEntry('safari_select_fix', './assets/css/safari_select_fix.scss')
    .addEntry('sortable', './assets/js/sortable.js')
    .addEntry('hozt', './assets/js/hozt.js')
    .addEntry('calendar', './assets/js/calendar.js')
    .addEntry('carousel', './assets/js/carousel.js')
    .addEntry('enrolment_form', './assets/js/enrolment_form.js')
    .addEntry('tryout_enrolled', './assets/js/tryout_enrolled.js')
    .addEntry('form_default', './assets/js/form_default.js')
    .addEntry('form_extended', './assets/js/form_extended.js')
    .addEntry('eu_cookie', './assets/js/eu_cookie.js')
    .addEntry('training_category', './assets/js/training_category.js')
    .addEntry('training_schedule', './assets/js/training_schedule.js')
    .addEntry('membership_competitions', './assets/js/membership_competitions.js')
    .addEntry('membership_schedule', './assets/js/membership_schedule.js')
    .addEntry('membership_preferences', './assets/js/membership_preferences.js')
    .addEntry('sportadmin_competition', './assets/js/sportadmin_competition.js')
    .addEntry('sportadmin_competitions', './assets/js/sportadmin_competitions.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    //.configureBabel(() => {}, {
    //    useBuiltIns: 'usage',
    //    corejs: 3
    //})

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
        Popper: ['popper.js', 'default'],
        //_: 'underscore',
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    .enablePostCssLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    .enableIntegrityHashes()

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();
