<template>
    <div class="wrapper-list">
        <figure class="image is-5by3 list-image">
            <img :src="listItem.img_url" />
        </figure>
        <h3 class="title">
            {{listItem.name}}
        </h3>
        <div class="level list-data is-mobile">
            <div class="list-data__user-data level-left">
                <figure class="image is-32x32">
                    <img :src="listItem.user.avatar_url" class="avatar" />
                </figure>
                <div class="list-data__creator-name">
                    by <a href="#" class="has-text-info">{{userName}}</a>
                </div>
            </div>
            <div class="list-data__updated-at level-right">
                Updated at:{{listItem.updated_at}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ListHeader",
        props: {
            listItem:{
                required:true,
                type: Object
            }
        },
        computed: {
            userName(){
                return this.listItem.user.first_name + ' ' + this.listItem.user.last_name;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .wrapper-list{
        background: #FFF;
    }

    .list-image{
        margin-bottom:1rem;
    }

    .title{
        padding-left:10px;
    }

    .list-data{
        padding:0 10px 1rem 10px;
        &__user-data{
            .image{
                margin-right: 5px;
            }
            .avatar{
                border-radius: 4px;
            }
        }

        &__updated-at{
            color:grey;
        }
    }

</style>