<template>
    <div class="section">
        <div class="container main-wrp">

            <b-tabs v-model="activeTab" position="is-centered" class="block">
                <b-tab-item label="General" :disabled="activeTab !== 0">
                    <div class="field is-horizontal">
                        <div class="field-label is-medium">
                            <label class="label">Name</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.localization.en.name"
                                        class="input is-medium"
                                        type="text"
                                        placeholder="Place's name"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">
                        <h4>Address and Location</h4>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">City</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <SearchCity @select="newPlace.city = $event" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Zip</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.zip"
                                        class="input"
                                        type="text"
                                        placeholder="Place's postal code"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Address</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.address"
                                        class="input"
                                        type="text"
                                        placeholder="Place's address"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">
                        <h4>Contact and Other Info</h4>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Phone</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded">
                                    <input
                                        v-model="newPlace.phone"
                                        class="input"
                                        type="tel"
                                        placeholder="Place's phone"
                                    >
                                </p>
                            </div>
                            <div class="field-label is-normal">
                                <label class="label">Twitter</label>
                            </div>
                            <div class="field">
                                <p class="control is-expanded">
                                    <input
                                        v-model="newPlace.twitter"
                                        class="input"
                                        type="text"
                                        placeholder="Place's twitter"
                                    >
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Facebook</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded">
                                    <input
                                        v-model="newPlace.facebook"
                                        class="input"
                                        type="text"
                                        placeholder="Place's facebook"
                                    >
                                </p>
                            </div>
                            <div class="field-label is-normal">
                                <label class="label">Instagram</label>
                            </div>
                            <div class="field">
                                <p class="control is-expanded">
                                    <input
                                        v-model="newPlace.instagram"
                                        class="input"
                                        type="text"
                                        placeholder="Place's instagram"
                                    >
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Website</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.website"
                                        class="input"
                                        type="text"
                                        placeholder="Place's website"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Menu link</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.menu"
                                        class="input"
                                        type="text"
                                        placeholder="Place's menu"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Description</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <textarea v-model="newPlace.localization.en.description" class="textarea" placeholder="Place's description.." />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Photos" :disabled="activeTab !== 1">
                    <div class="tab-wrp">
                        <div class="level">
                            <div class="level-item">
                                <b-field>
                                    <b-upload v-model="newPlace.photos" multiple drag-drop>
                                        <section class="section">
                                            <div class="content has-text-centered">
                                                <p><b-icon icon="upload" size="is-large" /></p>
                                                <p>Drop photos here or click to upload</p>
                                            </div>
                                        </section>
                                    </b-upload>
                                </b-field>
                            </div>
                        </div>
                        <div v-if="newPlace.photos.length > 0" class="columns is-multiline is-centered">
                            <template v-for="(photo, index) in newPlace.photos">
                                <div :key="index" class="column is-one-third">
                                    <div class="photo">
                                        <figure :key="index" class="image is-square">
                                            <img :src="getPreview(photo)">
                                        </figure>
                                        <div class="level">
                                            <div class="level-item">
                                                <span class="tag is-small is-light id-center" @click="deletePhoto(index)">
                                                    <a>delete</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Location" :disabled="activeTab !== 2">
                    <div class="tab-wrp">
                        <div class="map-wrp">
                            <mapbox
                                :access-token="mapboxToken"
                                :map-options="{
                                    style: mapboxStyle,
                                    center: {
                                        lat: 50.4501,
                                        lng: 30.5241
                                    },
                                    zoom: 5
                                }"
                                :scale-control="{
                                    show: true,
                                    position: 'top-left'
                                }"
                                @map-load="mapLoaded"
                            />
                        </div>
                    </div>

                    <div class="buttons is-centered location-buttons">
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Categories" :disabled="activeTab !== 3">
                    <div class="tab-wrp">
                        <div class="level">
                            <div class="level-item">
                                <b-field>
                                    <b-select v-model="newPlace.category">
                                        <option value="" selected disabled>Select a category</option>
                                        <option
                                            v-for="option in allCategories"
                                            :key="option.id"
                                            :value="option"
                                        >
                                            {{ option.name }}
                                        </option>
                                    </b-select>
                                </b-field>
                            </div>
                        </div>
                        <template v-if="isCategorySelected">
                            <div class="level">
                                <div class="level-item">
                                    <b-field>
                                        <b-select v-model="selectedTag">
                                            <option value="" selected disabled>Add tags</option>
                                            <option
                                                v-for="option in categoryTags.byId"
                                                :key="option.id"
                                                :value="option"
                                            >
                                                {{ option.name }}
                                            </option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                        </template>

                        <!-- Tags field here! -->
                        <template>
                            <div class="level">
                                <div class="level-item">
                                    <b-taglist>
                                        <b-tag
                                            v-for="tag in newPlace.tags"
                                            :key="tag.id"
                                            type="is-info"
                                            size="is-medium"
                                            closable
                                            @close="onCloseTab(tag)"
                                        >
                                            {{ tag.name }}
                                        </b-tag>
                                    </b-taglist>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Features" :disabled="activeTab !== 4">
                    <div class="columns is-centered">
                        <div class="column is-half">
                            <template v-for="feature in allFeatures">
                                <div :key="feature.id" class="level is-flex-mobile">
                                    <div class="level-left">
                                        <span class="label">{{ feature.name }}</span>
                                    </div>
                                    <div class="level-right">
                                        <b-switch
                                            type="is-success"
                                            @input="onFeatureSwitch(feature)"
                                        />
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Hours" :disabled="activeTab !== 5">
                    <div class="tab-wrp">
                        <div class="columns is-vcentered">
                            <div class="column is-half is-left">
                                <div class="worktime-wrp">
                                    <b-message>
                                        <p><strong>Monday:  </strong>from <strong>{{ displayTime(newPlace.worktime['mo'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['mo'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Tuesday:  </strong>from <strong>{{ displayTime(newPlace.worktime['tu'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['tu'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Wednesday:  </strong>from <strong>{{ displayTime(newPlace.worktime['we'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['we'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Thursday:  </strong>from <strong>{{ displayTime(newPlace.worktime['th'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['th'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Friday:  </strong>from <strong>{{ displayTime(newPlace.worktime['fr'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['fr'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Saturday:  </strong>from <strong>{{ displayTime(newPlace.worktime['sa'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['sa'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Sunday:  </strong>from <strong>{{ displayTime(newPlace.worktime['su'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['su'].end) }}</strong> o'clock</p>
                                    </b-message>
                                </div>
                            </div>

                            <div class="column is-half is-right">
                                <div class="columns is-centered">
                                    <div class="column is-half">
                                        <b-field class="is-block">
                                            <b-checkbox-button
                                                size="is-fullwidth"
                                                v-model="weekdays"
                                                native-value="mo"
                                            >
                                                Monday
                                            </b-checkbox-button>
                                            <b-checkbox-button
                                                size="is-fullwidth"
                                                v-model="weekdays"
                                                native-value="tu"
                                            >
                                                Tuesday
                                            </b-checkbox-button>
                                            <b-checkbox-button
                                                size="is-fullwidth"
                                                v-model="weekdays"
                                                native-value="we"
                                            >
                                                Wednesday
                                            </b-checkbox-button>
                                            <b-checkbox-button
                                                size="is-fullwidth"
                                                v-model="weekdays"
                                                native-value="th"
                                            >
                                                Thursday
                                            </b-checkbox-button>
                                            <b-checkbox-button
                                                size="is-fullwidth"
                                                v-model="weekdays"
                                                native-value="fr"
                                            >
                                                Friday
                                            </b-checkbox-button>
                                            <b-checkbox-button
                                                size="is-fullwidth"
                                                v-model="weekdays"
                                                native-value="sa"
                                            >
                                                Saturday
                                            </b-checkbox-button>
                                            <b-checkbox-button
                                                size="is-fullwidth"
                                                v-model="weekdays"
                                                native-value="su"
                                            >
                                                Sunday
                                            </b-checkbox-button>
                                        </b-field>

                                        <b-field label="from">
                                            <b-timepicker v-model="timeStart" :disabled="isDaySelected" />
                                        </b-field>
                                        <b-field label="till">
                                            <b-timepicker v-model="timeEnd" :disabled="isDaySelected" />
                                        </b-field>

                                        <div class="level">
                                            <div class="level-item"><a @click="onWorkTimeAdd" class="button is-primary is-large" :disabled="isDaySelected">Add</a></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Add place" :disabled="activeTab !== 6">
                    <div class="box">
                        <div class="level">
                            <div class="level-item">
                                <h1>Do you really want to add new place <strong>"{{ newPlace.localization.en.name.trim() }}"?</strong></h1>
                            </div>
                        </div>
                        <div class="buttons is-centered">
                            <span @click="activeTab--" class="button is-warning">Previous</span>
                            <span @click="onAdd()" class="button is-medium is-success">Add</span>
                        </div>
                    </div>
                </b-tab-item>
            </b-tabs>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import moment from 'moment';
import Mapbox from 'mapbox-gl-vue';
import SearchCity from '../navbar/SearchCity';
import mapSettingsService from '@/services/map/mapSettingsService';

export default {
    name: 'NewPlacePage',
    components: {
        Mapbox,
        SearchCity
    },

    data() {
        return {
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle(),
            activeTab: 0,
            newPlace: {
                localization: {
                    en: {
                        name: '',
                        description: ''
                    }
                },
                zip: '',
                city: '',
                address: '',
                photos: [],
                location: {
                    lng: 30.5241,
                    lat: 50.4501
                },
                category: '',
                tags: [],
                features: [],
                menu: '',
                phone: '',
                twitter: '',
                facebook: '',
                instagram: '',
                worktime: {
                    'mo': {
                        start:  moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:    moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    'tu': {
                        start:  moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:    moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    'we': {
                        start:  moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:    moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    'th': {
                        start:  moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:    moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    'fr': {
                        start:  moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:    moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    'sa': {
                        start: moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end: moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    'su': {
                        start:  moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:    moment().set({'hours': 21, 'minutes': 0}).utc()
                    }
                },
                workWeekend: 1
            },
            selectedTag: '',
            weekdays: [],
            timeStart: moment().set({'hours': 10, 'minutes': 0}).toDate(),
            timeEnd: moment().set({'hours': 21, 'minutes': 0}).toDate(),
        };
    },

    created() {
        this.$store.dispatch('category/fetchAllCategories');
        this.$store.dispatch('features/fetchAllFeatures');
    },

    watch: {
        'newPlace.category': function (categoryObject) {
            if (_.isEmpty(categoryObject)) { return; }
            this.newPlace.tags = [];
            this.$store.dispatch('category/fetchCategoryTags', categoryObject.id);
            this.selectedTag = '';
        },

        'selectedTag': function (tagObject) {
            if (tagObject !== '' && !this.isTagAdded(tagObject)) {
                this.newPlace.tags.push(tagObject);
            }
        }
    },

    updated() {
        window.dispatchEvent(new Event('resize'));
    },

    computed: {
        ...mapState('category', ['allCategories']),
        ...mapState('category', ['categoryTags']),
        ...mapState('features', ['allFeatures']),

        ...mapGetters('auth', ['getAuthenticatedUser']),
        user() {
            return this.getAuthenticatedUser;
        },

        isCategorySelected: function() {
            return !!this.newPlace.category;
        },

        isDaySelected: function() {
            return !this.weekdays.length;
        }
    },

    methods: {
        getPreview(photo) {
            return URL.createObjectURL(photo).toString();
        },

        deletePhoto(index) {
            this.newPlace.photos.splice(index, 1);
        },

        mapLoaded(map) {
            let marker = new mapboxgl.Marker({
                draggable: true
            })
                .setLngLat([30.5241, 50.4501])
                .addTo(map);

            marker.on('dragend', () => {
                this.newPlace.location = marker.getLngLat();
            });
        },

        isTagAdded: function(tagObject) {
            return this.newPlace.tags.some((tag) => tag.name === tagObject.name);
        },
        excludeTag: function(tagObject)  {
            return this.newPlace.tags.filter((tag) => tag.name !== tagObject.name);
        },
        onCloseTab: function(tagObject) {
            this.newPlace.tags = this.excludeTag(tagObject);
            this.selectedTag = '';
        },

        onFeatureSwitch(featureObject) {
            let index = this.newPlace.features.indexOf(featureObject);
            if (index === -1) {
                this.newPlace.features.push(featureObject);
            } else {
                this.newPlace.features.splice(index, 1);
            }
        },

        onWorkTimeAdd() {
            this.weekdays.forEach((item) => {
                this.newPlace.worktime[item].start = moment(this.timeStart).utc();
                this.newPlace.worktime[item].end = moment(this.timeEnd).utc();
            });
            this.weekdays = [];
            this.timeStart = moment().set({'hours': 10, 'minutes': 0}).toDate();
            this.timeEnd = moment().set({'hours': 21, 'minutes': 0}).toDate();
        },
        displayTime(utcTime) {
            let localTime = utcTime.clone();
            localTime.local();
            return localTime.format('HH:mm');
        },

        onAdd() {
            console.log(this.newPlace);
            this.$store.dispatch('place/addNewPlace', {
                user: this.user,
                place: this.newPlace
            }).then(() => {
                this.$toast.open({
                    type: 'is-success',
                    message: 'Place added!'
                })
            }).catch(() => {
                this.$toast.open({
                    type: 'is-danger',
                    message: 'Error!'
                })
            });
        }
    }
};
</script>

<style lang="scss" scoped>
    .section {
        padding-top: 24px;
    }

    .main-wrp {
        margin: auto;
        max-width: 960px;
    }

    .tab-wrp {
        min-height: 400px;
        margin-bottom: 15px;
    }

    /* General tab */
    .section-divider {
        margin: 30px 0 20px 30px;
        border-bottom: 1px solid #50595D;

        h4 {
            font-weight: 500;
        }
    }

    /* Photos tab */
    .photo {
        figure {
            margin-bottom: 10px;
        }
    }

    /* Location tab */
    .map-wrp {
        width: 100%;
        height: 600px;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    .location-buttons {
        padding-top: 20px;
    }

</style>