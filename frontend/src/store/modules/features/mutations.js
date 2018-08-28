export default {
    SET_ALL_FEATURES: (state, features) => {
        state.allFeatures = Object.assign({}, features);
    }
}