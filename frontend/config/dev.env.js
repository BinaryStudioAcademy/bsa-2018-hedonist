'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  MAPBOX_TOKEN: '"'+process.env.MAPBOX_TOKEN+'"',
  MAPBOX_STYLE: '"'+process.env.MAPBOX_STYLE+'"'
})
