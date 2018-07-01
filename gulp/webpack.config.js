const path = require('path'),
Project = require('./settings');

module.exports = {
    entry: {
        App: Project.scripts + "/scripts.js"
    },
    output: {
        path: path.resolve(__dirname, Project.scripts),
        filename: "scripts-bundled.js"
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            }
        ]
    }
}