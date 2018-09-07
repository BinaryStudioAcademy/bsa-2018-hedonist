'use strict';
module.exports = {
  NODE_ENV: '"production"',
  MAPBOX_TOKEN: '"'+process.env.MAPBOX_TOKEN+'"',
  MAPBOX_STYLE: '"'+process.env.MAPBOX_STYLE+'"',
  SENTRY_LARAVEL_DSN: '"'+process.env.SENTRY_LARAVEL_DSN+'"',
  PUSHER_APP_KEY: '"'+process.env.PUSHER_APP_KEY+'"',
  PUSHER_APP_CLUSTER: '"'+process.env.PUSHER_APP_CLUSTER+'"',
  APP_EVENTS_NAMESPACE: '"'+process.env.APP_EVENTS_NAMESPACE+'"'
};
