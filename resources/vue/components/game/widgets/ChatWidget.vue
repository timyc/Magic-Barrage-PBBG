<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { ElMessage } from 'element-plus';
import axios from 'axios';
import ChatMessageItem from '@/components/game/items/ChatMessageItem.vue';
import { useUserStore } from '@/stores/user';
import { useChatStore } from '@/stores/chat';

const chatStore = useChatStore();
const userStore = useUserStore();

const message = ref('');
const chatLoader = ref('0');
const channel = ref('1');
const clanChatting = ref(false);
const whisperChatting = ref(false);
const windowWidth = ref(window.innerWidth);

const cssVars = computed(() => {
    return {
        '--chat-height': windowWidth.value > 768 ? '350px' : '400px',
    }
});

function sendMessage() {
    if (message.value.length == 0) return;
    if (clanChatting.value) {
        message.value = '/c ' + message.value;
    }
    if (whisperChatting.value) {
        message.value = '/r ' + message.value;
    }
    if (message.value[0] == '/') {
        // strip the first character and create cases for each command
        let fragments = message.value.substring(1).split(' ');
        message.value = '';
        switch (fragments[0]) {
            case 'whisper':
            case 'w':
                axios.post('/player/send-whisper-message', {
                    message: fragments.slice(2).join(' '),
                    receiver: fragments[1]
                }).then((response) => {
                    if (response.data.code == 'char_not_found') {
                        ElMessage.error(response.data.msg);
                    } else if (response.data.code == 'same_receiver') {
                        ElMessage.error(response.data.msg);
                    }
                }).catch((error) => {
                    ElMessage.error('An error occurred. Please try again.');
                });
                break;
            case 'reply':
            case 'r':
                if (chatStore.lastWhisper == null) {
                    ElMessage.error('No one to reply to.');

                    return;
                }
                axios.post('/player/send-whisper-message', {
                    message: fragments.slice(1).join(' '),
                    receiver: chatStore.lastWhisper
                }).then((response) => {
                    if (response.data.code == 'char_not_found') {
                        ElMessage.error('Character not found.');
                    }
                }).catch((error) => {
                    ElMessage.error('An error occurred. Please try again.');
                });
                break;
            case 'clan':
            case 'c':
                axios.post('/player/send-clan-message', {
                    message: fragments.slice(1).join(' ')
                }).then((response) => {
                    if (response.data.code == 'not_in_clan') {
                        ElMessage.error('You are not in a clan.');
                    }
                });
                break;
            case 'me':
                axios.post('/player/send-me-message', {
                    message: fragments.slice(1).join(' ')
                }).then((response) => {
                });
                break;
            case 'help':
                break;
            default:
                break;
        }
    } else {
        axios.post('/player/send-chat-message', {
            message: message.value,
            channel: parseInt(channel.value)
        });
        message.value = '';
    }
}

function tabClick(e: any) {
    chatLoader.value = e.props.name;
    clanChatting.value = false;
    whisperChatting.value = false;
    if (parseInt(e.props.name) > 0) channel.value = e.props.name;
    if (parseInt(e.props.name) == 50) {
        channel.value = "1";
    }
    if (parseInt(e.props.name) == 100) {
        channel.value = "1";
        whisperChatting.value = true;
    }
    if (parseInt(e.props.name) == 200) {
        channel.value = "1";
        clanChatting.value = true;
    }
}

onMounted(() => {
    axios.post('/player/get-all-messages').then((response) => {
        // convert all created_at strings to date objects
        for (let i = 0; i < response.data.world.length; i++) {
            response.data.world[i].created_at = new Date(response.data.world[i].created_at);
        }
        for (let i = 0; i < response.data.whisper.length; i++) {
            response.data.whisper[i].created_at = new Date(response.data.whisper[i].created_at);
        }
        for (let i = 0; i < response.data.clan.length; i++) {
            response.data.clan[i].created_at = new Date(response.data.clan[i].created_at);
        }
        for (let i = 0; i < response.data.announcement.length; i++) {
            response.data.announcement[i].created_at = new Date(response.data.announcement[i].created_at);
        }
        chatStore.sortAllChatMessages(response.data);
        axios.post('/server/motd').then((response) => {
            chatStore.addAnnouncementMessage(
                {
                    id: 0,
                    message: response.data.MOTD,
                    parameters: {},
                    type: 0,
                    created_at: new Date()
                }
            );
        });
        window.Echo.join('globalchat').listen('SendGlobalChatMessage', (e: any) => {
            if (import.meta.env.VITE_APP_ENV === 'local') {
                console.log(e);
            }
            // convert created_at string to date object
            e.data.created_at = new Date(e.data.created_at);
            chatStore.addGlobalChatMessage(e.data);
        });
    });
});

