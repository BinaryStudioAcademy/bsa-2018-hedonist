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
                                        v-model="newPlace.name"
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
                                    <SearchCity @select="selectCity = $event" />
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
                                    <input class="input" type="text" placeholder="Place's postal code">
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
                                    <input class="input" type="text" placeholder="Place's address">
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
                                    <input class="input" type="tel" placeholder="Place's phone">
                                </p>
                            </div>
                            <div class="field-label is-normal">
                                <label class="label">Twitter</label>
                            </div>
                            <div class="field">
                                <p class="control is-expanded">
                                    <input class="input" type="text" placeholder="Place's twitter">
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
                                    <input class="input" type="text" placeholder="Place's facebook">
                                </p>
                            </div>
                            <div class="field-label is-normal">
                                <label class="label">Instagram</label>
                            </div>
                            <div class="field">
                                <p class="control is-expanded">
                                    <input class="input" type="text" placeholder="Place's instagram">
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
                                    <input class="input" type="text" placeholder="Place's website">
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
                                    <input class="input" type="text" placeholder="Place's menu">
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
                                    <textarea class="textarea" placeholder="Place's description.." />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="onCancel()" class="button is-danger">Cancel</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Location" :disabled="activeTab !== 1">
                    <div class="map-part column">
                        <div class="map-box">
                            <img src="https://a.tiles.mapbox.com/v3/foursquare.qhb8olxr/16/38326/22101.png" alt="mapbox">
                        </div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="onCancel()" class="button is-danger">Cancel</span>
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Categories" :disabled="activeTab !== 2">
                    <div class="level">
                        <div class="level-item">
                            <b-field>
                                <b-select v-model="newPlace.category">
                                    <option value="" selected disabled>Select a category</option>
                                    <option
                                        v-for="option in categories"
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
                                        <option value="v" selected disabled>Add tags</option>
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
                                        v-for="tag in newPlace.category_tags"
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

                    <div class="buttons is-centered">
                        <span @click="onCancel()" class="button is-danger">Cancel</span>
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Features" :disabled="activeTab !== 3">
                    <template v-for="(feature, index) in features">
                        <div :key="index" class="level is-flex-mobile">
                            <div class="level-left">
                                <span class="label">{{ feature.name }}</span>
                            </div>
                            <div class="level-right">
                                <b-switch
                                    v-model="feature.status"
                                    type="is-success"
                                />
                            </div>
                        </div>
                    </template>

                    <div class="buttons is-centered">
                        <span @click="onCancel()" class="button is-danger">Cancel</span>
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab++" class="button is-success">Next</span>
                    </div>
                </b-tab-item>

                <b-tab-item label="Hours" :disabled="activeTab !== 4">
                    <div class="level is-centered">
                        <div class="level-item">
                            <b-field class="is-block-mobile">
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
                        </div>
                    </div>
                    <div class="columns is-centered">
                        <div class="column is-half">
                            <div class="level">
                                <div class="level-item">
                                    <b-field label="from">
                                        <b-timepicker v-model="timeStart" :disabled="isDaySelected" />
                                    </b-field>
                                </div>
                                <div class="level-item">
                                    <b-field label="to">
                                        <b-timepicker v-model="timeEnd" :disabled="isDaySelected" />
                                    </b-field>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-bottom level is-centered">
                        <div class="level-item"><a class="button is-primary is-large" :disabled="isDaySelected">Add</a></div>
                    </div>

                    <div class="buttons is-centered">
                        <span @click="onCancel()" class="button is-danger">Cancel</span>
                        <span @click="activeTab--" class="button is-warning">Previous</span>
                        <span @click="activeTab = activeTab" class="button is-success">Next</span>
                    </div>
                </b-tab-item>
            </b-tabs>
        </div>
    </div>
</template>

<script>
import SearchCity from '../navbar/SearchCity';

export default {
    name: 'NewPlacePage',
    components: {
        SearchCity
    },

    data() {
        return {
            activeTab: 0,


            newPlace: {
                name: '',
                category: '',
                category_tags: [],
                features: []
            },
            categories: {},
            selectedTag: 'v',
            selectCity: '',
            category_tags: [],
            weekdays: [],
            timeStart: new Date(),
            timeEnd: new Date(),
            features: [
                {
                    name: 'wi-fi',
                    status: false
                },
                {
                    name: 'hookah',
                    status: false
                },
                {
                    name: 'music',
                    status: false
                },
                {
                    name: 'credit cards',
                    status: false
                },
                {
                    name: 'wheelchair accessible',
                    status: false
                },
                {
                    name: 'reservations',
                    status: false
                },
                {
                    name: 'parking',
                    status: false
                },
                {
                    name: 'restroom',
                    status: false
                },
                {
                    name: 'take-out',
                    status: false
                },
                {
                    name: 'delivery',
                    status: false
                }
            ]
        };
    },

    created() {
        this.$store.dispatch('category/getAllCategories')
            .then((result) => {
                this.categories = result;
            });
    },

    watch: {
        'newPlace.category': function (categoryObject) {
            if (_.isEmpty(categoryObject)) { return; }
            this.newPlace.category_tags = [];
            this.$store.dispatch('category/getTagsByCategory', categoryObject.id)
                .then((result) => {
                    this.category_tags = result;
                });
            this.selectedTag = 'v';
        },

        'selectedTag': function (tagObject) {
            if (tagObject !== 'v' && !this.isTagAdded(tagObject)) {
                this.newPlace.category_tags.push(tagObject);
            }
        }
    },

    computed: {
        isCategorySelected: function () {
            return !!this.newPlace.category;
        },

        isDaySelected: function () {
            return !this.weekdays.length;
        }
    },

    methods: {
        onCloseTab: function(tagObject) {
            this.newPlace.category_tags = this.excludeTag(tagObject);
            this.selectedTag = 'v';
        },

        isTagAdded: function(tagObject) {
            return this.newPlace.category_tags.some((tag) => tag.name === tagObject.name);
        },

        excludeTag: function(tagObject)  {
            return this.newPlace.category_tags.filter((tag) => tag.name !== tagObject.name);
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

    .section-divider {
        margin: 30px 0 20px 30px;
        border-bottom: 1px solid #50595D;

        h4 {
            font-weight: 500;
        }
    }


    /**/

    .label {
        color: #50595D;
    }

    .map-box {
        img {
            width: 100%;
        }
    }

    /* timepicker needs */
    .btn-bottom {
        height: 200px;
    }

</style>