<template>
    <div>
        <div class="column__title_flexbox">
            <h3 class="column__title" @click="editColumnTitle(column)">{{ column.title }}</h3>
            <a href="#" title="Delete" class="column__delete" @click="deleteColumn(column)">X</a>
        </div>

        <draggable v-model="column.cards" group="cards"  @start="drag=true" @end="updateColumnsOrder">
            <Card
                v-for="(card, index) in column.cards"
                :key="index"
                class="card"
                :card="card"
                v-on="$listeners"
            />
        </draggable>

        <div v-if="column.showNewCardForm" class="form">
            <textarea v-model="newCard.title" @keydown.enter.prevent="saveNewCard(column)" :ref="column.id + '_card_input_text'" type="text" class="form__input" placeholder="Type a title to this card"></textarea>
            <div class="form__buttons">
                <a href="#" class="form__save" @click.prevent="saveNewCard(column)">Save</a>
                <a href="#" class="form__close" @click="closeCardForm(column)">X</a>
            </div>
        </div>

        <div v-else class="column__add_card_button" @click.prevent="openNewCardForm(column)">
            + Add Another card
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import axios from "axios";
import Card from "./Card";

export default {
    name: "Column",
    components: { draggable, Card },
    props: {
        column: {},
        newCard: {}
    },
    emits: [
        'updateColumnsOrder'
    ],
    data() {
        return {
            columns: [],
        }
    },
    methods: {
        editColumnTitle(column) {
            alert('editing title for ' + column.title)
        },
        closeColumnCard() {
            this.newColumn.formOpened = false
        },
        deleteColumn(column) {
            this.$emit('deleteColumn', column)
        },
        updateColumnsOrder(column) {
            this.$emit('updateColumnsOrder', column)
        },
        closeCardForm(column) {
            this.$emit('closeCardForm', column)
        },
        openNewCardForm(column) {
            this.$emit('openNewCardForm', column)
            this.$nextTick(() => {
                this.$refs[column.id +'_card_input_text'].focus()
            })
        },
        loadColumns(column) {
            this.$emit('loadColumns', column)
        },
        saveNewCard(column) {
            let card = {
                title: this.newCard.title,
                column_id: column.id,
            }
            axios.post(
                '/api/cards',
                card,
                {
                    headers: {
                        "Content-type": "application/json"
                    }
                })
                .then(res => {
                    if (res.data.status) {
                        this.loadColumns()

                        this.newCard.title = ''
                        this.$nextTick(() => {
                            this.$refs[column.id +'_card_input_text'].focus()
                        })
                    } else {
                        this.error = true;
                    }
                })
        },

    },
}
</script>
