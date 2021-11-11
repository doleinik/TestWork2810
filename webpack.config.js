const path = require('path');
//const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
  //mode: 'development',
  mode: 'production',
 
  entry: './wp-content/themes/bov/js/src/main.js',
  output: {
    path: path.resolve(__dirname, 'wp-content/themes/bov/js/dist'),
    filename: 'bundle.js'
  },
  module: {
    rules: [
      {
        use: 'babel-loader',
        test: /\.js$/
      }
    ]
  },

  optimization: {
    //minimizer: [new UglifyJsPlugin()]
  },

  stats: 'errors-only',
  // stats: {
  //   colors: true,
  //   modules: false,
  //   reasons: false,
  //   errorDetails: true
  // }
};