<template>
    <section class="container is-fluid">
        <div class="list-header">
            <img :src="list.photoUrl">
            <div class="content">
                <h2 class="title is-2 has-text-primary">
                    {{list.name}}
                </h2>
                <div class="list-owner level">
                    <div class="level-left is-mobile">
                        <div class="level-item">
                            <figure class="image is-32x32">
                                <img :src="list.user.avatar">
                            </figure>
                        </div>
                        <div class="level-item">
                            <p>
                                Created by
                            </p>
                            <a class="has-text-info" href="#">
                                {{list.user.name}}
                            </a>
                            <p>
                                • Updated on: {{list.updated_at}}
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
        data() {
            return {
                list: {
                    photoUrl: 'https://static1.squarespace.com/static/55b7dde9e4b02b839dad00ad/t/55dc60b3e4b025d475d00d55/1440506039948/SP-Mainheader.jpg?format=1500w',
                    name: 'Real list name',
                    updated_at: '12-03-2018',
                    user: {
                        name: 'Sample user',
                        avatar: 'https://www.w3schools.com/howto/img_avatar.png'
                    }
                },
                places:
                    [
                        {
                            id: 1,
                            name: "Sample place",
                            rating: 9,
                            photo: {url: 'https://static1.squarespace.com/static/55b7dde9e4b02b839dad00ad/t/55dc60b3e4b025d475d00d55/1440506039948/SP-Mainheader.jpg?format=1500w'},
                            category: 'Real Category',
                            address: 'Pushkina street, Colotushkina house',
                            reviews: [
                                {}, {}, {}
                            ],
                            tags: [{id: 1, name: 'Tag 1'}, {id: 2, name: 'Tag 2'}, {id: 3, name: 'Tag 3'}]
                        },
                        {
                            id: 2,
                            name: "Sample place",
                            rating: 6,
                            photo: {url: 'https://static1.squarespace.com/static/55b7dde9e4b02b839dad00ad/t/55dc60b3e4b025d475d00d55/1440506039948/SP-Mainheader.jpg?format=1500w'},
                            category: 'Real Category',
                            address: 'Pushkina street, Colotushkina house',
                            reviews: [
                                {}, {}, {}
                            ],
                            tags: [{id: 1, name: 'Tag 1'}, {id: 2, name: 'Tag 2'}, {id: 3, name: 'Tag 3'}]
                        },
                        {
                            id: 3,
                            name: "Sample place",
                            rating: 4,
                            photo: {url: 'https://static1.squarespace.com/static/55b7dde9e4b02b839dad00ad/t/55dc60b3e4b025d475d00d55/1440506039948/SP-Mainheader.jpg?format=1500w'},
                            category: 'Real Category',
                            address: 'Pushkina street, Colotushkina house',
                            reviews: [
                                {}, {}, {}
                            ],
                            tags: [{id: 1, name: 'Tag 1'}, {id: 2, name: 'Tag 2'}, {id: 3, name: 'Tag 3'}]
                        },
                        {
                            id: 4,
                            name: "Sample place",
                            rating: 2,
                            photo: {url: 'https://static1.squarespace.com/static/55b7dde9e4b02b839dad00ad/t/55dc60b3e4b025d475d00d55/1440506039948/SP-Mainheader.jpg?format=1500w'},
                            category: 'Real Category',
                            address: 'Pushkina street, Colotushkina house',
                            reviews: [
                                {}, {}, {}
                            ],
                            tags: [{id: 1, name: 'Tag 1'}, {id: 2, name: 'Tag 2'}, {id: 3, name: 'Tag 3'}]
                        },
                    ]
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

        figure {
            margin: 0;
        }

        p{
            margin: 0 5px 0 5px;
        }
        p{
            color: gray;
        }
    }

    .image > img {
        border-radius: 8px;
    }

    .title{
        margin: 0.5rem 0 0.5rem 0;
    }
</style>