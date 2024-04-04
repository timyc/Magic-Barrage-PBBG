import { defineStore } from "pinia";

export const useDropsStore = defineStore("dropsStore", {
    state: () => ({
        drops: [] as any[],
    }),
});