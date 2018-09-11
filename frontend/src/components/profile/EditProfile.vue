<template>
    <div class="container" v-if="isUserLoggedIn">
        <div class="columns">
            <div class="column is-one-third">
                <figure class="image avatar">
                    <img v-if="user.avatar_url" :src="user.avatar_url">
                    <i v-else class="fas fa-file-image fa-8x" />
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
                            <span>{{ $t('profile_page.avatar.upload') }}</span>
                        </a>
                    </b-upload>
                </b-field>
                <a class="button is-danger is-fullwidth" @click="deleteAvatar">
                    <b-icon icon="delete" />
                    <span>{{ $t('profile_page.avatar.delete') }}</span>
                </a>
            </div>
            <section class="column">
                <b-field :label="$t('profile_page.name.first')">
                    <b-input v-model.trim="user.first_name" />
                </b-field>

                <b-field :label="$t('profile_page.name.last')">
                    <b-input v-model.trim="user.last_name" />
                </b-field>

                <b-field :label="$t('profile_page.email')">
                    <b-input 
                        type="email"
                        v-model="authUser.email"
                        disabled
                    />
                </b-field>

                <b-field :label="$t('profile_page.password.old')">
                    <b-input
                        type="password"
                        v-model.trim="oldPassword"
                        password-reveal
                    />
                </b-field>

                <b-field :label="$t('profile_page.password.new')">
                    <b-input
                        type="password"
                        v-model.trim="newPassword"
                        password-reveal
                    />
                </b-field>

                <b-field
                    :label="$t('profile_page.phone.title')"
                    :type="isPhoneInvalid ? 'is-danger' : ''"
                    :message="isPhoneInvalid ? this.$t('profile_page.phone.message') : ''"
                >
                    <b-input
                        v-model.trim="user.phone_number"
                        @focus="phoneOnFocus"
                        @blur = "validatePhone"
                        @keydown.capture.native="validateCharacter"
                    />
                </b-field>

                <b-field 
                    :label="$t('profile_page.birthday.title')"
                    expanded
                >
                    <b-field>
                        <b-input 
                            type="number" 
                            v-model.trim="birthDay"
                            :placeholder="$t('profile_page.birthday.day')"
                        />
                        <b-input 
                            type="number" 
                            v-model.trim="birthMonth"
                            :placeholder="$t('profile_page.birthday.month')"
                        />
                        <b-input 
                            type="number" 
                            v-model.trim="birthYear"
                            :placeholder="$t('profile_page.birthday.year')"
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
                <div class="notifications">
                    <div class="notifications__item">
                        <span class="label">{{ $t('profile_page.private') }}</span>
                        <b-switch
                            v-model="user.is_private"
                            type="is-info"
                        />
                    </div>
                    <div class="notifications__item">
                        <span class="label">{{ $t('profile_page.receive_notifications') }}</span>
                        <b-switch
                            type="is-info"
                            :value="user.notifications_receive"
                            v-model="user.notifications_receive"
                        />
                    </div>
                </div>
                <div class="buttons is-right">
                    <a class="button is-primary" @click="saveData">
                        <b-icon icon="upload" />
                        <span>{{ $t('profile_page.save_btn') }}</span>
                    </a>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import phoneValidationService from '@/services/common/phoneValidationService';

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
                is_private: false,
                notifications_receive: true
            },
            isPhoneInvalid:false
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
                    this.user['is_private'] = this.user['is_private'] === 1;
                    this.user['notifications_receive'] = this.user['notifications_receive'] === 1;
                    if (this.user.date_of_birth !== null) {
                        let date = new Date(this.user.date_of_birth);
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
            formData.append('is_private', this.convertBoolToNumber(this.user.is_private));
            formData.append('notifications_receive', this.convertBoolToNumber(this.user.notifications_receive));

            if (this.birthYear && this.birthMonth && this.birthDay) {
                this.user.date_of_birth = this.birthYear + '/' + ('0' + this.birthMonth).slice(-2) + '/' + ('0' + this.birthDay).slice(-2);
                formData.append('date_of_birth', this.user.date_of_birth);
            }
            if (this.files && this.files.length) {
                let file = this.files[0];
                formData.append('avatar', file, file.name);
            }
            formData.append('old_password', this.convertNullToEmptyString(this.oldPassword));
            formData.append('new_password', this.convertNullToEmptyString(this.newPassword));

            return formData;
        },
        convertNullToEmptyString(value) {
            return value == null ? '' : value;
        },
        validateCharacter(event){
            if(event.ctrlKey){
                return;
            }
            if(!phoneValidationService.isValidPhoneCharacter(event.key)){
                event.preventDefault();
            }
        },
        validatePhone(){
            this.isPhoneInvalid = !phoneValidationService.isPhone(this.user.phone_number);
        },
        phoneOnFocus(){
            this.isPhoneInvalid = false;
        },
        convertBoolToNumber(value) {
            return value ? 1 : 0;
        }
    }
};
</script>

<style lang="scss" scoped>
    .container {
        max-width: 700px;
        text-align: left;
        padding: 40px;
        background: #fff;
    }

    .avatar {
        text-align: center;
        margin-bottom: 10px;
        width: 200px;
        height: 200px;
    }

    .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 50% 50%;
    }

    .file.is-fullwidth {
        width: 100%;
    }

    .upload {
        width: 100%;
    }

    .notifications {
        margin: 20px 0;

        &__item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

    }

    @media screen and (max-width: 769px) {
        .is-one-third {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    }
</style>