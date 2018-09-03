<template>
    <div class="section">
        <div class="container main-wrp">

            <b-tabs v-model="activeTab" position="is-centered" class="block">
                <b-tab-item :label="$t('add_place_page.tabs.general.label')" :disabled="activeTab !== 0">
                    <div class="field is-horizontal">
                        <div class="field-label is-medium">
                            <label class="label">{{ $t('add_place_page.tabs.general.labels.name') }}</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.localization.en.name"
                                        class="input is-medium"
                                        type="text"
                                        :placeholder="$t('add_place_page.tabs.general.placeholders.name')"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">
                        <h4>{{ $t('add_place_page.tabs.general.dividers.first') }}</h4>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ $t('add_place_page.tabs.general.labels.city') }}</label>
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
                            <label class="label">{{ $t('add_place_page.tabs.general.labels.zip') }}</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.zip"
                                        class="input"
                                        type="text"
                                        :placeholder="$t('add_place_page.tabs.general.placeholders.zip')"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ $t('add_place_page.tabs.general.labels.address') }}</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.address"
                                        class="input"
                                        type="text"
                                        :placeholder="$t('add_place_page.tabs.general.placeholders.address')"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">
                        <h4>{{ $t('add_place_page.tabs.general.dividers.second') }}</h4>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ $t('add_place_page.tabs.general.labels.phone') }}</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded">
                                    <input
                                        v-model="newPlace.phone"
                                        class="input"
                                        type="tel"
                                        :placeholder="$t('add_place_page.tabs.general.placeholders.phone')"
                                    >
                                </p>
                            </div>
                            <div class="field-label is-normal">
                                <label class="label">{{ $t('add_place_page.tabs.general.labels.twitter') }}</label>
                            </div>
                            <div class="field">
                                <p class="control is-expanded">
                                    <input
                                        v-model="newPlace.twitter"
                                        class="input"
                                        type="text"
                                        :placeholder="$t('add_place_page.tabs.general.placeholders.twitter')"
                                    >
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ $t('add_place_page.tabs.general.labels.facebook') }}</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded">
                                    <input
                                        v-model="newPlace.facebook"
                                        class="input"
                                        type="text"
                                        :placeholder="$t('add_place_page.tabs.general.placeholders.facebook')"
                                    >
                                </p>
                            </div>
                            <div class="field-label is-normal">
                                <label class="label">{{ $t('add_place_page.tabs.general.labels.instagram') }}</label>
                            </div>
                            <div class="field">
                                <p class="control is-expanded">
                                    <input
                                        v-model="newPlace.instagram"
                                        class="input"
                                        type="text"
                                        :placeholder="$t('add_place_page.tabs.general.placeholders.instagram')"
                                    >
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ $t('add_place_page.tabs.general.labels.website') }}</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.website"
                                        class="input"
                                        type="text"
                                        :placeholder="$t('add_place_page.tabs.general.placeholders.website')"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ $t('add_place_page.tabs.general.labels.menu') }}</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control is-expanded">
                                    <input
                                        v-model="newPlace.menu"
                                        class="input"
                                        type="text"
                                        :placeholder="$t('add_place_page.tabs.general.placeholders.menu')"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">{{ $t('add_place_page.tabs.general.labels.description') }}</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <textarea v-model="newPlace.localization.en.description" class="textarea" :placeholder="$t('add_place_page.tabs.general.placeholders.description')" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="activeTab++" class="button is-success">{{ $t('add_place_page.buttons.next') }}</span>
                    </div>
                </b-tab-item>

                <b-tab-item :label="$t('add_place_page.tabs.photos.label')" :disabled="activeTab !== 1">
                    <div class="tab-wrp">
                        <div class="level">
                            <div class="level-item">
                                <b-field>
                                    <b-upload v-model="newPlace.photos" multiple drag-drop>
                                        <section class="section">
                                            <div class="content has-text-centered">
                                                <p><b-icon icon="upload" size="is-large" /></p>
                                                <p>{{ $t('add_place_page.tabs.photos.upload') }}</p>
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
                                                    <a>{{ $t('add_place_page.tabs.photos.delete') }}</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="activeTab--" class="button is-warning">{{ $t('add_place_page.buttons.previous') }}</span>
                        <span @click="activeTab++" class="button is-success">{{ $t('add_place_page.buttons.next') }}</span>
                    </div>
                </b-tab-item>

                <b-tab-item :label="$t('add_place_page.tabs.location.label')" :disabled="activeTab !== 2">
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
                        <span @click="activeTab--" class="button is-warning">{{ $t('add_place_page.buttons.previous') }}</span>
                        <span @click="activeTab++" class="button is-success">{{ $t('add_place_page.buttons.next') }}</span>
                    </div>
                </b-tab-item>

                <b-tab-item :label="$t('add_place_page.tabs.categories.label')" :disabled="activeTab !== 3">
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
                        <span @click="activeTab--" class="button is-warning">{{ $t('add_place_page.buttons.previous') }}</span>
                        <span @click="activeTab++" class="button is-success">{{ $t('add_place_page.buttons.next') }}</span>
                    </div>
                </b-tab-item>

                <b-tab-item :label="$t('add_place_page.tabs.features.label')" :disabled="activeTab !== 4">
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
                        <span @click="activeTab--" class="button is-warning">{{ $t('add_place_page.buttons.previous') }}</span>
                        <span @click="activeTab++" class="button is-success">{{ $t('add_place_page.buttons.next') }}</span>
                    </div>
                </b-tab-item>

                <b-tab-item :label="$t('add_place_page.tabs.hours.label')" :disabled="activeTab !== 5">
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
                        <span @click="activeTab--" class="button is-warning">{{ $t('add_place_page.buttons.previous') }}</span>
                        <span @click="activeTab++" class="button is-success">{{ $t('add_place_page.buttons.next') }}</span>
                    </div>
                </b-tab-item>

                <b-tab-item :label="$t('add_place_page.tabs.add.label')" :disabled="activeTab !== 6">
                    <div class="box">
                        <div class="level">
                            <div class="level-item">
                                <h1>{{ confirmText }}</h1>
                            </div>
                        </div>
                        <div class="buttons is-centered">
                            <span @click="activeTab--" class="button is-warning">{{ $t('add_place_page.buttons.previous') }}</span>
                            <span @click="onAdd()" class="button is-success">{{ $t('add_place_page.buttons.add') }}</span>
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

        onAdd() {
            this.checkWorkTime();
            this.$store.dispatch('place/addNewPlace', {
                user: this.user,
                place: this.newPlace
            }).then(() => {
                this.$toast.open({
                    type: 'is-success',
                    message: 'Place added!'
                });

            }).catch(() => {
                this.$toast.open({
                    type: 'is-danger',
                    message: 'Error!'
                });
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