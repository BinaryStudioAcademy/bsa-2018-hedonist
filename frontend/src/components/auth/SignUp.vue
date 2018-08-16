<template>
    <Container title="Create new account">
        <Form>
            <b-field
                label="First name"
                :type="type('firstName')"
            >
                <b-input
                    name="firstName"
                    v-model="newUser.firstName"
                    placeholder="Your first name"
                    @blur="onBlur('firstName')"
                    @focus="onFocus('firstName')"
                />
            </b-field>
            <div 
                class="error"
                v-if="!$v.newUser.firstName.required && !focus.firstName"
            >
                First name is required.</div>
            <div 
                class="error"
                v-if="!$v.newUser.firstName.alpha && !focus.firstName"
            >
                Only letters are allowed</div>

            <b-field
                label="Last name"
                :type="type('lastName')"
            >
                <b-input
                    name="lastName"
                    v-model="newUser.lastName"
                    placeholder="Your last name"
                    @blur="onBlur('lastName')"
                    @focus="onFocus('lastName')"
                />
            </b-field>
            <div 
                class="error"
                v-if="!$v.newUser.lastName.required && !focus.lastName"
            >
                Last name is required.</div>
            <div 
                class="error"
                v-if="!$v.newUser.lastName.alpha && !focus.lastName"
            >
                Only letters are allowed</div>

            <b-field
                label="Email"
                :type="type('email')"
            >

                <b-input
                    v-model="newUser.email"
                    placeholder="Your Email"
                    name="email"
                    @blur="onBlur('email')"
                    @focus="onFocus('email')"
                />
            </b-field>
            <div 
                class="error"
                v-if="!$v.newUser.email.required && !focus.email"
            >
                Email is required.</div>
            <div 
                class="error"
                v-if="!$v.newUser.email.email && !focus.email"
            >
                Wrong email format</div>
            <div 
                class="error"
                v-if="!$v.newUser.email.isUnique && !focus.email"
            >
                This email is already registered.</div>

            <label class="label">
                Password <span class="grayed">(at least 6 characters)</span>
            </label>

            <b-field
                :type="type('password')"
            >

                <b-input 
                    type="password"
                    v-model="newUser.password"
                    placeholder="Your Password"
                    @blur="onBlur('password')"
                    @focus="onFocus('password')"
                    @keyup.enter="onSignUp"
                    password-reveal
                />
            </b-field>
            <div 
                class="error"
                v-if="!$v.newUser.password.required && !focus.password"
            >
                Password is required.</div>
            <div 
                class="error"
                v-if="!$v.newUser.password.minLength && !focus.password"
            >
                Should be 6 symbols at least </div>

            <button
                type="button"
                class="button is-primary is-rounded button-wide"
                @click="onSignUp"
                @keyup.enter="onSignUp"
            >
                Create
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
                password: ''
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
        ...mapActions([
            'auth/signUp',
            'checkEmailUnique'
        ]),

        type(el) {
            if (this.focus[el]) return '';
            return this.$v.newUser[el].$invalid ? 'is-danger' : 'is-success';
        },

        onSignUp () {
            if (!this.$v.newUser.$invalid) {
                this.signUp(this.newUser).then((res) => {
                    if (res.error) {
                        this.onError(res.error);
                    } else {
                        this.refreshInput();
                        this.$router.push({name: 'LoginPage'});
                        this.onSuccess({
                            message: 'You have successfully registered! Now you need to login'
                        });
                    }
                });
            } else {
                this.onError({
                    message: 'Please, check your input data'
                });
            }
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
