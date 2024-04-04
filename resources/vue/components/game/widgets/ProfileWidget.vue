<script lang="ts">
import { useUserStore } from '@/stores/user';
import { useBattleStore } from '@/stores/battle';
import axios from 'axios';
import coins from '@/utils/coins';
import titles from '@/data/nobility';
export default {
    name: 'ProfileWidget',
    setup() {
        const battleStore = useBattleStore();
        const userStore = useUserStore();
        return {
            userStore, coins, titles, battleStore
        }
    },
    mounted() {
        axios.post('/player/character-info').catch((error) => {
            if (error.response.status == 500) {
                this.userStore.loggedIn = false;
                this.userStore.character = -1;
                this.$router.push('/');
            }
        });
    },
    methods: {
        switchChar() {
            this.$router.push('/irdya');
        }
    }
}
</script>

<template>
    <el-card id="profile" class="widget-card" :body-style="{ padding: '10px' }" v-if="userStore.charInfo != null">
        <div class="widget-card-title">Character [<span id="switchBtn" @click="switchChar">Change</span>]</div>
        <div class="widget-card-content">
            <table>
                <tr>
                    <td>Name:</td>
                    <td class="right limiter">{{ userStore.charInfo.name }}</td>
                </tr>
                <tr>
                    <td>Rank:</td>
                    <td class="right limiter" v-html="titles[userStore.charInfo.title][userStore.charInfo.gender]"></td>
                </tr>
                <tr>
                    <td>Level:</td>
                    <td class="right">{{ userStore.charInfo.level }}</td>
                </tr>
                <tr>
                    <td>Clan:</td>
                    <td class="right limiter">{{ userStore.clan.name }}</td>
                </tr>
            </table>
            <el-progress :percentage="((userStore.charInfo.exp / (userStore.charInfo.level * 30)) || 0) * 100">
                <el-popover placement="right" title="Experience" :width="200" trigger="hover"
                    :content="userStore.charInfo.exp + '/' + (userStore.charInfo.level * 30)">
                    <template #reference>
                        <el-button>EXP</el-button>
                    </template>
                </el-popover>
            </el-progress>
            <el-divider />
            <table>
                <tr>
                    <td>Coins:</td>
                    <td class="right limiter"><span v-html="coins(userStore.charInfo.coins)"></span></td>
                </tr>
                <tr>
                    <td>Food:</td>
                    <td class="right">{{ userStore.charInfo.food }}</td>
                </tr>
                <tr>
                    <td>Wood:</td>
                    <td class="right">{{ userStore.charInfo.wood }}</td>
                </tr>
                <tr>
                    <td>Stone:</td>
                    <td class="right">{{ userStore.charInfo.stone }}</td>
                </tr>
                <tr>
                    <td>Iron:</td>
                    <td class="right">{{ userStore.charInfo.iron }}</td>
                </tr>
            </table>
            <el-divider />
            <table>
                <tr>
                    <td>Health:</td>
                    <td class="right">{{ userStore.charInfo.health }}</td>
                </tr>
                <tr>
                    <td>Attack:</td>
                    <td class="right">{{ userStore.charInfo.attack }}</td>
                </tr>
                <tr>
                    <td>Defense:</td>
                    <td class="right">{{ userStore.charInfo.defense }}</td>
                </tr>
                <tr>
                    <td>Luck:</td>
                    <td class="right">{{ userStore.charInfo.luck }}</td>
                </tr>
            </table>
            <el-divider />
            <table>
                <tr>
                    <td>Evasion:</td>
                    <td class="right">{{ (userStore.charInfo.evasion / 100).toFixed(2) }}%</td>
                </tr>
                <tr>
                    <td>Accuracy:</td>
                    <td class="right">{{ ((userStore.charInfo.accuracy + 5000) / 100).toFixed(2) }}%</td>
                </tr>
                <tr>
                    <td>Crit Chance:</td>
                    <td class="right">{{ (userStore.charInfo.crit_chance / 100).toFixed(2) }}%</td>
                </tr>
                <tr>
                    <td>Crit Damage:</td>
                    <td class="right">{{ (userStore.charInfo.crit_damage / 100).toFixed(2) }}%</td>
                </tr>
            </table>
        </div>

    </el-card>
</template>

<style scoped>
table {
    width: 100%;
}

#switchBtn {
    cursor: pointer;
    color: #269930;
}
</style>