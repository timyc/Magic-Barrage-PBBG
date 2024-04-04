<script lang="ts">
import { useUserStore } from '@/stores/user';
import { useInventoryStore } from '@/stores/inventory';
import coins from '@/utils/coins';
export default {
    name: 'EquipmentWidget',
    setup() {
        const userStore = useUserStore();
        const inventoryStore = useInventoryStore();
        return {
            userStore, inventoryStore
        }
    },
    data() {
        return {
            currentTab: null as any
        }
    },
    methods: {
        equipInfo() {
            return `
            ${this.inventoryStore.equipment[this.currentTab] == null ? 'None' : this.inventoryStore.equipment[this.currentTab].name} [${this.userStore.charInfo[this.currentTab]}]<br /><br />
            Cost: ${coins(this.calcCost(this.userStore.charInfo[this.currentTab] + 1))}<br /><br />
            `;
        },
        calcCost(val: number) {
            return Math.floor(5000 * Math.pow(val, 1.995));
        },
        upgrade(slot: string) {
            console.log(slot);
        },
        downgrade(slot: string) {
            console.log(slot);
        }
    }
}
</script>

<template>
    <el-card class="widget-card" :body-style="{padding: '10px'}">
        <div class="widget-card-title">Equipment</div>
        <div class="widget-card-content">
            <table>
                <tr class="pointer" @click="currentTab = 'main_hand'">
                    <td>
                        [ {{ userStore.charInfo.main_hand }} ] Main Hand
                    </td>
                    <td class="right limiter">
                        {{ inventoryStore.equipment.main_hand == null ? 'None' : inventoryStore.equipment.main_hand.name }}
                    </td>
                </tr>
                <tr class="pointer" @click="currentTab = 'off_hand'">
                    <td>
                        [ {{ userStore.charInfo.off_hand }} ] Off Hand
                    </td>
                    <td class="right limiter">
                        {{ inventoryStore.equipment.off_hand == null ? 'None' : inventoryStore.equipment.off_hand.name }}
                    </td>
                </tr>
                <tr class="pointer" @click="currentTab = 'helmet'">
                    <td>
                        [ {{ userStore.charInfo.helmet }} ] Helmet
                    </td>
                    <td class="right limiter">
                        {{ inventoryStore.equipment.helmet == null ? 'None' : inventoryStore.equipment.helmet.name }}
                    </td>
                </tr>
                <tr class="pointer" @click="currentTab = 'gauntlets'">
                    <td>
                        [ {{ userStore.charInfo.gauntlets }} ] Gauntlets
                    </td>
                    <td class="right limiter">
                        {{ inventoryStore.equipment.gauntlets == null ? 'None' : inventoryStore.equipment.gauntlets.name }}
                    </td>
                </tr>
                <tr class="pointer" @click="currentTab = 'shoulders'">
                    <td>
                        [ {{ userStore.charInfo.shoulders }} ] Shoulders
                    </td>
                    <td class="right limiter">
                        {{ inventoryStore.equipment.shoulders == null ? 'None' : inventoryStore.equipment.shoulders.name }}
                    </td>
                </tr>
                <tr class="pointer" @click="currentTab = 'torso'">
                    <td>
                        [ {{ userStore.charInfo.torso }} ] Torso
                    </td>
                    <td class="right limiter">
                        {{ inventoryStore.equipment.torso == null ? 'None' : inventoryStore.equipment.torso.name }}
                    </td>
                </tr>
                <tr class="pointer" @click="currentTab = 'leggings'">
                    <td>
                        [ {{ userStore.charInfo.leggings }} ] Leggings
                    </td>
                    <td class="right limiter">
                        {{ inventoryStore.equipment.leggings == null ? 'None' : inventoryStore.equipment.leggings.name }}
                    </td>
                </tr>
                <tr class="pointer" @click="currentTab = 'boots'">
                    <td>
                        [ {{ userStore.charInfo.boots }} ] Boots
                    </td>
                    <td class="right limiter">
                        {{ inventoryStore.equipment.boots == null ? 'None' : inventoryStore.equipment.boots.name }}
                    </td>
                </tr>
            </table>
            <el-divider></el-divider>
            <div id="equipInfo">
                <div v-if="currentTab == null">No Equipment Selected</div>
                <div v-else>
                    <div v-html="equipInfo()"></div>
                    <div>
                        [ <span class="green pointer" @click="upgrade(currentTab)">Upgrade</span> ] [ <span class="red pointer" @click="downgrade(currentTab)">Downgrade</span> ] [ <span class="yellow pointer" @click="currentTab = null">Close</span> ]
                    </div>
                </div>
            </div>
        </div>
    </el-card>
</template>

<style scoped>
table {
    width: 100%;
}
#equipInfo {
    height: 100px;
}
</style>