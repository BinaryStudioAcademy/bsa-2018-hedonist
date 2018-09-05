<template>
    <span 
        class="tag is-primary is-rounded"
        :class="{ active: isActive }"
        :style="{ backgroundColor: color }"
        @click="onClick"
    >
        {{ tag.name }}
        <button v-if="isActive" class="delete is-small" />
    </span>     
</template>

<script>
export default {
    name: 'PlaceFilterTag',

    props: {
        tag: {
            required: true,
            type: Object,
        },
        color: {
            required: false,
            type: String,
            default: '#7957d5'
        },
    },

    data() {
        return {
            isActive: false
        };
    },

    methods: {
        onClick() {
            this.isActive = !this.isActive;
            this.$emit('onSelectTag', this.tag.id, this.isActive);
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
