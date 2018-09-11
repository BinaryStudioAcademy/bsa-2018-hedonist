import avatarStub from '@/assets/user-placeholder.png';

export default {
    props: {
        notification: {
            required: true,
            type: Object
        },
        user: {
            required: true,
            type: Object
        },
        createdAt: {
            default: null,
            type: Object
        },
        detailed: {
            default: false,
            type: Boolean
        }
    },
    data() {
        return {
            avatarStub: avatarStub
        };
    },
    computed: {
        getUserName() {
            return this.user.info['first_name'];
        },
        getUserAvatar() {
            return this.user.info['avatar_url']
                ? this.user.info['avatar_url']
                : this.avatarStub;
        },
        getDate() {
            const date = new Date(this.createdAt['date']);
            const options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric'
            };
            return date.toLocaleString('en-US', options);
        }
    }
};