export default {
    getNotifications: (state) => _.map(state.notifications.allIds, (id) => state.notifications.byId[id]),
    getUnreadNotifications: (state) => _.map(state.unreadNotificationsIds, (id) => state.notifications.byId[id]),
};