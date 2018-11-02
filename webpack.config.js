Encore
    .autoProvidejQuery();

const webpack = require("webpack");
const path = require("path");

let config = {
    entry: "./src/Assets/app.js",
    output: {
        path: path.resolve(__dirname, "./public/build"),
        filename: "./app.js"
    }
}

module.exports = config;