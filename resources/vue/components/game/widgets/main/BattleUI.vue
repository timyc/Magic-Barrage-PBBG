<script lang="ts">
import axios from 'axios';
import { useUserStore } from '@/stores/user';
import { useBattleStore } from '@/stores/battle';
import TimerItem from '@/components/game/items/TimerItem.vue';
import { ElNotification, ElMessage } from 'element-plus';
import coins from '@/utils/coins';

export interface Mobs {
    [key: number]: string;
}

export default {
    setup() {
        const userStore = useUserStore();
        const battleStore = useBattleStore();
        return {
            userStore, battleStore, coins
        }
    },
    components: {
        TimerItem
    },
    data() {
        return {
            mobs: {} as Mobs,
            mob: "0",
            battle: 0,
            timer: 5,
            disableAttack: false,
        }
    },
    mounted() {
        axios.post('/player/mobs').then((res: any) => {
            this.mobs = res.data;
            if (this.mobs[this.userStore.selectedMob]) {
                this.mob = this.userStore.selectedMob;
            } else {
                this.mob = Object.keys(this.mobs)[0];
            }
        });
    },
    methods: {
        selectMob(e: any) {
            this.userStore.selectedMob = e;
        },
        autoFight() {
            this.disableAttack = true;
            ElMessage.success('Fighting will start soon...');
            axios.post('/player/auto-fight', {
                mobId: this.mob
            }).catch(() => {
                this.disableAttack = false;
            });
        },
        stopAutoFight() {
            axios.post('/player/stop-auto-fight').then(() => {
                this.battleStore.lastBattle!.actions = 0;
                this.disableAttack = false;
            });
        },
        restartAutoFight() {
            this.disableAttack = true;
            ElMessage.success('Restarting fights...');
            axios.post('/player/restart-auto-fight', {
                mobId: this.mob
            }).catch(() => {
                this.disableAttack = false;
            });
        },
        timerEmitted(val: number) {
            this.timer = val;
        },
        mobPrefix(val: number) {
            switch (val) {
                case 1:
                    return '';
                case 2:
                    return '<span class="green bold">Merchant</span> ';
                case 3:
                    return '<span class="yellow bold">Veteran</span> ';
                case 4:
                    return '<span class="blue bold">Royal</span> ';
                case 5:
                    return '<span class="peach bold">Fool</span> ';
                case 6:
                    return '<span class="purple bold">Psychic</span> ';
                case 7:
                    return '<span class="red bold">Assassin</span> ';
            }
        }
    },
    watch: {
        'battleStore.lastBattle': {
            handler(val) {
                if (this.battleStore.lastBattle != null) {
                    this.disableAttack = false;
                    this.battle++;
                    let message = 'You gained:<br />';
                    if (this.battleStore.lastBattle!.stats.hp > 0) {
                        message += '&bull; 1 Health Stat<br />';
                    }
                    if (this.battleStore.lastBattle!.stats.atk > 0) {
                        message += '&bull; 1 Attack Stat<br />';
                    }
                    if (this.battleStore.lastBattle!.stats.def > 0) {
                        message += '&bull; 1 Defense Stat<br />';
                    }
                    if (this.battleStore.lastBattle!.stats.lck > 0) {
                        message += '&bull; 1 Luck Stat<br />';
                    }
                    if (this.battleStore.lastBattle!.stats.acc > 0) {
                        message += '&bull; 1 Accuracy Stat<br />';
                    }
                    if (this.battleStore.lastBattle!.stats.agi > 0) {
                        message += '&bull; 1 Evasion Stat<br />';
                    }
                    if (this.battleStore.lastBattle != null && message != 'You gained:<br />') {
                        ElNotification({
                            title: 'New Stats',
                            dangerouslyUseHTMLString: true,
                            message: message,
                            type: 'info',
                        });
                    }
                }


            },
        }
    },
}
</script>

