
const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    
    entry: './src/index.js',    
    output: {
      filename: 'main.js',
      publicPath: '/dist/',
      path: path.resolve(__dirname, 'dist'),
    },
    module: {
      rules: [
        {
          test: /\.vue$/,
          loader: 'vue-loader',
          options: {
            loaders: {
            }
          }
        },
        {
          test: /\.css$/,
          use: [
            MiniCssExtractPlugin.loader,
            'css-loader'
          ],
        }      
      ],
    },    
    performance: { hints: false },
    plugins: [
      new VueLoaderPlugin(),
      new MiniCssExtractPlugin({filename:'main.css'}),
    ],
  };