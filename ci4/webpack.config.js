
const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    
    entry: './app/Assets/js/main.js',
    output: {
      filename: 'main.js',
      publicPath: '/public/assets/',
      path: path.resolve(__dirname, 'public/assets'),
    },
    module: {
      rules: [
        {
          test: /\.vue$/,
          loader: 'vue-loader',
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