<template>
    <div class="wrapper-list">
        <figure class="image is-5by3 list-image">
            <img :src="listItem.img_url || imageStub">
        </figure>
        <div class="level list-data is-mobile">
            <div class="level-left">
                <h3 class="title">
                    {{ listItem.name }}
                </h3>
            </div>
            <div class="level-right">
                <ShareDropdown
                    :link="pageLink"
                    :text="pageTitle"
                />
            </div>
        </div>
        <div class="level list-data is-mobile">
            <div class="list-data__user-data level-left">
                <figure class="image is-32x32 level-item">
                    <img :src="listItem.user.avatar_url" class="avatar">
                </figure>
                <div class="list-data__creator-name">
                    by <a href="#" class="has-text-info">{{ userName }}</a>
                </div>
            </div>
            <div class="list-data__updated-at level-right">
                Updated at: {{ listItem.updated_at }}
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