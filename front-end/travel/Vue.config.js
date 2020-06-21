module.exports = {
  // 基本路径
  publicPath: process.env.NODE_ENV === 'production'
      ? './'
      : '/',
  // 生产环境是否生成 sourceMap 文件
  productionSourceMap: false,
}