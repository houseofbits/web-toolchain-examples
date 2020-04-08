'use strict'

const { VueLoaderPlugin } = require('vue-loader')

const path = require('path');

module.exports = {
    
    entry: './src',
    
    output: {
      filename: 'main.js',
      path: path.resolve(__dirname, 'dist'),
    },

    //#npm install --save-dev style-loader css-loader
    //#npm install --save vue vue-resource
    //#npm install --save-dev vue-loader vue-template-compiler vue-style-loader css-loader
    
    module: {
      rules: [
        {
          test: /\.css$/,
          use: [
            'style-loader',
            'css-loader',
          ],
        },
        {
          test: /\.vue$/,
          use: 'vue-loader'
        }        
      ],
    },    
    plugins: [
      new VueLoaderPlugin()
    ]
  };