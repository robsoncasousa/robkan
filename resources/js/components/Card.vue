<template>
    <div @click="openModal">
        {{ card.title }}
    </div>
</template>

<script>
export default {
    name: "Card",
    props: {
        card: {}
    },
    emits: ['openCardModal'],
    methods: {
        openModal() {
            this.$emit('openCardModal', this.card)
        }
    }
}
</script>