onUnmounted(() => {
    window.Echo.leave('globalchat');
});
</script>

<template>
    <el-tabs id="chat" :tab-position="windowWidth > 768 ? 'left' : 'top'" @tab-click="tabClick">
        <el-form @submit.prevent="sendMessage">
            <el-tab-pane label="All" name="0">
                <el-input v-model="message" placeholder="Enter message...">
                    <template #prepend>
                        <el-select v-model="channel" style="max-width: 100px">
                            <el-option label="General" value="1" />
                            <el-option label="Trade" value="2" />
                            <el-option label="Help" value="3" />
                        </el-select>
                    </template>
                    <template #append>
                        <el-button class="white" type="info" @click="sendMessage">Send</el-button>
                    </template>
                </el-input>
            </el-tab-pane>
            <el-tab-pane label="General" name="1">
                <el-input v-model="message" placeholder="Enter message...">
                    <template #append>
                        <el-button class="white" type="info" @click="sendMessage">Send</el-button>
                    </template>
                </el-input>
            </el-tab-pane>
            <el-tab-pane label="Trade" name="2">
                <el-input v-model="message" placeholder="Enter message...">
                    <template #append>
                        <el-button class="white" type="info" @click="sendMessage">Send</el-button>
                    </template>
                </el-input>
            </el-tab-pane>
            <el-tab-pane label="Help" name="3">
                <el-input v-model="message" placeholder="Enter message...">
                    <template #append>
                        <el-button class="white" type="info" @click="sendMessage">Send</el-button>
                    </template>
                </el-input>
            </el-tab-pane>
            <el-tab-pane label="Announcement" name="50">
                <el-input v-model="message" placeholder="Enter message..." disabled>
                </el-input>
            </el-tab-pane>
            <el-tab-pane label="Whisper" name="100">
                <el-input v-model="message" placeholder="Enter message...">
                    <template #append>
                        <el-button class="white" type="info" @click="sendMessage">Send</el-button>
                    </template>
                </el-input>
            </el-tab-pane>
            <el-tab-pane label="Clan" name="200" v-if="userStore.clan.id > 0">
                <el-input v-model="message" placeholder="Enter message...">
                    <template #append>
                        <el-button class="white" type="info" @click="sendMessage">Send</el-button>
                    </template>
                </el-input>
            </el-tab-pane>
            <el-input type="submit" style="display:none"></el-input>
            <ul class="chatMessages">
                <ChatMessageItem v-for="message in chatStore.allMessages" :message="message" v-if="chatLoader == '0'" />
                <ChatMessageItem v-for="message in chatStore.generalMessages" :message="message" v-if="chatLoader == '1'" />
                <ChatMessageItem v-for="message in chatStore.tradeMessages" :message="message" v-if="chatLoader == '2'" />
                <ChatMessageItem v-for="message in chatStore.helpMessages" :message="message" v-if="chatLoader == '3'" />
                <ChatMessageItem v-for="message in chatStore.announcementMessages" :message="message"
                    v-if="chatLoader == '50'" />
                <ChatMessageItem v-for="message in chatStore.whisperMessages" :message="message"
                    v-if="chatLoader == '100'" />
                <ChatMessageItem v-for="message in chatStore.clanMessages" :message="message" v-if="chatLoader == '200'" />
            </ul>
        </el-form>

    </el-tabs>
</template>

<style lang="scss" scoped>
#chat {
    border-image: url(/img/ui/fixedboxbg.png) 30 / 19px / 0 stretch;
    border-style: solid;
    padding: 10px;
    background: #290f0c;
    height: var(--chat-height);
}

.chatMessages {
    padding: 5px;
    font-size: 13px;
    overflow-y: auto;
    height: 300px;
}
</style>