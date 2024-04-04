<script setup lang="ts">
import { defineProps } from 'vue';
import UserPopover from './chatmessage/UserPopover.vue';
import nobility from '@/data/nobility';
import { useUserStore } from '@/stores/user';

const props = defineProps<{ 
    message: any,
}>();

const userStore = useUserStore();

function formatTime() {
    let hours: any = props.message.created_at.getHours();
    if (hours < 10) hours = `0${hours}`;
    let minutes: any = props.message.created_at.getMinutes();
    if (minutes < 10) minutes = `0${minutes}`;
    let seconds: any = props.message.created_at.getSeconds();
    if (seconds < 10) seconds = `0${seconds}`;
    return `${hours}:${minutes}:${seconds}`;
}
function formatChannel() {
    switch (props.message.channel) {
        case 2:
            return ' [ <span style="color:#FFCC33">Trade</span> ] ';
        case 3:
            return ' [ <span style="color:#FFAAAA">Help</span> ] ';
        default:
            return ' ';
    }
}
function formatAccess() {
    switch (props.message.access) {
        case 60:
            return ' <span style="color:#FF0000">Admin</span> ';
        case 40:
            return ' <span style="color:#009900">Mod</span> ';
        default:
            return ' ';
    }
}
</script>
<template>
    <li v-if="message.hasOwnProperty('channel')">[ <span v-html="formatTime()" style="color:#8F8F8F"></span> ]<span
            v-html="formatChannel()"></span><span v-html="formatAccess()"></span><span
            v-html="nobility[message.rank][message.gender]"></span> <UserPopover :name="message.name" :id="message.char_id" /> : {{ message.message }}</li>
    <li v-else-if="message.hasOwnProperty('receiver_id')">[ <span v-html="formatTime()" style="color:#8F8F8F"></span> ]
        <span style="color:#ee66dd" v-if="message.receiver_id == userStore.charInfo.id">From <UserPopover :name="message.sender_name" :id="message.sender_id" />:
            {{ message.message }}</span><span style="color:#ee66dd" v-else>To <UserPopover :name="message.receiver_name" :id="message.receiver_id" />: {{
            message.message }}</span></li>
    <li v-else-if="message.hasOwnProperty('clan_id')">[ <span v-html="formatTime()" style="color:#8F8F8F"></span> ] <span
            style="color:#00ff37">[ Clan ] <UserPopover :name="message.char_name" :id="message.char_id" />: {{ message.message }}</span></li>
    <li v-else-if="message.hasOwnProperty('parameters')">
        <span v-if="message.type == 0">
            <span style="color:#33CCFF;font-weight:bold">Message of the Day: {{ message.message }}</span>
        </span>
        <span v-if="message.type == 1">
            [ <span v-html="formatTime()" style="color:#8F8F8F"></span> ] <span
        style="color:#deb000;font-weight:bold">Global: {{ message.message }}</span>
        </span>
        
    </li>
</template>