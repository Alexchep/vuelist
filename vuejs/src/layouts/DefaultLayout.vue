<template>
    <v-app id="default-layout">
        <navbar :user="user"/>
        <router-view/>
        <v-btn class="mb-6" v-scroll="onScroll" v-show="fab" fab dark fixed bottom right color="indigo" @click="toTop">
            <v-icon>keyboard_arrow_up</v-icon>
        </v-btn>
    </v-app>
</template>

<script>
    import Navbar from "./Navbar";
    import authService from "../services/auth_service";

    export default {
        name: "DefaultLayout",
        components: {Navbar},
        data() {
            return {
                user: {},
                fab: false
            }
        },
        methods: {
            onScroll(e) {
                if (typeof window === 'undefined') {
                    return;
                }

                const top = window.pageYOffset || e.target.scrollTop || 0
                this.fab = top > 20;
            },
            toTop() {
                this.$vuetify.goTo(0);
            }
        },
        async beforeMount() {
            this.user = await authService.getCurrentUser();
        }
    }
</script>