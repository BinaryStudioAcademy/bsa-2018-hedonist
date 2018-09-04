<template>
    <div class="section">
        <div class="container main-wrp">

            <b-tabs v-model="activeTab" position="is-centered" class="block">
                <b-tab-item label="General" :disabled="activeTab !== 0">
                    <div class="field is-horizontal">
                        <div class="field-label is-medium">
                            <label v-if="!$v.newPlace.localization.en.name.$error" class="label">Name</label>
                            <label v-else class="label error">Name</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.localization.en.name"
                                        class="input is-medium"
                                        type="text"
                                        placeholder="Place's name"
                                        :status="$v.newPlace.localization.en.name.$error ? 'error' : null"
                                        @input="$v.newPlace.localization.en.name.$reset()"
                                    >
                                    <div v-if="$v.newPlace.localization.en.name.$error" class="level">
                                        <div class="level-item">
                                            <p v-if="!$v.newPlace.localization.en.name.minLength || !$v.newPlace.localization.en.name.maxLength" class="error">From 4 to 20 chars!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">
                        <h4>Address and Location</h4>
                    </div>

                    <div class="field is-horizontal place-location">
                        <div class="field-label is-normal">
                            <label v-if="!$v.newPlace.city.$error" class="label">City</label>
                            <label v-else class="label error">City</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <SearchCity @select="newPlace.city = $event" :status="$v.newPlace.city.$error ? 'error' : null" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label v-if="!$v.newPlace.zip.$error" class="label">Zip</label>
                            <label v-else class="label error">Zip</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.zip"
                                        class="input"
                                        type="text"
                                        placeholder="Place's postal code"
                                        :status="$v.newPlace.zip.$error ? 'error' : null"
                                        @input="$v.newPlace.zip.$reset()"
                                    >
                                    <div v-if="$v.newPlace.zip.$error" class="level">
                                        <div class="level-item">
                                            <p v-if="!$v.newPlace.zip.numeric" class="error">Only digits!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label v-if="!$v.newPlace.address.$error" class="label">Address</label>
                            <label v-else class="label error">Address</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.address"
                                        class="input"
                                        type="text"
                                        placeholder="Place's address"
                                        :status="$v.newPlace.address.$error ? 'error' : null"
                                        @input="$v.newPlace.address.$reset()"
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
                            <label v-if="!$v.newPlace.phone.$error && !phoneInvalid" class="label">Phone</label>
                            <label v-else class="label error">Phone</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded">
                                    <input
                                        v-model="newPlace.phone"
                                        class="input"
                                        type="tel"
                                        placeholder="Place's phone"
                                        :status="$v.newPlace.phone.$error ? 'error' : null"
                                        @input="$v.newPlace.phone.$reset(); resetPhone()"
                                    >
                                </p>
                                <div v-if="!$v.newPlace.phone.$error" class="level">
                                    <div v-if="phoneInvalid" class="level-item">
                                        <p class="error">Ex. +380950000000 or 380950000000.</p>
                                    </div>
                                </div>
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
                            <label v-if="!$v.newPlace.website.$error" class="label">Website</label>
                            <label v-else class="label error">Website</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.website"
                                        class="input"
                                        type="text"
                                        placeholder="Place's website"
                                        @input="$v.newPlace.website.$reset()"
                                    >
                                </div>
                                <div v-if="$v.newPlace.website.$error" class="level">
                                    <div class="level-item">
                                        <p v-if="!$v.newPlace.website.url" class="error">NOT url!</p>
                                    </div>
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
                            <label v-if="!$v.newPlace.localization.en.description.$error" class="label">Description</label>
                            <label v-else class="label error">Description</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <textarea
                                        v-model="newPlace.localization.en.description"
                                        class="textarea"
                                        placeholder="Place's description.."
                                        :status="$v.newPlace.localization.en.description.$error ? 'error' : null"
                                        @input="$v.newPlace.localization.en.description.$reset()"
                                    />
                                    <div v-if="$v.newPlace.localization.en.description.$error" class="level">
                                        <div class="level-item">
                                            <p v-if="!$v.newPlace.localization.en.description.minLength || !$v.newPlace.localization.en.description.maxLength" class="error">From 20 to 500 chars!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="onNextGeneral()" class="button is-success">Next</span>
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
                                            <img class="image-preview" :src="getPreview(photo)">
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
                        <span @click="onNextCheck(newPlace.photos)" class="button is-success">Next</span>
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

                    <div class="buttons is-centered">
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
                        <span @click="onNextCheck(newPlace.tags)" class="button is-success">Next</span>
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
                        <span @click="onNextCheck(newPlace.features)" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Hours" :disabled="activeTab !== 5">
                    <div class="tab-wrp">
                        <div class="columns is-vcentered">
                            <div class="column is-half is-left">
                                <div class="worktime-wrp">
                                    <b-message :type="isDayWorking(newPlace.worktime['mo'].start, newPlace.worktime['mo'].end) ? 'is-success' : 'is-danger'">
                                        <p><strong>Monday:  </strong>from <strong>{{ displayTime(newPlace.worktime['mo'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['mo'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message :type="isDayWorking(newPlace.worktime['tu'].start, newPlace.worktime['tu'].end) ? 'is-success' : 'is-danger'">
                                        <p><strong>Tuesday:  </strong>from <strong>{{ displayTime(newPlace.worktime['tu'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['tu'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message :type="isDayWorking(newPlace.worktime['we'].start, newPlace.worktime['we'].end) ? 'is-success' : 'is-danger'">
                                        <p><strong>Wednesday:  </strong>from <strong>{{ displayTime(newPlace.worktime['we'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['we'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message :type="isDayWorking(newPlace.worktime['th'].start, newPlace.worktime['th'].end) ? 'is-success' : 'is-danger'">
                                        <p><strong>Thursday:  </strong>from <strong>{{ displayTime(newPlace.worktime['th'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['th'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message :type="isDayWorking(newPlace.worktime['fr'].start, newPlace.worktime['fr'].end) ? 'is-success' : 'is-danger'">
                                        <p><strong>Friday:  </strong>from <strong>{{ displayTime(newPlace.worktime['fr'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['fr'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message :type="isDayWorking(newPlace.worktime['sa'].start, newPlace.worktime['sa'].end) ? 'is-success' : 'is-danger'">
                                        <p><strong>Saturday:  </strong>from <strong>{{ displayTime(newPlace.worktime['sa'].start) }}</strong> till <strong>{{ displayTime(newPlace.worktime['sa'].end) }}</strong> o'clock</p>
                                    </b-message>
                                    <b-message :type="isDayWorking(newPlace.worktime['su'].start, newPlace.worktime['su'].end) ? 'is-success' : 'is-danger'">
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

                                        <div class="level">
                                            <div class="level-item"><a @click="onDayOff" class="button is-danger" :disabled="isDaySelected">Day(s) off?</a></div>
                                        </div>

                                        <b-field label="from">
                                            <b-timepicker v-model="timeStart" :disabled="isDaySelected" />
                                        </b-field>
                                        <b-field label="till">
                                            <b-timepicker v-model="timeEnd" :disabled="isDaySelected" />
                                        </b-field>

                                        <div class="level">
                                            <div class="level-item"><a @click="onWorkTimeAdd" class="button is-primary" :disabled="isDaySelected">Add</a></div>
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
                                <h1>{{ confirmText }}</h1>
                            </div>
                        </div>
                        <div class="buttons is-centered">
                            <span @click="activeTab--" class="button is-warning">Previous</span>
                            <span @click="onAdd()" class="button is-success">Add</span>
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
import mapSettingsService from '@/services/map/mapSettingsService';
import SearchCity from '../navbar/SearchCity';
import { required, minLength, maxLength, numeric, url } from 'vuelidate/lib/validators';
import phoneValidationService from '@/services/common/phoneValidationService';
import LocationService from '@/services/location/locationService';

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
                    mo: {
                        start: moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:   moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    tu: {
                        start: moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:   moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    we: {
                        start: moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:   moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    th: {
                        start: moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:   moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    fr: {
                        start: moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:   moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    sa: {
                        start: moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:   moment().set({'hours': 21, 'minutes': 0}).utc()
                    },
                    su: {
                        start: moment().set({'hours': 10, 'minutes': 0}).utc(),
                        end:   moment().set({'hours': 21, 'minutes': 0}).utc()
                    }
                },
                workWeekend: 1
            },
            phoneInvalid: false,
            selectedTag: '',
            weekdays: [],
            timeStart: moment().set({'hours': 10, 'minutes': 0}).toDate(),
            timeEnd: moment().set({'hours': 21, 'minutes': 0}).toDate(),
        };
    },

    validations: {
        newPlace: {
            localization: {
                en: {
                    name: { required, minLength: minLength(4), maxLength: maxLength(20) },
                    description: { required, minLength: minLength(20), maxLength: maxLength(500) }
                }
            },
            city: { required },
            zip: { required, numeric },
            address: { required },
            phone: { required },
            website: { required, url }
        }
    },

    created() {
        this.$store.dispatch('category/fetchAllCategories');
        this.$store.dispatch('features/fetchAllFeatures');

        LocationService.getUserLocationData()
            .then(coordinates => {
                let params = coordinates.lng + ',' + coordinates.lat;
                let mapboxCitiesApiUrl = mapSettingsService.getMapboxCitiesApiUrl(mapSettingsService.getMapboxToken(), params);
                LocationService.getCityList(mapboxCitiesApiUrl)
                    .then((res) => {
                        if (res.length) {
                            this.newPlace.city = res[0];
                        }
                    });
            });
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
        },
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
        },

        confirmText: function() {
            return 'Confirm add place "' + this.newPlace.localization.en.name.trim() + '"?';
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
            this.resetWorkTimeSelect();
        },
        displayTime(utcTime) {
            let localTime = utcTime.clone();
            localTime.local();
            return localTime.format('HH:mm');
        },
        onDayOff() {
            this.weekdays.forEach((item) => {
                this.newPlace.worktime[item].start = moment().set({'hours': 0, 'minutes': 0}).utc();
                this.newPlace.worktime[item].end = moment().set({'hours': 0, 'minutes': 0}).utc();
            });
            this.resetWorkTimeSelect();
        },
        resetWorkTimeSelect() {
            this.weekdays = [];
            this.timeStart = moment().set({'hours': 10, 'minutes': 0}).toDate();
            this.timeEnd = moment().set({'hours': 21, 'minutes': 0}).toDate();
        },
        isDayWorking(utcStart, utcEnd) {
            let localStart = utcStart.clone();
            localStart.local();
            let localEnd = utcEnd.clone();
            localEnd.local();

            return !(!localStart.hours() && !localStart.minutes() && !localEnd.hours() && !localEnd.minutes());
        },
        checkWorkTime() {
            if (!this.isDayWorking(this.newPlace.worktime.sa.start, this.newPlace.worktime.sa.end) &&
                    !this.isDayWorking(this.newPlace.worktime.su.start, this.newPlace.worktime.su.end)) {
                this.newPlace.workWeekend = 0;
            }
        },

        onNextGeneral() {
            this.$v.$touch();
            this.validatePhone();
            if (this.$v.$invalid) {
                this.$toast.open({
                    type: 'is-danger',
                    message: 'Please, fill in the highlighted fields.'
                });
            } else if (this.phoneInvalid) {
                this.$toast.open({
                    type: 'is-danger',
                    message: 'Please, correct phone format.'
                });
            } else {
                this.activeTab++;
            }
        },
        validatePhone() {
            if (!phoneValidationService.isPhone(this.newPlace.phone)) {
                this.phoneInvalid = true;
            }
        },
        resetPhone() {
            this.phoneInvalid = false;
        },

        onNextCheck(array) {
            if (!array.length) {
                this.$toast.open({
                    type: 'is-danger',
                    message: 'Please, add data.'
                });
            } else {
                this.activeTab++;
            }
        },

        onAdd() {
            this.checkWorkTime();
            this.$store.dispatch('place/addNewPlace', {
                user: this.user,
                place: this.newPlace
            }).then((result) => {
                this.$toast.open({
                    type: 'is-success',
                    message: 'Place added!'
                });
                this.$router.push(`/places/${result.id}`);
            }).catch((error) => {
                this.$toast.open({
                    type: 'is-danger',
                    message: error.message
                });
            });
        }
    }
};
</script>

<style lang="scss">
    .place-location {
        .location-search {
            display: none;
        }
    }
</style>

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

    .image-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 50% 50%;
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

    .error {
        color: #E50000;
    }
</style>


