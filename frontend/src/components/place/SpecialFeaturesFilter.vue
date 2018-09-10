<template>
    <div class="category-tags">
        <span class="category-tags__title">Features:</span>

        <div class="tags">
            <template v-for="tag in tags">
                <PlaceFilterTag
                    :key="tag.id"
                    :tag="tag"
                    :active="tag.active"
                    color="#d346cd"
                    @onSelectTag="onSelectFeature"
                />
            </template>
        </div>
    </div>    
</template>

<script>
import PlaceFilterTag from './PlaceFilterTag';
import { mapState, mapGetters } from 'vuex';

export default {
    name: 'SpecialFeaturesFilter',

    components: {
        PlaceFilterTag
    },

    computed: {
        ...mapGetters('features', ['specialFeaturesList']),
        ...mapState('search', ['selectedFeatures']),
        tags() {
            return this.specialFeaturesList.map(feature => {
                feature.active = this.selectedFeatures.indexOf(feature.id) !== -1;
                return feature;
            });
        }
    },
    methods: {
        onSelectFeature(featureId, isFeatureActive) {
            this.$emit('onSelectFeature', featureId, isFeatureActive);
        }
    }
};
</script>

<style lang="scss" scoped>
    .category-tags {
        background: #f8f8f8;
        border-top: 1px solid #fff;
        border-bottom: 1px solid #e4e4e4;
        padding: 5px 16px 8px 16px;

        &__title {
            color: #6e6e6e;
            font-size: 11px;
            float: left;
            margin: 6px 5px 0 0;
            text-shadow: 0 1px 0 #fff;
            line-height: 100%;
            font-weight: bold;
        }
    }
</style>