<template>
    <el-space wrap v-if="battleStore.lastBattle == null">
        <template v-if="Object.keys(mobs).length > 0">
            <el-select v-model="mob" @change="selectMob" placeholder="Select">
                <el-option v-for="(value, key) in mobs" :key="key" :label="value" :value="key" />
            </el-select>
            <el-button @click="autoFight" :disabled="disableAttack">
                Attack
            </el-button>
        </template>
    </el-space>
    <el-row v-else :gutter="20">
        <el-col :span="24">
            <TimerItem :battle="battle" @timer-emitted="timerEmitted" />
        </el-col>
        <el-col :span="12">
            <div>You</div><br />
            <el-progress type="circle" :stroke-width="5"
                :percentage="Math.floor(battleStore.lastBattle!.playerHP < 0 ? 0 : battleStore.lastBattle!.playerHP / battleStore.lastBattle!.playerMaxHP * 100)"
                status="exception">
                <template #default>
                    <el-avatar :size="50" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png" />
                </template>
            </el-progress>
            <div>HP: {{ battleStore.lastBattle!.playerHP }} / {{ battleStore.lastBattle!.playerMaxHP }}</div>
        </el-col>
        <el-col :span="12">
            <div><span v-html="mobPrefix(battleStore.lastBattle.type)"></span>{{ mobs[mob] }}</div><br />
            <el-progress type="circle" :stroke-width="5"
                :percentage="Math.floor(battleStore.lastBattle!.mobHP < 0 ? 0 : battleStore.lastBattle!.mobHP / battleStore.lastBattle!.mobMaxHP * 100)"
                status="exception">
                <template #default>
                    <el-avatar :size="50" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png" />
                </template>
            </el-progress>
            <div>HP: {{ battleStore.lastBattle!.mobHP }} / {{ battleStore.lastBattle!.mobMaxHP }}</div>
        </el-col>
        <el-col :span="24">
            <br />
            <div>
                You hit the <strong>{{ mobs[mob] }} {{
                    battleStore.lastBattle.playerHits
                }}</strong> times ({{ battleStore.lastBattle.playerCrits }}
                critical hits) and missed <strong>{{ battleStore.lastBattle.playerMisses }}</strong> times.
            </div>
            <div>
                You were hit <strong>{{ battleStore.lastBattle.mobHits }}</strong> times ({{
                    battleStore.lastBattle.mobCrits
                }} critical hits) and dodged <strong>{{
    battleStore.lastBattle.playerDodges
}}</strong> times.
            </div>
            <br />
            <div>
                Total Damage Dealt: {{ battleStore.lastBattle.mobMaxHP - battleStore.lastBattle.mobHP }} (Average Hit:
                {{ Math.floor((battleStore.lastBattle.mobMaxHP - battleStore.lastBattle.mobHP) /
                    battleStore.lastBattle.playerHits) || 0
                }})
            </div>
            <div>
                Total Damage Received: {{ battleStore.lastBattle.playerMaxHP - battleStore.lastBattle.playerHP }}
                (Average Hit: {{ Math.floor((battleStore.lastBattle.playerMaxHP - battleStore.lastBattle.playerHP) /
                    battleStore.lastBattle.mobHits) || 0
                }})
            </div>
            <br />
            <div class="yellow" v-if="battleStore.lastBattle.flag == 0">
                The Battle resulted in a draw after {{ battleStore.lastBattle.rounds }} round(s).
            </div>
            <div class="green" v-else-if="battleStore.lastBattle.flag == 1">
                You won the battle after {{ battleStore.lastBattle.rounds }} round(s)!
            </div>
            <div class="red" v-else>
                You lost the battle after {{ battleStore.lastBattle.rounds }} round(s).
            </div>
            <div v-if="battleStore.lastBattle.flag == 1">You gained <span
                    v-html="coins(battleStore.lastBattle.coins)"></span> and {{ battleStore.lastBattle.exp
                    }} experience</div>
            <div>
                You have {{ battleStore.lastBattle.actions }} fights left.
                <el-button @click="restartAutoFight" :disabled="disableAttack">Restart Autos</el-button>
                <el-button v-if="battleStore.lastBattle.actions > 0" @click="stopAutoFight">Stop</el-button>
                <el-button v-else @click="battleStore.lastBattle = null" :disabled="timer > 0">Continue</el-button>
            </div>
        </el-col>
    </el-row>
</template>
