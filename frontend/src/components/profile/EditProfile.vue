<template>
    <div class="container" v-if="isUserLoggedIn">
        <div class="columns">
            <div class="column is-one-third">
                <figure class="image avatar">
                    <img :src="user.avatar_url">
                </figure>
                <b-field class="file is-fullwidth">
                    <b-upload
                        class="upload" 
                        accept="image/*" 
                        v-model="files"
                        @input="onFileChange"
                    >
                        <a class="button is-primary is-fullwidth">
                            <b-icon icon="upload" />
                            <span>Upload new avatar</span>
                        </a>
                    </b-upload>
                </b-field>
                <a class="button is-danger is-fullwidth" @click="deleteAvatar">
                    <b-icon icon="trash" />
                    <span>Delete avatar</span>
                </a>
            </div>
            <section class="column">
                <b-field 
                    label="First name"
                >
                    <b-input v-model="user.first_name" />
                </b-field>

                <b-field label="Last name">
                    <b-input v-model="user.last_name" />
                </b-field>

                <b-field label="Email">
                    <b-input 
                        type="email"
                        v-model="user.email"
                        disabled
                    />
                </b-field>

                <b-field label="Old password">
                    <b-input
                        type="password"
                        password-reveal
                    />
                </b-field>

                <b-field label="New password">
                    <b-input
                        type="password"
                        password-reveal
                    />
                </b-field>

                <b-field label="Phone">
                    <b-input v-model="user.phone" />
                </b-field>

                <b-field 
                    label="Birth date" 
                    expanded
                >
                    <b-field>
                        <b-input 
                            type="number" 
                            v-model="birthDay"
                            placeholder="Day"
                        />
                        <b-input 
                            type="number" 
                            v-model="birthMonth"
                            placeholder="Month"
                        />
                        <b-input 
                            type="number" 
                            v-model="birthYear"
                            placeholder="Year"
                        />
                    </b-field>
                </b-field>

                <b-field label="Instagram">
                    <b-input v-model="user.instagram" />
                </b-field>

                <b-field label="Twitter">
                    <b-input v-model="user.twitter" />
                </b-field>

                <b-field label="Facebook">
                    <b-input v-model="user.facebook" />
                </b-field>
                <div class="buttons is-right">
                    <a class="button is-primary" @click="saveData">
                        <b-icon icon="upload" />
                        <span>Save</span>
                    </a>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { mapActions } from 'vuex';

export default {
    name: 'EditProfile',
    data() {
        return {
            birthDay: '',
            birthMonth: '',
            birthYear: '',
            files: [],
            user: {
                id: null,
                date_of_birth: null,
                avatar_url: null,
                email: null,
                first_name: null,
                last_name: null,
                phone_number: null,
                instagram_url: null,
                facebook_url: null,
                twitter_url: null,
            }
        };
    },
    created() {
        this.user = Object.assign({}, this.authUser);

        if (this.user.date_of_birth !== null) {
            let date = new Date(this.user.date_of_birth.date);
            this.birthYear = date.getFullYear();
            this.birthMonth = date.getMonth() + 1;
            this.birthDay = date.getDate();
        }
    },
    computed: {
        ...mapGetters({
            isUserLoggedIn: 'auth/isLoggedIn',
            authUser: 'auth/getAuthenticatedUser'
        })
    },
    methods: {
        ...mapActions({
            updateProfile: 'auth/updateProfile',
            deleteUserAvatar: 'auth/deleteUserAvatar',
            setUserAvatar: 'auth/setUserAvatar'
        }),
        saveData() {
            const formData = new FormData();
            formData.append('first_name', this.user.first_name);
            formData.append('last_name', this.user.last_name);
            formData.append('phone_number', this.user.phone);
            formData.append('instagram_url', this.user.instagram);
            formData.append('facebook_url', this.user.facebook);
            formData.append('twitter_url', this.user.twitter);

            if (this.birthYear && this.birthMonth && this.birthDay) {
                this.user.date_of_birth = this.birthYear + '/' + ('0' + this.birthMonth).slice(-2) + '/' + ('0' + this.birthDay).slice(-2);
                formData.append('date_of_birth', this.user.date_of_birth);
            }
            if (this.files && this.files.length) {
                let file = this.files[0];
                formData.append('avatar_url', file, file.name);
            }

            this.updateProfile({formData: formData, userId: this.user.id})
                .then(() => {
                    this.onSuccess({
                        message: 'Data successfully changed'
                    });
                });
        },
        onFileChange() {
            if (this.files && this.files.length) {
                this.user.avatar_url = URL.createObjectURL(this.files[0]);
            }
        },
        deleteAvatar() {
            this.deleteUserAvatar(this.user.id)
                .then(() => {
                    this.files = [];
                    this.user.avatar_url = null;
                    this.setUserAvatar(null);
                });
        },
        onSuccess (success) {
            this.$toast.open({
                message: success.message,
                type: 'is-success'
            });
        },
    }
};
</script>

<style scoped>
    .container {
        max-width: 700px;
        text-align: left;
        padding: 40px;
    }

    .avatar {
        margin-bottom: 10px;
    }

    .image img {
        width: 200px;
        height: 200px;
    }

    .file.is-fullwidth {
        width: 100%;
    }

    .upload {
        width: 100%;
    }

    @media screen and (max-width: 769px) {
        .is-one-third {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    }
</style>