import { defineStore } from "pinia";

export interface Item {
    id: number;
    name: string;
    description: string;
    slot: string;
    type: string;
    element: string;
    file: string;
    rarity: number;
    level: number;
    cost: number;
    sell: number;
    salvage: number;
    quantity: number;
    currency: number;
    health: number;
    attack: number;
    defense: number;
    accuracy: number;
    evasion: number;
    luck: number;
}

export interface Equipment {
    main_hand: Item | null;
    off_hand: Item | null;
    helmet: Item | null;
    gauntlets: Item | null;
    shoulders: Item | null;
    torso: Item | null;
    leggings: Item | null;
    boots: Item | null;
}

export const useInventoryStore = defineStore("inventoryStore", {
    state: () => ({
        equipment: {
            main_hand: null,
            off_hand: null,
            helmet: null,
            gauntlets: null,
            shoulders: null,
            torso: null,
            leggings: null,
            boots: null,
        } as Equipment,
        items: [] as Item[],
    }),
});