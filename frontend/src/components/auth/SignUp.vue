<template>
    <Container :title="$t('signup_page.title')">
        <Form>
            <b-field
                :label="$t('inputs.auth.first_name.field_name')"
                :type="type('firstName')"
            >
                <b-input
                    name="firstName"
                    v-model="newUser.firstName"
                    :placeholder="$t('inputs.auth.first_name.placeholder')"
                    @blur="onBlur('firstName')"
                    @focus="onFocus('firstName')"
                />
            </b-field>
            <div 
                class="error"
                v-if="!$v.newUser.firstName.required && !focus.firstName"
            >
                {{ $t('validation.required',{field:$t('inputs.auth.first_name.field_name')}) }}</div>
            <div 
                class="error"
                v-if="!$v.newUser.firstName.alpha && !focus.firstName"
            >
                {{ $t('validation.letters_only') }}
            </div>

            <b-field
                :label="$t('inputs.auth.last_name.field_name')"
                :type="type('lastName')"
            >
                <b-input
                    name="lastName"
                    v-model="newUser.lastName"
                    :placeholder="$t('inputs.auth.last_name.placeholder')"
                    @blur="onBlur('lastName')"
                    @focus="onFocus('lastName')"
                />
            </b-field>
            <div 
                class="error"
                v-if="!$v.newUser.lastName.required && !focus.lastName"
            >
                {{ $t('validation.required',{field:$t('inputs.auth.last_name.field_name')}) }}</div>
            <div 
                class="error"
                v-if="!$v.newUser.lastName.alpha && !focus.lastName"
            >
                {{ $t('validation.letters_only') }}
            </div>

            <b-field
                :label="$t('inputs.auth.email.field_name')"
                :type="type('email')"
            >

                <b-input
                    v-model="newUser.email"
                    :placeholder="$t('inputs.auth.email.placeholder')"
                    name="email"
                    @blur="onBlur('email')"
                    @focus="onFocus('email')"
                />
            </b-field>
            <div 
                class="error"
                v-if="!$v.newUser.email.required && !focus.email"
            >
                {{ $t("validation.required",{field:$t("inputs.auth.email.field_name")}) }}</div>
            <div 
                class="error"
                v-if="!$v.newUser.email.email && !focus.email"
            >
                {{ $t('validation.wrong_email_format') }}</div>
            <div 
                class="error"
                v-if="!$v.newUser.email.isUnique && !focus.email"
            >
                {{ $t('validation.email_exists') }}</div>
            <div class="field">
                <label class="label">
                    {{ $t('inputs.auth.password.field_name') }} <span class="grayed">{{ $t('inputs.auth.password.description') }}</span>
                </label>
            </div>
            <b-field
                :type="type('password')"
            >

                <b-input 
                    type="password"
                    v-model="newUser.password"
                    :placeholder="$t('inputs.auth.password.placeholder')"
                    @blur="onBlur('password')"
                    @focus="onFocus('password')"
                    @keyup.native.enter="onSignUp"
                    password-reveal
                />
            </b-field>
            <div 
                class="error"
                v-if="!$v.newUser.password.required && !focus.password"
            >
                {{ $t('validation.required',{field:$t('inputs.auth.password.field_name')}) }}</div>
            <div 
                class="error"
                v-if="!$v.newUser.password.minLength && !focus.password"
            >
                {{ $t('validation.min_length',{min: 6}) }}</div>

            <button
                type="button"
                class="button is-primary is-rounded button-wide"
                @click="onSignUp"
            >
                {{ $t('signup_page.buttons.submit') }}
            </button>
        </Form>
    </Container>
</template>

<script>
import {required, email, minLength, alpha} from 'vuelidate/lib/validators';
import {mapActions} from 'vuex';
import Container from './Container';
import Form from './Form';

export default {
    components: {
        Container,
        Form
    },

    data: function () {
        return {
            newUser: {
                firstName: '',
                lastName: '',
                email: '',
                password: '',
                language: this.$i18n.locale(),
            },

            focus: {
                firstName: true,
                lastName: true,
                email: true,
                password: true
            },
        };
    },

    methods: {
        ...mapActions({
            signUp          : 'auth/signUp',
            checkEmailUnique: 'auth/checkEmailUnique'
        }),

        type(el) {
            if (this.focus[el]) return '';
            return this.$v.newUser[el].$invalid ? 'is-danger' : 'is-success';
        },

        onSignUp () {
            if (!this.$v.newUser.$invalid) {
                let self = this;
                this.signUp(this.newUser)
                    .then((res) => {
                        if (res.error) {
                            this.onError(res.error);
                        } else {
                            this.refreshInput();
                            this.$router.push({name: 'LoginPage'});
                            this.onSuccess({
                                message: this.$t('messages.success.signup')
                            });
                        }
                    })
                    .catch(function (err) {
                        self.onError(err.response.data);
                    });
            } else {
                this.onError({
                    message: this.$t('messages.error.input')
                });
            }
        },

        onError (error) {
            this.$toast.open({
                message: error.error.message,
                type: 'is-danger'
            });
        },

        onSuccess (success) {
            this.$toast.open({
                message: success.message,
                type: 'is-success'
            });
        },

        onBlur (el) {
            this.focus[el] = false;
        },

        onFocus (el) {
            this.focus[el] = true;
        },

        refreshInput () {
            this.newUser = {
                firstName: '',
                lastName: '',
                email: '',
                password: ''
            },
            this.input = {
                email: {
                    type: ''
                },
                password: {
                    type: ''
                }
            };
        }
    },

    validations: {
        newUser: {
            firstName: {
                required,
                alpha
            },
            lastName: {
                required,
                alpha
            },
            email: {
                required,
                email,
                async isUnique(value) {
                    if (value === '') return true;
                    if(!this.$v.newUser.email.email) return true;
                    return new Promise((resolve, reject) => {
                        this.checkEmailUnique(value)
                            .then((res)=>{
                                resolve(res.email === value && res.isUnique);
                            })
                            .catch(function (err) {
                                reject(err);
                            });
                    });
                }
            },
            password: {
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
