const path = require('path');

module.exports = {
    context: path.resolve(__dirname, './src'),
    entry: {
        csr_generator: './csr_generator.js'
    },
    output: {
        path: path.resolve(__dirname, './dist'),
        filename: '[name].bundle.js'
    },
};