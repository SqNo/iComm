var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .configureRuntimeEnvironment('dev')
;

const firstConfig = Encore.getWebpackConfig();

// Set a unique name for the config (needed later!)
firstConfig.name = 'firstConfig';

module.exports = firstConfig;
