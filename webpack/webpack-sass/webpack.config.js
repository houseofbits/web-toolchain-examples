const path = require('path');

module.exports = {
    
    entry: './src',
    
    output: {
      filename: 'main.js',
      path: path.resolve(__dirname, 'dist'),
    },

    module: {
    rules: [
      {
        test: /\.(less)$/,
        use: [
          'style-loader',   // creates style nodes from JS strings
          'css-loader',     // translates CSS into CommonJS
          'less-loader'     // compiles Less to CSS
        ]
      },
      {
        test: /\.s(a|c)ss$/,
        use: [
          'style-loader',
          'css-loader',
          'sass-loader'
        ]
      },      
      {
         test: /\.css$/,
         use: [
           'style-loader',
           'css-loader'
         ],
       },
     ],
   },
    
  };