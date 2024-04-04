import { defineStore } from "pinia";
import { useUserStore } from "./user";

export interface MessagesArray extends Array<GlobalChatMessage[] | WhisperMessage[] | ClanMessage[] | AnnouncementMessage[]> {
    world: GlobalChatMessage[];
    whisper: WhisperMessage[];
    clan: ClanMessage[];
    announcement: AnnouncementMessage[];
}

export interface GlobalChatMessage {
    id: number;
    channel: number;
    char_id: number;
    message: string;
    gender: string;
    name: string;
    rank: number;
    created_at: Date;
}

export interface WhisperMessage {
    id: number;
    sender_id: number;
    receiver_id: number;
    message: string;
    sender_name: string;
    receiver_name: string;
    created_at: Date;
}

export interface ClanMessage {
    id: number;
    clan_id: number;
    char_id: number;
    message: string;
    created_at: Date;
}

export interface AnnouncementMessage {
    id: number;
    message: string;
    parameters: object;
    type: number;
    created_at: Date;
}

export const useChatStore = defineStore("chatStore", {
    state: () => ({
        allMessages: [] as (GlobalChatMessage|WhisperMessage|ClanMessage|AnnouncementMessage)[],
        generalMessages: [] as GlobalChatMessage[],
        helpMessages: [] as GlobalChatMessage[],
        tradeMessages: [] as GlobalChatMessage[],
        whisperMessages: [] as WhisperMessage[],
        clanMessages: [] as ClanMessage[],
        announcementMessages: [] as AnnouncementMessage[],
        lastWhisper: null as string | null,
    }),
    actions: {
        sortAllChatMessages(arr: MessagesArray) {
            this.allMessages = [...arr.world, ...arr.whisper, ...arr.clan, ...arr.announcement];
            arr.world.filter((message) => {
                if (message.channel === 1) {
                    this.generalMessages.push(message);
                } else if (message.channel === 2) {
                    this.tradeMessages.push(message);
                } else if (message.channel === 3) {
                    this.helpMessages.push(message);
                }
            });
            this.whisperMessages = arr.whisper;
            this.clanMessages = arr.clan;
            this.announcementMessages = arr.announcement;
            // sort each array by id
            this.allMessages.sort((a, b) => b.created_at.valueOf() - a.created_at.valueOf());
            this.generalMessages.sort((a, b) => b.id - a.id);
            this.helpMessages.sort((a, b) => b.id - a.id);
            this.tradeMessages.sort((a, b) => b.id - a.id);
            this.whisperMessages.sort((a, b) => b.id - a.id);
            this.clanMessages.sort((a, b) => b.id - a.id);
            this.announcementMessages.sort((a, b) => b.id - a.id);
            // set lastWhisper to the last whisper message where the player is the receiver
            const userStore = useUserStore();
            this.lastWhisper = this.whisperMessages.find((message) => message.receiver_name === userStore.charInfo.name)?.sender_name ?? this.lastWhisper;
        },
        addGlobalChatMessage(message: GlobalChatMessage) {
            this.allMessages.unshift(message);
            if (this.allMessages.length > 50) {
                this.allMessages.pop();
            }
            if (message.channel === 1) {
                this.generalMessages.unshift(message);
                if (this.generalMessages.length > 50) {
                    this.generalMessages.pop();
                }
            } else if (message.channel === 2) {
                this.tradeMessages.unshift(message);
                if (this.tradeMessages.length > 50) {
                    this.tradeMessages.pop();
                }
            } else if (message.channel === 3) {
                this.helpMessages.unshift(message);
                if (this.helpMessages.length > 50) {
                    this.helpMessages.pop();
                }
            }
        },
        addWhisperMessage(message: WhisperMessage) {
            this.allMessages.unshift(message);
            // set lastWhisper to the last whisper message where the player is the receiver
            const userStore = useUserStore();
            this.lastWhisper = this.whisperMessages.find((message) => message.receiver_name === userStore.charInfo.name)?.sender_name ?? this.lastWhisper;
            if (this.allMessages.length > 50) {
                this.allMessages.pop();
            }
            this.whisperMessages.unshift(message);
            if (this.whisperMessages.length > 50) {
                this.whisperMessages.pop();
            }
        },
        addClanMessage(message: ClanMessage) {
            this.allMessages.unshift(message);
            if (this.allMessages.length > 50) {
                this.allMessages.pop();
            }
            this.clanMessages.unshift(message);
            if (this.clanMessages.length > 50) {
                this.clanMessages.pop();
            }
        },
        addAnnouncementMessage(message: AnnouncementMessage) {
            this.allMessages.unshift(message);
            if (this.allMessages.length > 50) {
                this.allMessages.pop();
            }
            this.announcementMessages.unshift(message);
            if (this.announcementMessages.length > 50) {
                this.announcementMessages.pop();
            }
        },
        clearChats() {
            this.allMessages = [];
            this.generalMessages = [];
            this.helpMessages = [];
            this.tradeMessages = [];
            this.whisperMessages = [];
            this.clanMessages = [];
            this.announcementMessages = [];
        }
    },
});