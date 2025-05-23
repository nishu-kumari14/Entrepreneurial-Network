<template>
    <div class="relative">
        <button @click="toggleNotifications" class="relative p-2 text-gray-600 hover:text-gray-900">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span v-if="unreadCount > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ unreadCount }}
            </span>
        </button>

        <div v-if="showNotifications" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-50">
            <div class="p-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Notifications</h3>
            </div>
            
            <div class="max-h-96 overflow-y-auto">
                <div v-if="notifications.length === 0" class="p-4 text-center text-gray-500">
                    No notifications
                </div>
                
                <div v-for="notification in notifications" :key="notification.id" 
                     class="p-4 border-b hover:bg-gray-50 cursor-pointer"
                     @click="handleNotificationClick(notification)">
                    <div class="flex items-start">
                        <img :src="notification.sender.profile_photo_url" 
                             :alt="notification.sender.name"
                             class="h-10 w-10 rounded-full">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                {{ notification.message }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ formatTime(notification.created_at) }}
                            </p>
                        </div>
                        <span v-if="!notification.read_at" class="ml-auto h-2 w-2 rounded-full bg-blue-600"></span>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t">
                <button @click="markAllAsRead" 
                        class="w-full text-sm text-blue-600 hover:text-blue-800">
                    Mark all as read
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showNotifications: false,
            notifications: [],
            unreadCount: 0
        }
    },

    mounted() {
        this.fetchNotifications();
        this.listenForNotifications();
    },

    methods: {
        toggleNotifications() {
            this.showNotifications = !this.showNotifications;
        },

        async fetchNotifications() {
            try {
                const response = await axios.get('/api/notifications');
                this.notifications = response.data.notifications;
                this.unreadCount = response.data.unread_count;
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        },

        listenForNotifications() {
            window.Echo.private(`notifications.${window.Laravel.user.id}`)
                .listen('NotificationSent', (e) => {
                    this.notifications.unshift(e.notification);
                    this.unreadCount++;
                });
        },

        async handleNotificationClick(notification) {
            if (!notification.read_at) {
                await this.markAsRead(notification);
            }
            
            // Handle navigation based on notification type
            switch (notification.type) {
                case 'project_invite':
                    window.location.href = `/projects/${notification.data.project_id}`;
                    break;
                case 'new_message':
                    window.location.href = `/messages/${notification.sender_id}`;
                    break;
                case 'forum_reply':
                    window.location.href = `/forum/${notification.data.post_id}`;
                    break;
            }
        },

        async markAsRead(notification) {
            try {
                await axios.post(`/api/notifications/${notification.id}/read`);
                notification.read_at = new Date();
                this.unreadCount--;
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        },

        async markAllAsRead() {
            try {
                await axios.post('/api/notifications/read-all');
                this.notifications.forEach(notification => {
                    notification.read_at = new Date();
                });
                this.unreadCount = 0;
            } catch (error) {
                console.error('Error marking all notifications as read:', error);
            }
        },

        formatTime(timestamp) {
            return moment(timestamp).fromNow();
        }
    }
}
</script> 