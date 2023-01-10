<template>
    <div @click="$modal.show('card-edit', {title: 'asdasd'})">
        {{ card.title }}
    </div>
</template>

<script>
export default {
    name: "Card",
    props: {
        card: {}
    },
    methods: {
    }
}
</script>
