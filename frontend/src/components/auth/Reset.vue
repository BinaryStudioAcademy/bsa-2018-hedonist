<template>
    <Container :title="$t('reset_page.title')">
        <Form>
            <b-field
                :label="$t('inputs.auth.email.field_name')"
                :type="input.email.type"
            >

                <b-input
                    v-model="user.email"
                    :placeholder="$t('inputs.auth.email.placeholder')"
                    name="email"
                    @blur="onBlur('email')"
                    @focus="onFocus('email')"
                    autofocus
                />
            </b-field>
      
            <b-field
                :label="$t('inputs.auth.password.field_name')"
                :type="input.password.type"
            >

                <b-input 
                    type="password"
                    v-model="user.password"
                    :placeholder="$t('inputs.auth.password.placeholder')"
                    password-reveal
                    @blur="onBlur('password')"
                    @focus="onFocus('password')"
                    autofocus
                />
            </b-field>

            <b-field
                label="$t('inputs.auth.new_password.field_name')"
                :type="input.passwordConfirm.type"
            >

                <b-input
                    type="password"
                    v-model="user.passwordConfirm"
                    :placeholder="$t('inputs.auth.new_password.placeholder')"
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
                {{ $t('reset_page.buttons.submit') }}
            </button>
        </Form>
    </Container>
</template>

<script>
import { required, email, minLength } from 'vuelidate/lib/validators';
import { mapActions } from 'vuex';
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
        ...mapActions({
            resetPassword: 'auth/resetPassword'
        }),

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
