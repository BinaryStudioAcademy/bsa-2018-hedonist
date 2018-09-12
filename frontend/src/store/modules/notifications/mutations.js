export default {
    SET_NOTIFICATIONS: (state, notifications) => {
        state.notifications = notifications;
    },
    ADD_NOTIFICATION: (state, notification) => {
        state.notifications.byId[notification.id] = notification;
        if (!_.includes(state.notifications.allIds, notification.id)) {
            state.notifications.allIds.unshift(notification.id);
        }
    },
    UPDATE_NOTIFICATIONS: (state, notifications) => {
        _.forEach(notifications.allIds, function(id) {
            state.notifications.byId[id] = notifications.byId[id];
            if (!_.includes(state.notifications.allIds, id)) {
                state.notifications.allIds.unshift(id);
            }
        });
    },
    SET_UNREAD_NOTIFICATIONS_IDS: (state, unreadNotifications) => {
        state.unreadNotificationsIds = unreadNotifications.allIds;
    },
    ADD_UNREAD_NOTIFICATION_ID: (state, id) => {
        state.unreadNotificationsIds.unshift(id);
    },
    CLEAR_UNREAD_NOTIFICATION_IDS: (state) => {
        state.unreadNotificationsIds = [];
    },
    CLEAR_NOTIFICATIONS: (state) => {
        state.notifications.byId = {};
        state.notifications.allIds = [];
    }
};