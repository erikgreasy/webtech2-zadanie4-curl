const path = require('path');

module.exports = {
    entry: './assets/src/js/main.js',
    output: {
    filename: 'app.js',
        path: path.resolve(__dirname, 'assets/public/js'),
    },
};