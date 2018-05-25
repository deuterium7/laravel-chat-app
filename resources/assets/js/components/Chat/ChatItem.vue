<template>
    <div v-if="chat">
        <div class="row text-center">
            <div class="col">
                Creator: {{ chat.creator }}
            </div>
            <div class="col">
                Type: {{ chat.type }}
            </div>
        </div>

        <div class="mt-3">
            <form @submit.prevent="storeNewMessage">
                <div class="form-group">
                    <label for="chat_message">New Message</label>
                    <div class="input-group">
                        <input id="chat_message"
                               type="text"
                               v-model="newMessage"
                               class="form-control"
                               :class="{ 'is-invalid': errors.newMessage }"
                               @input="errors.newMessage = null"
                               required
                        >
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" :class="{ 'has_error': errors.newMessage }">OK</button>
                        </div>
                    </div>
                    <div class="d-block invalid-feedback" v-if="errors.newMessage">
                        {{ errors.newMessage }}
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-3">
            <div class="mb-2" v-for="message in messages" :key="message.id">
                <div class="row">
                    <div class="col">
                        <div class="text-left" :class="message.is_myself ? 'text-success' : 'text-primary'">
                            {{ message.creator }}
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-right">
                            {{ message.created }}
                        </div>
                    </div>
                </div>
                <p>{{ message.body }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id'],
        data() {
            return {
                chat: null,
                messages: [],
                interval: null,
                newMessage: '',
                errors: {
                    newMessage: null,
                },
            }
        },
        mounted() {
            this.retrieveChatItem();
            this.retrieveMessages();
            this.createMessagesInterval();
        },
        methods: {
            retrieveChatItem() {
                axios.get('api/chats/'+this.id)
                    .then((response) => {
                        this.chat = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error.response);
                    })
            },
            retrieveMessages() {
                axios.get('api/chats/'+this.id+'/messages')
                    .then((response) => {
                        this.messages = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error.response);
                    })
            },
            createMessagesInterval() {
                this.interval = setInterval(() => {
                    this.retrieveMessages();
                }, 1000 * 10);
            },
            storeNewMessage() {
                clearInterval(this.interval);

                axios.post('api/chats/'+this.id+'/messages', { body: this.newMessage })
                    .then(() => {
                        this.createMessagesInterval();
                    })
                    .catch((error) => {
                        if(error.response.status === 422) {
                            this.errors.newMessage = error.response.data.errors.body[0];
                            return;
                        }

                        console.log(error.response);
                    })
            },
        },
    }
</script>

<style>
    .has_error { border-color: #dc3545; }
</style>