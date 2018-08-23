<template>
    <Container :title="$t('recover_page.title')">
        <Form>
            <b-field
                :label="$t('inputs.auth.email.field_name')"
                :type="input.email.type"
            >

                <b-input
                    v-model="user.email"
                    :placeholder="$t('inputs.auth.email.placeholder')"
                    name="email"
                    @blur="onBlur"
                    @focus="onFocus"
                    @keyup.enter="onRecover"
                />
            </b-field>

            <button
                type="button"
                class="button is-primary is-rounded button-wide"
                @click="onRecover"
                @keyup.enter="onRecover"
            >
                {{ $t("recover_page.buttons.submit") }}
            </button>
        </Form>
    </Container>
</template>

<script>
import { required, email } from 'vuelidate/lib/validators';
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
                email: ''
            },

            input: {
                email: {
                    type: ''
                }
            }
        };
    },

    methods: {
        ...mapActions({
            recoverPassword: 'auth/recoverPassword'
        }),

        onRecover () {
            if (!this.$v.user.$invalid) {
                this.recoverPassword(this.user.email);
                this.refreshInput();
            }
        },

        onBlur () {
            if (this.$v.user.email.$invalid) {
                this.input.email.type = 'is-danger';
            } else {
                this.input.email.type = 'is-success';
            }
        },

        onFocus (el) {
            this.input.email.type = '';
        },

        refreshInput () {
            this.user = {
                email: ''
            },

            this.input = {
                email: {
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
            }
        }
    }
};
</script>

<style>

</style>
