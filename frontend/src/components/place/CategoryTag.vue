<template>
    <span 
        class="tag is-primary is-rounded"
        :class="{ active: isActive }"
        @click="onClick"
    >
        {{ tag.name }}
        <button v-if="isActive" class="delete is-small"></button>
    </span>     
</template>

<script>
export default {
    name: 'CategoryTag',

    props: {
        tag: {
            required: true,
            type: Object,
        },
    },

    data() {
        return {
            isActive: false
        }
    },

    methods: {
        onClick() {
            this.isActive = !this.isActive;
        }
    },
};
</script>

<style lang="scss" scoped>
    @mixin darkenBackground {
        background-color: darken(#7957D5, 10%) !important;
    }
    
    .tag {
        &:hover {
            @include darkenBackground;
            cursor: pointer;
        }
    }

    .active {
        @include darkenBackground;
    }
</style>
