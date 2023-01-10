<template>
    <div class="board">
        <card-modal :card="clickedCard" @before-close="clickedCard = {}"/>

        <div class="card_listing">
            <draggable class="flex" v-model="columns" group="columns" @start="drag=true" @end="updateColumnsOrder">
                <Column v-for="(column, index) in columns"
                        :key="index"
                        class="column"
                        :column="column"
                        :newCard="newCard"
                        @updateColumnsOrder="updateColumnsOrder"
                        @openNewCardForm="openNewCardForm"
                        @closeCardForm="closeCardForm"
                        @deleteColumn="deleteColumn"
                        @loadColumns="loadColumns"
                        @openCardModal="openCardModal"
                />
            </draggable>

            <div v-if="newColumn.formOpened" class="form form_column">
                <textarea v-model="newColumn.title" @keydown.enter.prevent="saveNewColumn" ref="column_input_text" type="text" class="form__input" placeholder="Type a title to this column"></textarea>
                <div class="form__buttons">
                    <a href="#" class="form__save" @click.prevent="saveNewColumn">Save</a>
                    <a href="#" class="form__close form__close--dark" @click="closeColumnCard">X</a>
                </div>
            </div>
            <div class="card_listing__box_flex_buton">
                <a v-if="! newColumn.formOpened" href="#" class="card_listing__add_button" @click.prevent="addColumn">+ Add Another Column</a>
            </div>
        </div>
        <export-d-b></export-d-b>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import axios from "axios";
    import Column from '../components/Column'
    import CardModal from "../components/CardModal"
    import ExportDB from "../components/ExportDB";

    export default {
        name: "Index",
        components: {draggable, Column, CardModal, ExportDB},
        data() {
            return {
                columns: [],
                newCard: {
                    title: '',
                    formOpened: false,
                },
                newColumn: {
                    title: '',
                    formOpened: false,
                },
                clickedCard: {}
            }
        },
        methods: {
            addColumn() {
                this.newColumn.formOpened = true
                this.$nextTick(() => {
                    this.$refs.column_input_text.focus()
                });
            },
            saveNewColumn () {
                let column = {
                    title: this.newColumn.title,
                }
                axios.post(
                    '/api/columns',
                    column,
                    {
                        headers: {
                            "Content-type": "application/json"
                        }
                    })
                    .then(res => {
                        if (res.data.status) {
                            let column = res.data.column
                            column.showNewCardForm = false

                            this.columns.push(column)
                            this.newColumn.title = ''
                            this.closeColumnCard()
                        } else {
                            this.error = true;
                        }
                    })
            },
            closeColumnCard() {
                this.newColumn.formOpened = false
            },
            openNewCardForm(column) {
                if (this.newCard.formOpened) {
                    this.columns.forEach(column => {
                        if (column.showNewCardForm) {
                            column.showNewCardForm = false
                        }
                    })
                }

                column.showNewCardForm = true
                this.newCard.formOpened = true

                // this.$nextTick(() => {
                //     this.$refs[column.id +'_card_input_text'].focus()
                // });
            },
            closeCardForm(column) {
                column.showNewCardForm = false
                this.newCard.formOpened = false
            },
            deleteColumn(column) {
                if (!confirm('Are you sure you want delete the column and its cards?')) {
                    return false
                }

                axios.delete('/api/columns/' + column.id)
                this.loadColumns()
            },
            loadColumns() {
                axios.get('/api/columns')
                    .then(res => {
                        let columns = res.data
                        columns.forEach((column, index) => {
                            columns[index].showNewCardForm = false
                        });
                        this.columns = columns
                    })
            },
            updateColumnsOrder() {
                //update column_id from cards
                this.columns.forEach((column, columnIndex) => {
                    column.cards.forEach((card, cardIndex) => {
                        this.columns[columnIndex].cards[cardIndex].column_id = column.id
                    })
                })

                //get columns order
                let columns = this.columns.map(function(column, index) {
                    return { column: column.id, order: index }
                })

                //get cards order and column_id
                let items = this.columns.map(function(column, index) {
                    let items = column.cards?.map(function(card, index) {
                        return { card: card.id, order: index, column_id: card.column_id }
                    })

                    return items;
                })

                //merge cards objects
                let cards = []
                items.forEach(item => item.forEach(item => cards.push(item)))

                //save order
                axios.post('/api/columns/update-order', {columns, cards})
            },
            openCardModal(card) {
                this.clickedCard = card
                this.$modal.show('card-edit')
            },
        },
        mounted() {
            this.loadColumns()
        }
    }
</script>
