<template>
    <i
        :class="[ 'far', 'fa-2x', icon ]"
        @mouseover="$emit('onHover', value)"
        @click="$emit('onSelect', value)"
    ></i>    
</template>

<script>
export default {
    name: 'Smiley',

    props: {
        value: {
            type: Number,
            required: true
        },

        icon: {
            type: String,
            required: true
        }
    }
}
</script>

<style lang="scss" scoped>
i {
    border-radius: 50%;

    &:hover {
        background-color: yellow;
        cursor: pointer;
    }
}
</style>
