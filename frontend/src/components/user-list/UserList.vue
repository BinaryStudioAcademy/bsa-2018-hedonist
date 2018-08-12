<template>
    <section>
        <div class="list-header">
            <figure class="image is-3by1">
                <img :src="list.photoUrl">
            </figure>
            <div class="content">
                <h2 class="title is-2 has-text-primary">
                    {{list.name}}
                </h2>
                <div class="list-owner level">
                    <div class="level-left">
                        <div class="level-item">
                            <figure class="image is-32x32">
                                <img :src="list.user.avatar">
                            </figure>
                        </div>
                        <div class="level-item">
                            <p>
                                Created by:<br/>
                                <a class="has-text-info" href="#">
                                    {{list.user.name}}
                                </a>
                            </p>
                        </div>
                        <div class="level-item">
                            <p>
                                Updated on:<br/>
                                {{list.updated_at}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ListItem
                v-for="(place,index) in places"
                :key="place.id"
                :timerOrder="index"
                :place="place"
                class="list-item"
        />
    </section>
</template>

<script>
    import ListItem from './ListItem'

    export default {
        name: "UserList",
        components: {ListItem},
        props: {
            places: {
                required: true,
                type: Array
            },
            list: {
                required: true,
                type: Object
            }
        }
    }
</script>

<style lang="scss" scoped>
    .list-item {
        margin-bottom: 1rem;
    }

    .list-header {
        background: #FFF;
        margin-bottom: 1rem;
    }

    .content {
        padding: 0 1rem 1rem 1rem;

        p {
            color: gray;
        }
    }

    .image > img {
        border-radius: 8px;
    }

    .image {
        margin: auto;
    }

    .title {
        margin: 0.5rem 0 0.5rem 0;
    }

    @media screen and (max-width: 769px) {
        .image {
            justify-self: center;
        }
    }
</style>