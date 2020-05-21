<template>
    <v-app-bar absolute color="#fcb69f" dark shrink-on-scroll src="../assets/pencil.jpg">
        <template v-slot:img="{ props }">
            <v-img v-bind="props" gradient="to top left, rgba(19,84,122,.5), rgba(128,208,199,.8)"/>
        </template>
        <v-toolbar-title>ToDo List</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-chip class="ma-2" color="indigo" text-color="white">
            <v-avatar left>
                <v-icon>mdi-account-circle</v-icon>
            </v-avatar>
            {{user.username}}
        </v-chip>
        <div class="text-center">
            <v-bottom-sheet v-model="sheet" width="70%">
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                        <v-icon>mdi-frequently-asked-questions</v-icon>
                    </v-btn>
                </template>
                <v-sheet height="350px">
                    <h2 class="text-center">Hey, fellow!</h2>
                    <p class="text-center">This's short FAQ:</p>
                    <v-expansion-panels accordion>
                        <v-expansion-panel v-for="(item, i) in faqItems" :key="i">
                            <v-expansion-panel-header>{{item.title}}</v-expansion-panel-header>
                            <v-expansion-panel-content>{{item.body}}</v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </v-sheet>
            </v-bottom-sheet>
        </div>
        <v-btn icon @click="logout" title="Logout">
            <v-icon>mdi-export</v-icon>
        </v-btn>
    </v-app-bar>
</template>

<script>
    import authService from "../services/auth_service";

    export default {
        name: "Navbar",
        data: () => ({
            sheet: false,
            faqItems: [
                {
                    'title': 'Creating note',
                    'body': 'Create your note with plus button (top left side)'
                },
                {
                    'title': 'Editing note',
                    'body': 'Edit existing note with click on note\'s title or body'
                },
                {
                    'title': 'Deleting note',
                    'body': 'Delete note with click on trash icon which situated right from title'
                }
            ]
        }),
        props: {
            user: Object
        },
        methods: {
            logout() {
                authService.logout();
            }
        }
    }
</script>