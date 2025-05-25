<template>
    <div class="flex flex-col h-full">
        <!-- Chat Header -->
        <div class="flex items-center p-4 border-b">
            <img :src="recipient.profile_photo_url" 
                 :alt="recipient.name"
                 class="h-10 w-10 rounded-full">
            <div class="ml-3">
                <h3 class="text-lg font-medium text-gray-900">{{ recipient.name }}</h3>
                <p class="text-sm text-gray-500">{{ recipient.email }}</p>
            </div>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4" ref="messagesContainer">
            <div v-for="message in messages" :key="message.id" 
                 :class="['flex', message.sender_id === user.id ? 'justify-end' : 'justify-start']">
                <div :class="['max-w-xs rounded-lg px-4 py-2', 
                            message.sender_id === user.id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-900']">
                    <p class="text-sm">{{ message.content }}</p>
                    <p class="text-xs mt-1 opacity-75">
                        {{ formatTime(message.created_at) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="p-4 border-t">
            <form @submit.prevent="sendMessage" class="flex space-x-4">
                <input v-model="newMessage" 
                       type="text" 
                       placeholder="Type your message..."
                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Send
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        recipient: {
            type: Object,
            required: true
        },
        user: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            messages: [],
            newMessage: '',
            channel: null
        }
    },

    mounted() {
        this.fetchMessages();
        this.setupWebSocket();
    },

    methods: {
        async fetchMessages() {
            try {
                const response = await axios.get(`/api/messages/${this.recipient.id}`);
                this.messages = response.data;
                this.scrollToBottom();
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        },

        setupWebSocket() {
            this.channel = window.Echo.private(`chat.${this.user.id}`);
            
            this.channel.listen('MessageSent', (e) => {
                if (e.message.sender_id === this.recipient.id) {
                    this.messages.push(e.message);
                    this.scrollToBottom();
                }
            });
        },

        async sendMessage() {
            if (!this.newMessage.trim()) return;

            try {
                const response = await axios.post('/api/messages', {
                    receiver_id: this.recipient.id,
                    content: this.newMessage
                });

                this.messages.push(response.data);
                this.newMessage = '';
                this.scrollToBottom();
            } catch (error) {
                console.error('Error sending message:', error);
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                container.scrollTop = container.scrollHeight;
            });
        },

        formatTime(timestamp) {
            return moment(timestamp).fromNow();
        }
    },

    beforeDestroy() {
        if (this.channel) {
            this.channel.stopListening('MessageSent');
        }
    }
}
</script> 