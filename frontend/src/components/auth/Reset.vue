<template>
    <Container title="Reset your password">
        <Form>
            <b-field
                label="Email"
                :type="input.email.type"
            >

                <b-input
                    v-model="user.email"
                    placeholder="Your Email"
                    name="email"
                    @blur="onBlur('email')"
                    @focus="onFocus('email')"
                    autofocus
                />
            </b-field>
      
            <b-field
                label="New password"
                :type="input.password.type"
            >

                <b-input 
                    type="password"
                    v-model="user.password"
                    placeholder="New password"
                    password-reveal
                    @blur="onBlur('password')"
                    @focus="onFocus('password')"
                    autofocus
                />
            </b-field>

            <b-field
                label="Confirm new password"
                :type="input.passwordConfirm.type"
            >

                <b-input
                    type="password"
                    v-model="user.passwordConfirm"
                    placeholder="New password"
                    password-reveal
                    @blur="onBlur('passwordConfirm')"
                    @focus="onFocus('passwordConfirm')"
                    @keyup.enter="onReset"
                />
            </b-field>

            <button
                type="button"
                class="button is-primary is-rounded is-hovered button-wide"
                @click="onReset"
                @keyup.enter="onReset"
            >
                Reset
            </button>
        </Form>
    </Container>
</template>

<script>
import { required, email, minLength } from 'vuelidate/lib/validators';
import { mapGetters, mapActions } from 'vuex';
import Container from './Container';
import Form from './Form';

export default {
    components: {
        Container,
        Form
    },

    data: function () {
        return {
            user: {
                email: '',
                password: '',
                passwordConfirm: ''
            },

            input: {
                email: {
                    type: ''
                },
                password: {
                    type: ''
                },
                passwordConfirm: {
                    type: ''
                }
            }
        };
    },

    methods: {
        ...mapActions(['resetPassword']),

        onReset () {
            if (!this.$v.user.$invalid) {
                this.resetPassword({
                    email: this.user.email,
                    password: this.user.password,
                    passwordConfirmation: this.user.passwordConfirm,
                    token: this.$store.getters.getToken
                });

                this.refreshInput();
            }
        },

        onBlur (el) {
            if (this.$v.user[el].$invalid) {
                this.input[el].type = 'is-danger';
            } else {
                this.input[el].type = 'is-success';
            }
        },

        onFocus (el) {
            this.input[el].type = '';
        },

        refreshInput () {
            this.user = {
                email: '',
                password: '',
                passwordConfirm: ''
            },

            this.input = {
                email: {
                    type: ''
                },
                password: {
                    type: ''
                },
                passwordConfirm: {
                    type: ''
                }
            };
        }
    }, 

    validations: {
        user: {
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(6)
            },
            passwordConfirm: {
                required,
                minLength: minLength(6)
            }
        }
    }
};
</script>

<style>

</style>
