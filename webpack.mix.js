const mix = require('laravel-mix')

const path = require('path')

// mix.setPublicPath('public')

mix
  .js('resources/js/app.js', 'assets/js/')
  .sass('resources/sass/app.scss', 'assets/css')

// Bug al usar extract() si se están cargando módulos dinámicamente
// Bug al usar extract() si se están cargando módulos dinámicamente
// mix.extract()

if (mix.inProduction()) {
  mix.version()

  if (process.env.APP_DEBUG === true) {
    mix.sourceMaps()
  }
}

mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/js')
    }
  },
  output: {
    // filename: (chunkData) => {
    //   console.log(chunkData.chunk.name)
    //   return 'assets/js/mundo[name].js'
    //   // return chunkData.chunk.name === '/assets/js' ? '[name].js' : 'assets/js/[name].js'
    // },
    chunkFilename: 'assets/js/[name].js' + (mix.inProduction() ? '?id=[chunkhash]' : '')
    // chunkFilename: 'assets/js/[name].[chunkhash].js'
    // publicPath: mix.config.hmr ? '//localhost:8080/' : '/'
  }
})
