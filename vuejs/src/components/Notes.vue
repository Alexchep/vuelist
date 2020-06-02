<template>
    <v-app>
        <v-dialog v-model="dialog" persistent max-width="400px">
            <template v-slot:activator="{on}">
                <v-btn class="create-button" dark fab top fixed bottom left color="green" v-on="on">
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="headline">Creating note</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <div v-if="errors" class="errors">
                                    <v-alert mode="dense" type="error" color="red" border="left" text :key="field"
                                             v-for="(error, field) in errors[0]">
                                        {{error[0].message}}
                                    </v-alert>
                                </div>
                                <v-form @submit.prevent="addNote" action="" v-model="valid" ref="form">
                                    <v-text-field v-model="form.title" :rules="titleRules" label="Title"></v-text-field>
                                    <v-text-field v-model="form.body" :rules="bodyRules" label="Body"></v-text-field>
                                </v-form>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="resetValidation">Close</v-btn>
                    <v-btn :disabled="!valid" class="create-button" @click="addNote" color="info">Create</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-row class="notes pa-md-5 pa-sm-4 pa-4 mb-6">
            <note v-for="(note, index) in notes" :key="index" :note="note"
                  @deleteNote="deleteNote" @updateNote="updateNote"/>
        </v-row>
    </v-app>
</template>

<script>
    import Note from "./Note";
    import notesService from "../services/notes_service";

    export default {
        name: "Notes",
        components: {Note},
        data() {
            return {
                dialog: false,
                notes: [],
                form: {
                    title: '',
                    body: ''
                },
                errors: null,
                valid: true,
                titleRules: [
                    v => !!v || 'Title is required',
                    v => v.length <= 25 || 'Max length of title is 25 characters'
                ],
                bodyRules: [
                    v => v.length <= 100 || 'Max length of body is 100 characters',
                ]
            }
        },
        methods: {
            resetValidation() {
                this.dialog = false;
                this.$refs.form.resetValidation();
            },
            async addNote() {
                if (!this.$refs.form.validate()) {
                    return false;
                }

                const {status, data} = await notesService.create(this.form);

                if (status === 201) {
                    this.form.title = '';
                    this.form.body = '';
                    this.notes.unshift(data);
                    this.dialog = false;
                } else {
                    this.errors = data;
                }
            },
            async updateNote(note) {
                const response = await notesService.update(note);
            },
            async deleteNote(note) {
                const {status, data} = await notesService.delete(note.id);

                if (status === 204) {
                    this.notes.splice(this.notes.indexOf(note), 1);
                }
            }
        },
        async mounted() {
            const {status, data} = await notesService.get();

            if (status === 200) {
                this.notes = data;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .notes {
        margin-top: 120px;
    }
</style>