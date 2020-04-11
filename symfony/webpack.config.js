
const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    
    entry: './src/Assets/js/main.js',
    output: {
      filename: 'main.js',
      publicPath: '/public/assets/',
      path: path.resolve(__dirname, 'public/assets'),
    },
    module: {
      rules: [
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
        new MiniCssExtractPlugin({filename:'main.css'}),
    ],
  };