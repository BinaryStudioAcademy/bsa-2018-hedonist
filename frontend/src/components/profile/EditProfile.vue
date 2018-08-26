<template>
    <div class="container" v-if="isUserLoggedIn">
        <div class="columns">
            <div class="column is-one-third">
                <figure class="image avatar">
                    <img v-if="user.avatar_url" :src="user.avatar_url">
                    <i v-else class="fas fa-file-image fa-8x"></i>
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
                    <b-input v-model.trim="user.first_name" />
                </b-field>

                <b-field label="Last name">
                    <b-input v-model.trim="user.last_name" />
                </b-field>

                <b-field label="Email">
                    <b-input 
                        type="email"
                        v-model="authUser.email"
                        disabled
                    />
                </b-field>

                <b-field label="Old password">
                    <b-input
                        type="password"
                        v-model.trim="oldPassword"
                        password-reveal
                    />
                </b-field>

                <b-field label="New password">
                    <b-input
                        type="password"
                        v-model.trim="newPassword"
                        password-reveal
                    />
                </b-field>

                <b-field label="Phone">
                    <b-input v-model.trim="user.phone_number" />
                </b-field>

                <b-field 
                    label="Birth date" 
                    expanded
                >
                    <b-field>
                        <b-input 
                            type="number" 
                            v-model.trim="birthDay"
                            placeholder="Day"
                        />
                        <b-input 
                            type="number" 
                            v-model.trim="birthMonth"
                            placeholder="Month"
                        />
                        <b-input 
                            type="number" 
                            v-model.trim="birthYear"
                            placeholder="Year"
                        />
                    </b-field>
                </b-field>

                <b-field label="Instagram">
                    <b-input v-model.trim="user.instagram_url" />
                </b-field>

                <b-field label="Twitter">
                    <b-input v-model.trim="user.twitter_url" />
                </b-field>

                <b-field label="Facebook">
                    <b-input v-model.trim="user.facebook_url" />
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
import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'EditProfile',
    data() {
        return {
            birthDay: '',
            birthMonth: '',
            birthYear: '',
            oldPassword: '',
            newPassword: '',
            files: [],
            user: {
                date_of_birth: '',
                avatar_url: '',
                first_name: '',
                last_name: '',
                phone_number: '',
                instagram_url: '',
                facebook_url: '',
                twitter_url: '',
            }
        };
    },
    created() {
        this.setProfileUser();
    },
    computed: {
        ...mapGetters({
            isUserLoggedIn: 'auth/isLoggedIn',
            authUser: 'auth/getAuthenticatedUser'
        }),
    },
    methods: {
        ...mapActions({
            updateProfile: 'profile/updateProfile',
            deleteUserAvatar: 'profile/deleteUserAvatar',
            fetchProfileUser: 'profile/fetchProfileUser'
        }),
        setProfileUser() {
            this.fetchProfileUser(this.authUser.id)
                .then((profileUser) => {
                    this.user = Object.assign({}, profileUser);
                    if (this.user.date_of_birth !== null) {
                        let date = new Date(this.user.date_of_birth.date);
                        this.birthYear = date.getFullYear();
                        this.birthMonth = date.getMonth() + 1;
                        this.birthDay = date.getDate();
                    }
                });
        },
        saveData() {
            let formData = this.createFormData();
            this.updateProfile({formData: formData, userId: this.authUser.id})
                .then((data) => {
                    this.user.avatar_url = data.avatar_url;
                    this.onSuccess({
                        message: 'Data successfully changed'
                    });
                })
                .catch((data) => {
                    this.errorHandler(data);
                });
        },
        onFileChange() {
            if (this.files && this.files.length) {
                this.user.avatar_url = URL.createObjectURL(this.files[0]);
            }
        },
        deleteAvatar() {
            this.deleteUserAvatar(this.authUser.id)
                .then(() => {
                    this.user.avatar_url = null;
                    this.files = [];
                });
        },
        onSuccess (success) {
            this.$toast.open({
                message: success.message,
                type: 'is-success'
            });
        },
        onError (error) {
            this.$toast.open({
                message: error.message,
                type: 'is-danger'
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
        createFormData() {
            let formData = new FormData();
            formData.append('first_name', this.convertNullToEmptyString(this.user.first_name));
            formData.append('last_name', this.convertNullToEmptyString(this.user.last_name));
            formData.append('phone_number', this.convertNullToEmptyString(this.user.phone_number));
            formData.append('instagram_url', this.convertNullToEmptyString(this.user.instagram_url));
            formData.append('facebook_url', this.convertNullToEmptyString(this.user.facebook_url));
            formData.append('twitter_url', this.convertNullToEmptyString(this.user.twitter_url));

            if (this.birthYear && this.birthMonth && this.birthDay) {
                this.user.date_of_birth = this.birthYear + '/' + ('0' + this.birthMonth).slice(-2) + '/' + ('0' + this.birthDay).slice(-2);
                formData.append('date_of_birth', this.user.date_of_birth);
            }
            if (this.files && this.files.length) {
                let file = this.files[0];
                formData.append('avatar', file, file.name);
            }
            if (this.oldPassword !== '' && this.newPassword !== '') {
                formData.append('old_password', this.convertNullToEmptyString(this.oldPassword));
                formData.append('new_password', this.convertNullToEmptyString(this.newPassword));
            }
            return formData;
        },
        convertNullToEmptyString(value) {
            return value == null ? '' : value;
        }
    }
};
</script>

<style scoped>
    .container {
        max-width: 700px;
        text-align: left;
        padding: 40px;
        background: #fff;
    }

    .avatar {
        text-align: center;
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