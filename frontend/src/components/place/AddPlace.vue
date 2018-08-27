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

                <b-tab-item label="Location" :disabled="activeTab !== 1">
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

                    <div class="buttons is-centered">
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Categories" :disabled="activeTab !== 2">
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
                                                v-for="option in category_tags"
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

                <b-tab-item label="Features" :disabled="activeTab !== 3">
                    <div class="columns is-centered">
                        <div class="column is-half">
                            <template v-for="(feature, index) in allFeatures">
                                <div :key="index" class="level is-flex-mobile">
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

                <b-tab-item label="Hours" :disabled="activeTab !== 4">
                    <div class="tab-wrp">
                        <div class="columns is-vcentered">
                            <div class="column is-half is-left">
                                <div class="worktime-wrp">
                                    <b-message>
                                        <p><strong>Monday:  </strong>from <strong>{{ newPlace.worktime['mo'].start }}</strong> till <strong>{{ newPlace.worktime['mo'].end }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Tuesday:  </strong>from <strong>{{ newPlace.worktime['tu'].start }}</strong> till <strong>{{ newPlace.worktime['tu'].end }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Wednesday:  </strong>from <strong>{{ newPlace.worktime['we'].start }}</strong> till <strong>{{ newPlace.worktime['we'].end }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Thursday:  </strong>from <strong>{{ newPlace.worktime['th'].start }}</strong> till <strong>{{ newPlace.worktime['th'].end }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Friday:  </strong>from <strong>{{ newPlace.worktime['fr'].start }}</strong> till <strong>{{ newPlace.worktime['fr'].end }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Saturday:  </strong>from <strong>{{ newPlace.worktime['sa'].start }}</strong> till <strong>{{ newPlace.worktime['sa'].end }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message>
                                        <p><strong>Sunday:  </strong>from <strong>{{ newPlace.worktime['su'].start }}</strong> till <strong>{{ newPlace.worktime['su'].end }}</strong> o'clock</p>
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

                <b-tab-item label="Add place" :disabled="activeTab !== 5">
                    <div class="box">
                        <h1>Do you really want to add new place <strong>"{{ newPlace.localization.en.name }}"?</strong></h1>
                        <div class="buttons is-right">
                            <span @click="onAdd()" class="button is-medium is-success">Add</span>
                            <span @click="activeTab--" class="button is-warning">Previous</span>
                            <span @click="onCancel()" class="button is-danger">Cancel</span>
                        </div>
                    </div>
                </b-tab-item>
            </b-tabs>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
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
                location: {},
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
                        start:  '10:00',
                        end:    '21:00'
                    },
                    'tu': {
                        start:  '10:00',
                        end:    '21:00'
                    },
                    'we': {
                        start:  '10:00',
                        end:    '21:00'
                    },
                    'th': {
                        start:  '10:00',
                        end:    '21:00'
                    },
                    'fr': {
                        start:  '10:00',
                        end:    '21:00'
                    },
                    'sa': {
                        start:  '10:00',
                        end:    '21:00'
                    },
                    'su': {
                        start:  '10:00',
                        end:    '21:00'
                    }
                }
            },
            allCategories: [],
            allFeatures: [],
            selectedTag: '',
            category_tags: [],

            weekdays: [],
            timeStart: new Date(0,0,0,10),
            timeEnd: new Date(0,0,0,21)
        };
    },

    created() {
        this.$store.dispatch('category/getAllCategories')
            .then((result) => {
                this.allCategories = result;
            });

        this.$store.dispatch('features/getAllFeatures')
            .then((result) => {
                this.allFeatures = result;
            });
    },

    watch: {
        'newPlace.category': function (categoryObject) {
            if (_.isEmpty(categoryObject)) { return; }
            this.newPlace.tags = [];
            this.$store.dispatch('category/getTagsByCategory', categoryObject.id)
                .then((result) => {
                    this.category_tags = result;
                });
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
                let st_min = this.timeStart.getMinutes() < 10 ? '0' + this.timeStart.getMinutes() : this.timeStart.getMinutes();
                let et_min = this.timeEnd.getMinutes() < 10 ? '0' + this.timeEnd.getMinutes() : this.timeEnd.getMinutes();
                this.newPlace.worktime[item].start = this.timeStart.getHours() + ':' + st_min;
                this.newPlace.worktime[item].end = this.timeEnd.getHours() + ':' + et_min;
                this.weekdays = [];
                this.timeStart = new Date(0,0,0,10);
                this.timeEnd = new Date(0,0,0,21);
            });
        },

        onAdd() {
            console.log(this.newPlace);
        },

        onCancel() {
            this.newPlace = {};
            this.$router.push({ name: 'home' });
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

    /* Location tab */
    .map-wrp {
        width: 100%;
        height: 600px;
    }

    #map {
        width: 100%;
        height: 100%;
    }


</style>