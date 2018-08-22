<template>
    <section class="container">
        <div class="action-bar">
            <router-link
                class="button is-success"
                :to="{ name: 'NewPlacePage'}"
            >Add place</router-link>
        </div>
        <ul>
            <li
                v-for="(place,index) in places"
                :key="place.id"
            >
                <PlacePreview
                    :place="place"
                    :timer="50 * (index+1)"
                />
            </li>
        </ul>
    </section>
</template>

<style lang="scss" scoped>
    section {
        background: #FFF;
        padding: 0 10%;

        ul {
            list-style: none;

            li {
                display: flex;
                margin-bottom: 5%;

                &:last-child {
                    margin-bottom: 0;
                }
            }
        }

        .action-bar {
            padding: 20px 0;
            text-align: right;
        }
    }
</style>

<script>
import PlacePreview from './PlacePreview';
import { mapState } from 'vuex';

export default {
    name: 'PlaceList',
    components: {PlacePreview},
    created() {
        this.$store.dispatch('place/fetchPlaces');
    },
    computed: {...mapState('place', ['places'])}
};
</script>
