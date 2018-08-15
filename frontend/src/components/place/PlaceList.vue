<template>
    <section class="container">
        <ul>
            <li 
                v-for="(place,index) in places" 
                :key="place.id"
            >
                <PlacePreviewList
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
    }
</style>

<script>
import PlacePreviewList from './PlacePreviewList';
import { mapState } from 'vuex';

export default {
    name: 'PlaceList',
    components: {PlacePreviewList},
    created() {
        this.$store.dispatch("place/fetchPlaces");
    },
    computed: {...mapState('place', ['places'])}
};
</script>
