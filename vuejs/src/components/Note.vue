<template>
    <v-col md="4" sm="4" xs="3">
        <v-hover v-slot:default="{ hover }" close-delay="100">
            <v-card :elevation="hover ? 10 : 5" color="grey lighten-5" height="180px" min-width="180px" class="radius-card">
                <v-toolbar class="elevation-5" color="blue lighten-4">
                    <v-toolbar-title contenteditable @blur="titleChanged">{{note.title}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn @click="deleteNote" icon>
                        <v-icon>mdi-delete-circle</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-card-text contenteditable @blur="bodyChanged">{{note.body}}</v-card-text>
            </v-card>
        </v-hover>
    </v-col>
</template>

<script>
    export default {
        name: "Note",
        props: {
            note: {
                type: Object,
                required: true
            }
        },
        methods: {
            deleteNote() {
                this.$emit('deleteNote', this.note);
            },
            titleChanged($event) {
                this.note.title = $event.target.innerHTML;
                this.$emit('updateNote', this.note)
            },
            bodyChanged($event) {
                this.note.body = $event.target.innerHTML;
                this.$emit('updateNote', this.note)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .radius-card {
        border-radius: 25px!important;
    }
</style>