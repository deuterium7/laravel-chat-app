<template>
    <div>
        <div class="row" v-for="chat in chats" :key="chat.id">
            <div class="col">
                <span class="font-weight-bold">Chat #{{ chat.id }}</span>
            </div>
            <div class="col">
                <span class="font-weight-bold">Creator:</span> {{ chat.creator }}
            </div>
            <div class="col">
                <span class="font-weight-bold">Latest activity:</span> {{ chat.latest_activity }}
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <a :href="'/chats/'+chat.id" title="Перейти">Перейти</a>
                    </div>
                    <div class="col">
                        <a v-if="chat.is_myself" href title="Удалить" @click.prevent="destroyChatItem(chat.id)">Удалить</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                chats: [],
                interval: null,
            }
        },
        mounted() {
            this.retrieveChatList();
            this.createChatListInterval();
        },
        methods: {
            retrieveChatList() {
                axios.get('api/chats')
                    .then((response) => {
                        this.chats = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error.response);
                    })
            },
            createChatListInterval() {
                this.interval = setInterval(() => {
                    this.retrieveChatList();
                }, 1000 * 60);
            },
            destroyChatItem(chatId) {
                clearInterval(this.interval);

                axios.delete('api/chats/' + chatId)
                    .then(() => {
                        this.retrieveChatList();
                        this.createChatListInterval();
                    })
                    .catch((error) => {
                        console.log(error.response);
                    })
            }
        },
    }
</script>