<template>
    <Container title="Create new account">
        <Form>
            <b-field
                label="First name"
                :type="input.firstName.type"
            >
                <b-input
                    name="firstName"
                    v-model="newUser.firstName"
                    placeholder="Your first name"
                    @blur="onBlur('firstName')"
                    @focus="onFocus('firstName')"
                />
            </b-field>
                <div class="error"
                     v-if="!$v.newUser.firstName.required && input.firstName.type">First name is required.</div>
                <div class="error"
                     v-if="!$v.newUser.firstName.alpha  && input.firstName.type">Only letters are allowed</div>

            <b-field
                label="Last name"
                :type="input.lastName.type"
            >
                <b-input
                    name="lastName"
                    v-model="newUser.lastName"
                    placeholder="Your last name"
                    @blur="onBlur('lastName')"
                    @focus="onFocus('lastName')"
                />
            </b-field>
                <div class="error"
                     v-if="!$v.newUser.lastName.required && input.lastName.type">Last name is required.</div>
                <div class="error"
                     v-if="!$v.newUser.lastName.alpha  && input.lastName.type">Only letters are allowed</div>

            <b-field
                label="Email"
                :type="input.email.type"
            >

                <b-input
                    v-model="newUser.email"
                    placeholder="Your Email"
                    name="email"
                    @blur="onBlur('email')"
                    @focus="onFocus('email')"
                />
            </b-field>
                <div class="error"
                     v-if="!$v.newUser.email.required && input.email.type">Email is required.</div>
                <div class="error"
                     v-if="!$v.newUser.email.email && input.email.type">Wrong email format</div>
                <div class="error"
                     v-if="!$v.newUser.email.isUnique && input.email.type">This email is already registered.</div>

            <label class="label">
                Password <span class="grayed">(at least 6 characters)</span>
            </label>

            <b-field
                :type="input.password.type"
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
                <div class="error"
                     v-if="!$v.newUser.password.required && input.password.type">Password is required.</div>
                <div class="error"
                     v-if="!$v.newUser.password.minLength  && input.password.type">Should be 6 symbols at least </div>

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

            input: {
                firstName: {
                    type: ''
                },
                lastName: {
                    type: ''
                },
                email: {
                    type: ''
                },
                password: {
                    type: ''
                }
            }
        };
    },

    methods: {
        ...mapActions([
            'signUp',
            'checkEmailUnique'
        ]),

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
            if (this.$v.newUser[el].$invalid) {
                this.input[el].type = 'is-danger';
            } else {
                this.input[el].type = 'is-success';
            }
        },

        onFocus (el) {
            this.input[el].type = '';
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
                    return new Promise((resolve, reject) => {
                        this.checkEmailUnique(value)
                            .then((res)=>{
                                    if(res.error){
                                        this.onError(res.error);
                                        reject();
                                    } else {
                                        resolve(res.email === value && res.isUnique);
                                    }
                                }
                            );
                    })
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
