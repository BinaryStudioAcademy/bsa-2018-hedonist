<template>
    <b-dropdown>
        <button class="button is-primary" slot="trigger"> 
            <span class="btn-icon"><i class="far fa-share-square" /></span>
                {{ $t('place_page.buttons.share.title') }}
            <b-icon icon="menu-down" />
        </button>

        <b-dropdown-item has-link>
            <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + link" target="_blank">
                <i class="fab fa-facebook-square" />
                {{ $t('place_page.buttons.share.on_facebook') }}
            </a>
            <a :href="'http://twitter.com/share?text=' + text + '&hashtags=hedonist,binaryacademy&url=' + link" target="_blank">
                <i class="fab fa-twitter-square" />
                {{ $t('place_page.buttons.share.on_twitter') }}
            </a>
        </b-dropdown-item>
    </b-dropdown>
</template>

<script>
export default {
    name: 'ShareDropdown',
    props: {
        text: {
            required: true,
            type: String
        },
        link: {
            required: true,
            type: String
        }
    }
};
</script>

<style scoped>
.btn-icon{
        padding-right: 7px;
    }
</style>