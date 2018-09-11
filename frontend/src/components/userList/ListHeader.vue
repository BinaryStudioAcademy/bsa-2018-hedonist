<template>
    <div class="wrapper-list">
        <div class="level list-data top is-mobile">
            <div class="level-left top top__left">
                <figure class="media-left image is-128x128">
                    <img :src="listItem.img_url || listImage">
                </figure>
            </div>
            <div class="top__right">
                <h3 class="title">
                    {{ listItem.name }}
                </h3>
                <ShareDropdown
                    class="share-button"
                    :link="pageLink"
                    :text="pageTitle"
                />
            </div>
        </div>
        <div class="level list-data is-mobile">
            <div class="list-data__user-data level-left">
                <figure class="image is-64x64 level-item">
                    <img :src="listItem.user.avatar_url" class="avatar">
                </figure>
                <div class="list-data__creator-name">
                    {{ $t('user_lists_page.header.author') }}
                    <router-link
                        :to="{ name: 'OtherUserPage', params: { id: listItem.user.id } }"
                        class="has-text-info"
                    >
                        {{ userName }}
                    </router-link>
                </div>
            </div>
            <div class="list-data__updated-at level-right">
                {{ $t('user_lists_page.header.updated') }}
                {{ listItem.updated_at }}
            </div>
        </div>
    </div>
</template>

<script>
import ShareDropdown from '@/components/misc/ShareDropdown';
import imageStub from '@/assets/no-photo.png';

export default {
    name: 'ListHeader',
    components: {ShareDropdown},
    comments: {
        ShareDropdown
    },
    props: {
        listItem:{
            required:true,
            type: Object
        },
        defaultImage: {
            required: true,
            type: String
        }
    },
    data() {
        return {
            imageStub: imageStub
        };
    },
    computed: {
        userName(){
            return this.listItem.user.first_name + ' ' + this.listItem.user.last_name;
        },
        pageLink() {
            return location.href;
        },
        pageTitle() {
            return this.listItem.name;
        },
        listImage() {
            return this.defaultImage ? this.defaultImage : this.imageStub;
        }
    }
};
</script>

<style lang="scss" scoped>
    .wrapper-list{
        background: #FFF;
        margin-bottom: 1rem;
    }

    .list-image{
        margin-bottom:1rem;

        &__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 50%;
        }
    }

    .title{
        padding-left:10px;
    }

    .list-data{
        padding:0 10px 1rem 10px;
        &__user-data {
            .image{
                margin-right: 5px;
            }
            .avatar{
                border-radius: 4px;
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: 50% 50%;
            }
        }

        &__updated-at{
            color:grey;
        }
    }

    .top {
        display: flex;
        align-items: flex-start;
        margin-bottom: 0px;
        padding-top: 10px;
        
        &__left{
            display: flex;
            align-items: flex-start;
            margin-bottom: 0px;
            padding-top: 0px;
        }

        &__right {
            width: 100%;

            .share-button {
                float: right;
            }
        }
    }
</style>