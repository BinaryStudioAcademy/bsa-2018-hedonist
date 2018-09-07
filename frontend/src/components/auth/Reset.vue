<template>
    <Container :title="$t('reset_page.title')">
        <Form>
            <div class="field">
                <label class="label">
                    {{ $t('inputs.auth.password.field_name') }} <span class="grayed">{{ $t('inputs.auth.password.description') }}</span>
                </label>
            </div>
            <b-field
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
            <div
                class="error"
                v-if="!$v.user.password.required && input.password.type === 'is-danger'"
            >
                {{ $t('validation.required', {field:$t('inputs.auth.confirm_password.field_name')}) }}</div>
            <div
                class="error"
                v-if="!$v.user.password.minLength && input.password.type === 'is-danger'"
            >
                {{ $t('validation.min_length', {min: 6}) }}</div>

            <b-field
                :label="$t('inputs.auth.confirm_password.field_name')"
                :type="input.passwordConfirm.type"
            >

                <b-input
                    type="password"
                    v-model="user.passwordConfirm"
                    :placeholder="$t('inputs.auth.confirm_password.placeholder')"
                    password-reveal
                    @blur="onBlur('passwordConfirm')"
                    @focus="onFocus('passwordConfirm')"
                    @keyup.enter="onReset"
                />
            </b-field>
            <div
                class="error"
                v-if="!$v.user.passwordConfirm.required && input.passwordConfirm.type === 'is-danger'"
            >
                {{ $t('validation.required', {field:$t('inputs.auth.confirm_password.field_name')}) }}</div>
            <div
                class="error"
                v-if="!$v.user.passwordConfirm.minLength && input.passwordConfirm.type === 'is-danger'"
            >
                {{ $t('validation.min_length', {min: 6}) }}</div>

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
                password: '',
                passwordConfirm: ''
            },

            input: {
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
                    email: this.$store.state.route.query.email,
                    password: this.user.password,
                    passwordConfirmation: this.user.passwordConfirm,
                    token: this.$store.state.route.query.token
                })
                    .then(() => {
                        this.refreshInput();
                        this.$router.push({name: 'LoginPage'});
                        this.onSuccess({
                            message: this.$t('messages.success.changed_password')
                        });
                    })
                    .catch((error) => {
                        this.errorHandler(error);
                    });
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
                password: '',
                passwordConfirm: ''
            };

            this.input = {
                password: {
                    type: ''
                },
                passwordConfirm: {
                    type: ''
                }
            };
        },

        onError (error) {
            this.$toast.open({
                message: error.message,
                type: 'is-danger'
            });
        },

        onSuccess (success) {
            this.$toast.open({
                message: success.message,
                type: 'is-success'
            });
        },

        errorHandler (data) {
            let message = '';
            if (data.error !== undefined) {
                message = data.error.message;
            } else if (data.errors !== undefined) {
                for (let error in data.errors) {
                    data.errors[error].forEach(function(item) {
                        message += item + '<br>';
                    });
                }
            }
            this.onError({
                message: message
            });
        },
    }, 

    validations: {
        user: {
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

<style scoped>
    .error {
        color: red;
    }
    .field:not(:last-child) {
        margin-bottom: 0;
        margin-top: 0.75rem;
    }
    .button {
        margin-top: 1.5rem;
    }
    .grayed {
        color: darkgray;
        font-size: .8em;
        font-weight: normal;
    }
</style>
