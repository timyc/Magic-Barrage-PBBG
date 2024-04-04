<script setup lang="ts">
import axios from 'axios';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useRouter } from 'vue-router';
import { ElLoading } from 'element-plus';
import { useUserStore } from '@/stores/user';
import { useChatStore } from '@/stores/chat';
import { useBattleStore } from '@/stores/battle';
import { useInventoryStore } from '@/stores/inventory';
import ProfileWidget from '@/components/game/widgets/ProfileWidget.vue';
import MapWidget from '@/components/game/widgets/MapWidget.vue';
import ChatWidget from '@/components/game/widgets/ChatWidget.vue';
import MainWidget from '@/components/game/widgets/MainWidget.vue';
import DropsWidget from '@/components/game/widgets/DropsWidget.vue';
import EquipmentWidget from '@/components/game/widgets/EquipmentWidget.vue';
import NavBar from '@/components/game/NavBar.vue';

const userStore = useUserStore();
const chatStore = useChatStore();
const battleStore = useBattleStore();
const inventoryStore = useInventoryStore();
const router = useRouter();

const subscribed = ref(false);

onMounted(() => {
    const loading = ElLoading.service({
        lock: true,
        text: 'Loading the game...',
        background: 'rgba(0, 0, 0, 1)'
    });
    if (!userStore.loggedIn) {
        loading.close();
        router.push('/');
    } else {
        axios.get('/player/session')
            .then(response => {
                if (response.data > 0) {
                    userStore.initEcho();
                    // have to declare as any because the types are wrong
                    (window.Echo as any).private(`character.${userStore.character}`).subscribed(() => {
                        subscribed.value = true;
                    }).listenToAll((event: string, data: any) => {
                        if (import.meta.env.VITE_APP_ENV === 'local') {
                            console.log(event, data);
                        }
                        switch (event) {
                            case 'SendCharacterInfo':
                                userStore.charInfo = data.chardata;
                                inventoryStore.equipment = data.itemdata.equipped;
                                inventoryStore.items = data.itemdata.all;
                                if (data.clandata != null) {
                                    userStore.clan = data.clandata;
                                    window.Echo.private(`clan.${userStore.clan.id}`).listen('SendClanMessage', (e: any) => {
                                        if (import.meta.env.VITE_APP_ENV === 'local') {
                                            console.log(e);
                                        }
                                        // convert created_at string to date object
                                        e.data.created_at = new Date(e.data.created_at);
                                        chatStore.addClanMessage(e.data);
                                    });
                                }
                                break;
                            case 'SendWhisperMessage':
                                data.data.created_at = new Date(data.data.created_at);
                                chatStore.addWhisperMessage(data.data);
                                break;
                            case 'SendMobBattle':
                                battleStore.lastBattle = data.data;
                                userStore.afterBattle(data.data);
                                break;
                            case 'SendMobBattleEnd':
                                battleStore.lastBattle = null;
                                break;
                        }
                    });
                    chatStore.clearChats();
                    loading.close();
                } else {
                    userStore.$reset();
                    loading.close();
                    router.push('/');
                }
            });
    }
});

onBeforeUnmount(() => {
    if (userStore.loggedIn) userStore.disconnectEcho();
    userStore.$reset();
    battleStore.$reset();
});
</script>

<template>
    <el-container class="game" v-if="subscribed">
        <NavBar />
        <el-container>
            <el-main>
                <el-row :gutter="20">
                    <el-col :lg="4" :sm="8" :xs="24">
                        <ProfileWidget />
                        <br />
                        <DropsWidget />
                    </el-col>
                    <el-col :lg="16" :sm="16" :xs="24">
                        <el-row>
                            <el-col :span="24">
                                <MainWidget />
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <ChatWidget />
                            </el-col>
                        </el-row>
                    </el-col>
                    <el-col :lg="4" :xs="24">
                        <MapWidget />
                        <br />
                        <EquipmentWidget />
                    </el-col>
                </el-row>
            </el-main>
        </el-container>
        <el-footer class="center">
            <div>Copyright &copy; 2022-2023 <el-link href="https://delta.games" target="_blank" :underline="false">Delta
                    Games</el-link></div>
        </el-footer>
    </el-container>
</template>

<style scoped>
.game {
    background-color: #2d2d2d;
    background-image: url(/img/backgrounds/game.png);
    background-size: cover;
    min-height: 100vh;
}

</style>