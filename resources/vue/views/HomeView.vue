<script lang="ts">
import axios from 'axios';
import { ElLoading } from 'element-plus';
import Login from '@/components/auth/Login.vue';
import Register from '@/components/auth/Register.vue';
import { useUserStore } from '@/stores/user';
export default {
    name: 'HomeView',
    setup() {
        const userStore = useUserStore();
        return {
            userStore,
        }
    },
    components: { Login, Register },
    data() {
        return {
            loading: false,
        };
    },
    mounted() {
        if (this.userStore.loggedIn) {
            const loading = ElLoading.service({
                lock: true,
                text: 'Loading...',
                background: 'rgba(0, 0, 0, 0.9)',
            });
            axios.get('/player/session')
                .then(response => {
                    if (response.data > 0) {
                        window["userID"] = response.data;
                        this.userStore.loggedIn = true;
                        setTimeout(() => {
                            loading.close();
                            if (this.userStore.character > 0) {
                                this.$router.push('game');
                            } else {
                                this.$router.push('irdya');
                            }
                        }, 500);
                    } else {
                        this.userStore.loggedIn = false;
                        loading.close();
                    }
                });
        }

    },
    methods: {},
}
</script>

<template>
    <el-container class="home">
        <el-main>
            <el-image src="/img/logo.png" fit="contain" style="display:flex;max-width:50vw;margin:auto"
                alt="logo of the greatest PBBG"></el-image>
            <el-row justify="center">
                <el-col :span="18" :xs="{ span: 24 }">
                    <h1>Idle Cross-Platform PBBG</h1>
                    <p>Magic Barrage takes place in the Wesnoth universe after the Great Fall. With all the great
                        nations destroyed, an excellent opportunity arose for those seeking power and wealth. Embark on
                        your journey as human or elf to become the next great hero or despot. The choice is yours!</p>
                </el-col>
            </el-row>
            <div style="max-width:1200px;margin:auto">
                <el-row justify="center" :gutter="20">
                    <el-col :span="12" :xs="{ span: 24 }">
                        <Login />
                    </el-col>
                    <el-col :span="12" :xs="{ span: 24 }">
                        <Register />
                    </el-col>
                </el-row>
                <el-row justify="center" :gutter="20">
                    <el-col>
                        <h2>Game Information</h2>
                    </el-col>
                    <el-col :span="8" :xs="{ span: 24 }">
                        <div class="card-title">Persistent Connection</div>
                        <p>Your Magic Barrage character will keep fighting monsters even when your browser is closed!
                            Unlike Lyrania.</p>
                    </el-col>
                    <el-col :span="8" :xs="{ span: 24 }">
                        <div class="card-title">Create Guilds</div>
                        <p>Play together with other adventurers! Guilds also grant excellent boosts.</p>
                    </el-col>
                    <el-col :span="8" :xs="{ span: 24 }">
                        <div class="card-title">Craft Legendary Items</div>
                        <p>Your gear is not dependent on drops. Craft high tier gear and fight harder mobs!</p>
                    </el-col>
                </el-row>
                <el-row justify="center" :gutter="20">
                    <el-col :span="8" :xs="{ span: 24 }">
                        <div class="card-title">Raid Dungeons</div>
                        <p>Mobs can drop dungeon keys that grant entrance to locations with rare loot!</p>
                    </el-col>
                    <el-col :span="8" :xs="{ span: 24 }">
                        <div class="card-title">Multiple Characters</div>
                        <p>Not sure which race and profession to choose when you first embarked on your journey? No
                            worries, you can create multiple characters with different stats.</p>
                    </el-col>
                    <el-col :span="8" :xs="{ span: 24 }">
                        <div class="card-title">And more!</div>
                        <p>Discover the legacies of Wesnoth and create your own!</p>
                    </el-col>
                </el-row>
                <el-row justify="center">
                    <div>
                        <el-link href="https://delta.games/privacy" target="_blank" :underline="false">Privacy
                            Policy</el-link> &bull; <el-link href="https://delta.games/tos" target="_blank"
                            :underline="false">Terms of Service</el-link> &bull; <el-link
                            href="https://delta.games/rules" target="_blank" :underline="false">Rules</el-link>
                    </div>
                </el-row>
            </div>
        </el-main>
        <el-footer class="center">
            <div>Copyright &copy; 2022-2023 <el-link href="https://delta.games" target="_blank" :underline="false">Delta
                    Games</el-link></div>
        </el-footer>
    </el-container>
</template>

<style scoped>
h1 {
    font-size: 2rem;
    text-align: center;
}

h2 {
    font-size: 1.833333rem;
    text-align: center;
}

.el-col {
    margin-bottom: 20px;
}
.home {
    min-height: 100vh;
    background: #000;
    background-image: url('/img/backgrounds/home.jpg');
    background-position: center center;
    background-repeat: no-repeat;
}
</style>