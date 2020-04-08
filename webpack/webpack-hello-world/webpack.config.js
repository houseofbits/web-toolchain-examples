const path = require('path');

module.exports = {
    
    entry: './src',
    
    output: {
      filename: 'main.js',
      path: path.resolve(__dirname, 'dist'),
    },

    //#npm install --save-dev style-loader css-loader
    module: {
    rules: [
        {
         test: /\.css$/,
         use: [
           'style-loader',
           'css-loader',
         ],
       },
     ],
   },
    
  };