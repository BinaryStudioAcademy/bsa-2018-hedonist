<template>
    <section class="container">
        <ul>
            <li 
                v-for="(place,index) in places" 
                :key="place.id"
            >
                <PlaceListComponent 
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
        padding: 0 200px;
    }

    li {
        display: flex;
        margin-bottom: 50px;
    }

    ul {
        list-style: none;
    }
</style>

<script>
import PlaceListComponent from './PlaceListComponent';
import { mapState } from 'vuex';

export default {
    name: 'PlaceList',
    components: {PlaceListComponent},
    computed: {...mapState('place', ['places'])}
};
</script>
