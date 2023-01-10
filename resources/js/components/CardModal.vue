<template>
    <modal name="card-edit" transition="pop-out" :width="modalWidth" :focus-trap="true" :height="370" style="top: 30px">
        <div class="card_modal">
            <div class="card_modal__title">Edit Card</div>
            <div>
                <form autocomplete="false" class="form">
                    <input v-model="form.title" class="form__title" type="text" placeholder="Type a title">
                    <textarea v-model="form.description" class="form__description" type="text" placeholder="Type a description to this card"></textarea>
                </form>

                <div class="card_modal__buttons">
                    <button class="card_modal__cancel" @click="$modal.hide('card-edit')">Cancel</button>
                    <button class="card_modal__save" @click="save">Save</button>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
import axios from "axios";

const MODAL_WIDTH = 656
export default {
    name: "CardModal",
    props: {
        card: {},
    },
    data() {
        return {
            modalWidth: MODAL_WIDTH,
            form: {},
        }
    },
    created() {
        this.modalWidth =
            window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
    },
    methods: {
        save() {
            axios.put(
                '/api/cards/' + this.card.id,
                {title: this.form.title, description: this.form.description}
            ).then(res => {
                this.$modal.hide('card-edit')
            })
        },
    },
    watch: {
        card: {
            immediate: true,
            handler (newVal, oldVal) {
                this.form = newVal;
            }
        },
    },
}
</script>

<style lang="scss" scoped>
.card_modal {
    padding: 30px;
    height: 100%;
    background-color: #f2f2f2;

    &__title {
        font-size: 20px;
        text-align: center;
        padding: 15px;
    }
    &__buttons {
        display: flex;
        justify-content: flex-end;
        width: 100%;
        padding: 0px 20px;
    }
    &__save {
        padding: 10px 30px;
        border-radius: 4px;
        background-color: #108bf5;
        color: #fff;
        cursor: pointer;
        &:hover {
            opacity: 0.9;
        }
    }
    &__cancel {
        padding: 10px 30px;
        border-radius: 4px;
        background-color: #ddd;
        color: #222;
        margin-right: 20px;
        display: flex;
        cursor: pointer;
        &:hover {
            opacity: 0.9;
        }
    }
}
.form {
    padding: 20px;
    display: flex;
    flex-direction: column;
    height: 200px;
    justify-content: space-between;

    &__title {
        border: 1px solid #ddd;
        padding: 10px 10px;
        border-radius: 4px;
    }

    &__description {
        border: 1px solid #ddd;
        padding: 10px 10px;
        border-radius: 4px;
        height: 100px;
        resize: none;
    }
}
hr {
    border: 1px solid #eee;
    margin-bottom: 20px;
}
</style>
