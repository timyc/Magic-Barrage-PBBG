<script lang="ts">
import axios from 'axios';
import races from '@/data/races';
import classes from '@/data/classes';
import { useUserStore } from '@/stores/user';
import { ElLoading } from 'element-plus';
export default {
    name: 'CharacterList',
    setup() {
        const userStore = useUserStore();
        return {
            userStore,
        };
    },
    props: {
        reloadKey: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            characters: [] as any,
            races: races,
            classes: classes,
            modes: ['Lyrania', '<span class="green">Normal</span>', '<span class="yellow">Elite</span>', '<span class="red">Nightmare</span>']
        };
    },
    mounted() {
        const loading = ElLoading.service({
            lock: true,
            text: 'Loading your characters',
            background: 'rgba(0, 0, 0, 0.7)',
        });
        axios.post('/player/characters')
            .then(response => {
                this.characters = response.data;
                loading.close();
            }).catch(error => {
                this.userStore.$reset();
                loading.close();
                this.$router.push('/');
            });
    },
    methods: {
        selectCharacter(id: number) {
            const loading = ElLoading.service({
                lock: true,
                text: 'Loading your character',
                background: 'rgba(0, 0, 0, 0.7)',
            });
            axios.post('/player/select-character', { characterId: id })
                .then(response => {
                    this.userStore.character = id;
                    this.userStore.loggedIn = true;
                    loading.close();
                    this.$router.push('/game');
                }).catch(error => {
                    this.userStore.loggedIn = false;
                    loading.close();
                    this.$router.push('/');
                });
        }
    },
}
</script>
<template>
    <el-empty v-if="characters.length == 0" description="No Characters Found. Let's create one!" />
    <el-row :gutter=20 v-else>
        <el-col :span="8" :xs="24" v-for="character in characters" :key="character.id">
            <el-card>
                <div class="char-title">
                    {{ character.name }}
                </div>
                <el-row>
                    <el-col>
                        <el-row>
                            <el-col>
                                <el-row>
                                    <el-col :span="12">
                                        <span>Level:</span>
                                    </el-col>
                                    <el-col :span="12">
                                        <span>{{ character.level }}</span>
                                    </el-col>
                                </el-row>
                                <el-row>
                                    <el-col :span="12">
                                        <span>Race:</span>
                                    </el-col>
                                    <el-col :span="12">
                                        <span>{{ races[character.race].name }}</span>
                                    </el-col>
                                </el-row>
                                <el-row>
                                    <el-col :span="12">
                                        <span>Class:</span>
                                    </el-col>
                                    <el-col :span="12">
                                        <span>{{ classes[character.class].name }}</span>
                                    </el-col>
                                </el-row>
                                <el-row>
                                    <el-col :span="12">
                                        <span>Mode:</span>
                                    </el-col>
                                    <el-col :span="12">
                                        <span v-html="modes[character.mode]"></span>
                                    </el-col>
                                </el-row>
                                <el-row class="center" style="margin:10px">
                                    <el-button @click="selectCharacter(character.id)">Select Character</el-button>
                                </el-row>
                            </el-col>
                        </el-row>
                    </el-col>
                </el-row>
            </el-card>
        </el-col>
    </el-row>
</template>

<style scoped>
.char-title {
    font-size: 1.333rem;
    font-style: italic;
    text-align: center;
    margin-bottom: 10px;
}
.el-col {
    margin-bottom: 10px;
}
.el-col:last-child {
    margin-bottom: 0;
}
</style>