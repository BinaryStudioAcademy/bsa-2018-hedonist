import httpService from '@/services/common/httpService';
import normalizerService from '@/services/common/normalizerService';

export default {
    addNewPlace: (context, payload) => {
        return new Promise((resolve, reject) => {
            let data = new FormData();
            data.append('longitude', payload.place.location.lng);
            data.append('latitude', payload.place.location.lat);
            data.append('city', JSON.stringify(payload.place.city));
            data.append('zip', payload.place.zip);
            data.append('address', payload.place.address);
            data.append('localization', JSON.stringify(payload.place.localization));
            _.forEach(payload.place.photos, (photo) => {
                data.append('photos[]', photo);
            });
            data.append('phone', payload.place.phone);
            data.append('website', payload.place.website);
            data.append('facebook', payload.place.facebook);
            data.append('instagram', payload.place.instagram);
            data.append('twitter', payload.place.twitter);
            data.append('menu_url', payload.place.menu);
            data.append('category_id', payload.place.category.id);
            _.forEach(payload.place.tags, (tag) => {
                data.append('tags[]', tag.id);
            });
            _.forEach(payload.place.features, (feature) => {
                data.append('features[]', feature.id);
            });
            data.append('creator_id', payload.user.id);
            data.append('work_weekend', payload.place.workWeekend);
            data.append('worktime', JSON.stringify(payload.place.worktime));

            httpService.post('/places', data)
                .then((result) => {
                    resolve(result.data.data);
                })
                .catch(() => {
                    reject(error);
                });
        });
    },

    setPlaceRating: (context, { placeId, rating }) => {
        return new Promise((resolve, reject) => {
            return httpService.post('/places/' + placeId + '/ratings', {
                rating: rating
            })
                .then(response => {
                    const ratingAvg = response.data.data.rating_avg;
                    context.commit('SET_CURRENT_PLACE_RATING_VALUE', ratingAvg);
                    const ratingCount = response.data.data.rating_count;
                    context.commit('SET_CURRENT_PLACE_RATING_COUNT', ratingCount);
                    const myRating = response.data.data.my_rating;
                    context.commit('SET_CURRENT_PLACE_MY_RATING', myRating);
                    resolve();
                })
                .catch(error => {
                    reject(error);
                });
        });
    },

    loadCurrentPlace: (context, id) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places/' + id)
                .then((response) => {
                    const currentPlace = response.data.data;
                    context.commit('SET_CURRENT_PLACE', currentPlace);
                    resolve();
                })
                .catch((err) => {
                    reject(err);
                });
        });
    },

    fetchPlaces: (context, filters) => {
        if(filters.location){
            let queryUrl = createSearchQueryUrl('/places/search', filters);
            return new Promise((resolve, reject) => {
                httpService.get(queryUrl)
                    .then((res) => {
                        context.commit('SET_PLACES', res.data.data);
                        context.commit('SET_AMOUNT_PLACES', res.data.data.amount);
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    });
            });
        } else {
            Promise.resolve();
        }
    },

    loadMorePlaces: (context, {filters = {}, page}) => {
        filters.page = page;
        let queryUrl = createSearchQueryUrl('/places/search', filters);
        return new Promise((resolve, reject) => {
            httpService.get(queryUrl)
                .then((res) => {
                    context.commit('LOAD_MORE_PLACES', res.data.data);
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
        });
    },

    getLikedPlace: (context, placeId) => {
        httpService.get(`places/${placeId}/liked`)
            .then((res) => {
                context.commit('SET_PLACE_LIKED', res.data.data.likeStatus);
                return Promise.resolve(res);
            }).catch((err) => {
                return Promise.reject(err);
            });
    },

    likePlace: (context, placeId) => {
        httpService.post(`places/${placeId}/like`)
            .then((res) => {
                context.commit('SET_CURRENT_PLACE_LIKES', res.data.data.likes);
                context.commit('SET_CURRENT_PLACE_DISLIKES', res.data.data.dislikes);
                context.commit('SET_PLACE_LIKED', res.data.data.likeStatus);
                return Promise.resolve(res);
            })
            .catch((err) => {
                return Promise.reject(err);
            });
    },

    dislikePlace: (context, placeId) => {
        httpService.post(`places/${placeId}/dislike`)
            .then((res) => {
                context.commit('SET_CURRENT_PLACE_LIKES', res.data.data.likes);
                context.commit('SET_CURRENT_PLACE_DISLIKES', res.data.data.dislikes);
                context.commit('SET_PLACE_LIKED', res.data.data.likeStatus);
                return Promise.resolve(res);
            })
            .catch((err) => {
                return Promise.reject(err);
            });
    },

    addTasteToPlace: (context, data) => {
        return new Promise((resolve, reject) => {
            httpService.post('/place/add-taste', data)
                .then((res) => { resolve(res); })
                .catch((err) => { reject(err); });
        });
    },

    fetchRecommendationPlaces: (context, id) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places/recommendations/' + id)
                .then((res) => { resolve(res.data.data); })
                .catch((err) => { reject(err); });
        });
    }
};

const createSearchQueryUrl = (url, filters) => {
    let polygon = '';
    let location = filters.location;
    if (filters.polygon !== undefined && Array.isArray(filters.polygon)) {
        polygon = filters.polygon[0]
            .map( (item) => item[0] + ',' + item[1])
            .join(';');
        location = '';
    }
    let params = {
        'filter[category]': filters.category,
        'filter[name]': filters.name,
        'filter[location]': location,
        'filter[top_rated]': filters.top_rated,
        'filter[top_reviewed]': filters.top_reviewed,
        'filter[checkin]': filters.checkin,
        'filter[saved]': filters.saved,
        'filter[recommended]': filters.recommended,
        'filter[opened]': filters.opened,
        'filter[polygon]': polygon,
        'filter[tags]': filters.tags,
        'filter[features]': filters.features,
        'page': filters.page
    };

    return httpService.makeQueryUrl(url, params);
};

