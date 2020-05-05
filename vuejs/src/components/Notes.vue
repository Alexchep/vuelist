<template>
    <div class="tc-notes-wrapper">
        <add-new-button @addNote="addNote" />
        <div class="tc-notes">
            <note v-for="(note, index) in notes" :key="index" :note="note"
                  @deleteNote="deleteNote" @noteUpdated="noteUpdated"/>
        </div>
    </div>
</template>

<script>
    import AddNewButton from "./AddNewButton";
    import Note from "./Note";

    export default {
        name: "Notes",
        components: {Note, AddNewButton},
        data() {
            return {
                notes: [
                    {title: 'First note', body: 'I am the 1st note'},
                    {title: 'Second note', body: 'I am the 2st note'},
                    {title: 'Third note', body: 'I am the 3st note'},
                    {title: 'Fourth note', body: 'I am the 4st note'},
                    {title: 'Fifth note', body: 'I am the 5st note'}
                ]
            }
        },
        methods: {
            addNote() {
                this.notes.unshift({title: '', body: ''});
            },
            deleteNote(note) {
                this.notes.splice(this.notes.indexOf(note), 1);
            },
            noteUpdated(note) {
                console.log(note);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .tc-notes-wrapper {
        padding: 30px;

        .tc-notes {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 0 auto;
        }
    }
</style>