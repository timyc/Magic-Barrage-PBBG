import { defineStore } from "pinia";

export interface statsDrops {
    atk: number;
    def: number;
    acc: number;
    agi: number;
    lck: number;
    hp: number;
}

export interface Battle {
    flag: number;
    rounds: number;
    playerMaxHP: number;
    playerHP: number;
    playerDodges: number;
    playerCrits: number;
    playerHits: number;
    playerMisses: number;
    mobMaxHP: number;
    mobHP: number;
    mobDodges: number;
    mobCrits: number;
    mobHits: number;
    mobMisses: number;
    coins: number;
    exp: number;
    actions: number,
    type: number,
    stats: statsDrops,
}

export const useBattleStore = defineStore("battleStore", {
    state: () => ({
        lastBattle: null as Battle | null,
    }),
});