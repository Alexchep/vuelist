<template>
    <v-app>
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" dark flat>
                                <v-toolbar-title>Register form</v-toolbar-title>
                                <v-spacer></v-spacer>
                            </v-toolbar>
                            <v-card-text>
                                <div v-if="errors" class="errors">
                                    <v-alert type="error" color="red" border="left" text :key="field"
                                             v-for="(error, field) in errors">
                                        {{error[0]}}
                                    </v-alert>
                                </div>
                                <v-form @submit.prevent="register" action="">
                                    <v-text-field v-model="form.username" label="Username" prepend-icon="person"
                                                  type="text" required></v-text-field>
                                    <v-text-field v-model="form.password" label="Password" prepend-icon="lock"
                                                  type="password" required></v-text-field>
                                    <v-text-field v-model="form.password_repeat" label="Password repeat" prepend-icon="lock"
                                                  type="password" required></v-text-field>
                                    <v-card-actions>
                                        <router-link to="/login" class="link">Click here to login</router-link>
                                        <v-spacer></v-spacer>
                                        <v-btn type="submit" color="primary">Register</v-btn>
                                    </v-card-actions>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import authService from "../services/auth_service";

    export default {
        name: "Registration",
        data() {
            return {
                form: {
                    username: '',
                    password: '',
                    password_repeat: ''
                },
                errors: null
            }
        },
        methods: {
            async register() {
                const {success, errors} = await authService.register(this.form);

                if (success) {
                    this.$router.push({name: 'home'});
                } else {
                    this.errors = errors;
                }
            }
        }
    }
</script>