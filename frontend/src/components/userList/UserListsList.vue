<template>
    <section class="container">
        <div class="columns is-multiline centered">
            <UserListsItem 
                v-for="(userList, index) in userLists" 
                :user-list="userList" 
                :key="index" 
                :timer="300 * (index+1)"
            />
        </div>
    </section>
</template>

<script>
import UserListsItem from './UserListsItem';

export default {
    name: 'UserListsList',
    data() {
        return {
            userLists: [
                {
                    id: 1,
                    list_name: 'Where to buy flowers',
                    places_count: 9,
                    img_preview: {url: 'https://igx.4sqi.net/img/general/600x600/66686416_A5Pukr-ytw3rd2VpxaAEjPzTYy-DFVcyx2yQu2PttDw.jpg'},
                },
                {
                    id: 2,
                    list_name: 'Vine shops of Kiev',
                    places_count: 10,
                    img_preview: {url: 'https://igx.4sqi.net/img/general/600x600/22650605_IahjYqsMiTw38TTYSPwD0J4kEvl0S3CGEl8ZyD50T0M.jpg'},
                },
                {
                    id: 3,
                    list_name: 'Cafes near fountain',
                    places_count: 6,
                    img_preview: {url: 'https://igx.4sqi.net/img/general/600x600/25738663_steOofsqv4R44p3tsH9P5cEhpe28-PW7XBzyfvwuK58.jpg'},
                },
                {
                    id: 1,
                    list_name: 'Where to smoke hookah',
                    places_count: 3,
                    img_preview: {url: 'https://igx.4sqi.net/img/general/300x300/92908739_SJBMuLzIL9tmqP4LxqUr8LOe6TXlZeZjyulUyraFfhM.jpg'},
                },
                {
                    id: 2,
                    list_name: 'My lovely places',
                    places_count: 10,
                    img_preview: {url: 'https://igx.4sqi.net/img/general/600x600/27381066_k87F2v_9Ia4ku4AlkoFdSlOGZ2e2RrpAZUMXEo3I1aE.jpg'},
                },
                {
                    id: 3,
                    list_name: 'Best for business-lunch',
                    places_count: 16,
                    img_preview: {url: 'https://igx.4sqi.net/img/general/600x600/21954114_gdTnllqvC6Ru17n02BknY0HdSfu8tOuK7nKH-dYfcls.jpg'},
                }
            ]
        };
    },
    components: {UserListsItem},
};
</script>

<style lang="scss" scoped>
    section {
        background: #FFF;
        min-height: calc(100vh - 42px);
    }

    li {
        padding-left: 1rem;
        display: flex;
    }

    ul {
        list-style: none;
    }

    .index {
        width: 10%;
        text-align: center;
        color: grey;
    }

    @media  (max-width: 1223px) {
        .columns {
            padding-top: 2.5rem;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }

    @media  (min-width: 1224px) {
        .columns {
            padding-top: 2.5rem;
            padding-left: calc((100% - 300px * 3) / 2);
            padding-right: calc((100% - 300px * 3) / 2);
        }
    }

    @media (min-width: 520px) and (max-width: 845px) {


        .columns.is-multiline {
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            display: flex;
            height: 100vh;
        }
    }

</style>
