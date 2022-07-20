import { defineBuildConfig } from 'unbuild'

export default defineBuildConfig({
  entries: ['js/main'],
  externals: [],
  clean: true,
  declaration: true,
  rollup: {
    emitCJS: true,
    inlineDependencies: true
  }
})
