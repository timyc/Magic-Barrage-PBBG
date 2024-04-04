import { defineStore } from "pinia";
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    created_at: string;
    updated_at: string;
}
export interface Character {
    id: number;
    name: string;
    gender: string;
    title: number;
    level: number;
    accuracy: number;
    area: number;
    attack: number;
    boots: number;
    class: number;
    coins: number;
    crit_chance: number;
    crit_damage: number;
    crit_resistance: number;
    defense: number;
    evasion: number;
    exp: number;
    food: number;
    gauntlets: number;
    health: number;
    helmet: number;
    iron: number;
    leggings: number;
    luck: number;
    main_hand: number;
    mode: number;
    multiattack: number;
    off_hand: number;
    race: number;
    reputation: number;
    shoulders: number;
    stone: number;
    torso: number;
    wood: number;
    x: number;
    y: number;
}
export interface Clan {
    id: number;
    name: string;
}
declare global {
    interface Window {
        Pusher: typeof Pusher;
        Echo: Echo;
    }
}
export const useUserStore = defineStore("userStore", {
    state: () => ({
        loggedIn: false,
        charInfo: {
            id: 0,
            name: 'Loading...',
            level: 0,
            gender: 'M',
            title: 0,
            area: 0,
            accuracy: 0,
            attack: 0,
            boots: 0,
            class: 0,
            coins: 0,
            crit_chance: 0,
            crit_damage: 0,
            crit_resistance: 0,
            defense: 0,
            evasion: 0,
            exp: 0,
            food: 0,
            gauntlets: 0,
            health: 0,
            helmet: 0,
            iron: 0,
            leggings: 0,
            luck: 0,
            main_hand: 0,
            mode: 0,
            multiattack: 0,
            off_hand: 0,
            race: 0,
            reputation: 0,
            shoulders: 0,
            stone: 0,
            torso: 0,
            wood: 0,
            x: 0,
            y: 0,
        } as Character,
        clan: {
            id: 0,
            name: 'N/A',
        } as Clan,
        character: -1,
        selectedMob: "1",
    }),
    actions: {
        initEcho() {
            window.Pusher = Pusher;

            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: import.meta.env.VITE_PUSHER_APP_KEY,
                wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
                wsPath: import.meta.env.VITE_PUSHER_PATH ?? null,
                wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
                wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
                forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
                enabledTransports: ['ws', 'wss'],
            });
        },
        disconnectEcho() {
            window.Echo.disconnect();
        },
        afterBattle(data: any) {
            if (data.flag === 1) {
                this.charInfo.exp += data.exp;
                if (this.charInfo.exp >= this.charInfo.level * 30) {
                    this.charInfo.exp = 0;
                    this.charInfo.level++;
                }
                this.charInfo.coins += data.coins;
                this.charInfo.health += data.stats.hp;
                this.charInfo.attack += data.stats.atk;
                this.charInfo.defense += data.stats.def;
                this.charInfo.accuracy += data.stats.acc;
                this.charInfo.evasion += data.stats.agi;
                this.charInfo.luck += data.stats.lck;
            }
        }
    },
    persist: true,
});