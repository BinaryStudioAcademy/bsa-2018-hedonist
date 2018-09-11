export default {
    getNotifications: (state) => _.map(state.notifications.allIds, (id) => state.notifications.byId[id]),

    getUnreadNotifications: (state) => _.map(state.unreadNotificationsIds, (id) => state.notifications.byId[id]),

    getNotificationUser: (state) => (id) =>  state.notifications.byId[id].data.notification['subject_user'],

    getNotificationSubject: (state) => (id) => state.notifications.byId[id].data.notification.subject,

    getNotificationType: (state) => (id) => state.notifications.byId[id].data.notification.type,
};