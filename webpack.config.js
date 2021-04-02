const path = require('path');

module.exports = {
    entry: [
        './assets/src/js/main.js',
        './assets/src/scss/main.scss'
    ],
    output: {
        filename: 'app.js',
        path: path.resolve(__dirname, 'assets/public/js'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [],
            }, {
                test: /\.scss$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'file-loader',
                        options: { 
                            outputPath: '../css/', 
                            name: 'app.css'
                        }
                    },
                    'sass-loader'
                ]
            }
        ]
    }
};