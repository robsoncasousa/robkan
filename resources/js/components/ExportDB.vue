<template>
    <div class="export">
        <a href="/export" target="_blank" class="export__button">Export DB</a>
    </div>
</template>

<script>
export default {
    name: "ExportDB",
}
</script>

<style lang="scss" scoped>
    .export {
        position: absolute;
        right: 30px;
        bottom: 30px;

        &__button {
            display: inline-block;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            opacity: 0.7;

            &:hover {
                opacity: 0.9;
            }
        }
    }
</style>
