import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';

export const enableSentryErrorReporting = (Vue) => {
    Vue.config.errorHandler = (err) => console.error(err);

    Raven
        .config(process.env.SENTRY_LARAVEL_DSN)
        .addPlugin(RavenVue, Vue)
        .install();
};
