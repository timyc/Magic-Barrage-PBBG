<script setup lang="ts">
import { ref } from 'vue';
import RaceWidget from '@/components/landing/RaceWidget.vue';
import CharacterList from '@/components/landing/CharacterList.vue';
import ClassWidget from '@/components/landing/ClassWidget.vue';
import CreateCharacterWidget from '@/components/landing/CreateCharacterWidget.vue';
import AreaWidget from '@/components/landing/AreaWidget.vue';
import LogoutButton from '@/components/auth/LogoutButton.vue';

document.title = `Character Landing | ${import.meta.env.VITE_APP_NAME}`;

const environment = import.meta.env.VITE_APP_ENV;
const step = ref(1);
const race = ref(Math.floor(Math.random() * 10 + 1));
const clas = ref(Math.floor(Math.random() * 8 + 1)); // misspelled on purpose
const area = ref(Math.floor(Math.random() * 5 + 1));
const reloadKey = ref(0);

function raceSelect(key: string) {
    race.value = parseInt(key);
}

function classSelect(key: string) {
    clas.value = parseInt(key);
}

function areaSelect(key: string) {
    area.value = parseInt(key);
}

function reloadCharacters() {
    step.value = 1;
    reloadKey.value += 1;
}
</script>

<template>
    <el-container class="landing">
        <el-header class="center">Character Landing&nbsp;<span class="pointer green" v-if="step > 1" @click="step = 1">[Back to List]</span></el-header>
        <el-container>
            <el-main>
                <el-row :gutter="20">
                    <el-col :span="3" :xs="12">
                        <h5 class="center">Servers</h5>
                        <el-menu default-active="1">
                            <template v-if="environment == 'local'">
                                <el-menu-item index="1">Testing</el-menu-item>
                                <el-menu-item index="2" disabled>Global</el-menu-item>
                            </template>
                            <template v-else>
                                <el-menu-item index="1">Global</el-menu-item>
                                <el-menu-item index="2" disabled>Testing</el-menu-item>
                            </template>
                        </el-menu>
                    </el-col>
                    <el-col :span="5" :xs="12">
                        <div class="center" v-if="step == 1">
                            <ul id="landingActions">
                                <li>
                                    <el-button @click="step = 2">Create Character</el-button>
                                </li>
                                <li>
                                    <el-button>Buy Character Slots</el-button>
                                </li>
                                <li>
                                    <LogoutButton />
                                </li>
                            </ul>
                            
                            
                        </div>
                        <template v-if="step == 2">
                            <h5 class="center">Races</h5>
                            <el-menu class="br-0" :default-active="race.toString()" @select="raceSelect">
                                <el-menu-item index="1">Human</el-menu-item>
                                <el-menu-item index="2">Elf</el-menu-item>
                                <el-menu-item index="3">Dwarf</el-menu-item>
                                <el-menu-item index="4">Orc</el-menu-item>
                                <el-menu-item index="5">Undead</el-menu-item>
                                <el-menu-item index="6">Drake</el-menu-item>
                                <el-menu-item index="7">Merfolk</el-menu-item>
                                <el-menu-item index="8">Naga</el-menu-item>
                                <el-menu-item index="9">Saurian</el-menu-item>
                                <el-menu-item index="10">Troll</el-menu-item>
                            </el-menu>
                        </template>
                        <template v-if="step == 3">
                            <h5 class="center">Classes</h5>
                            <el-menu class="br-0" :default-active="clas.toString()" @select="classSelect">
                                <el-menu-item index="1">Marauder</el-menu-item>
                                <el-menu-item index="2">Blademaster</el-menu-item>
                                <el-menu-item index="3">Priest</el-menu-item>
                                <el-menu-item index="4">Necromancer</el-menu-item>
                                <el-menu-item index="5">Pyromancer</el-menu-item>
                                <el-menu-item index="6">Ranger</el-menu-item>
                                <el-menu-item index="7">Javelineer</el-menu-item>
                                <el-menu-item index="8">Assassin</el-menu-item>
                            </el-menu>
                        </template>
                        <template v-if="step == 4">
                            <h5 class="center">Starting Areas</h5>
                            <el-menu class="br-0" :default-active="area.toString()" @select="areaSelect">
                                <el-menu-item index="1">Swamp of Dread</el-menu-item>
                                <el-menu-item index="2">Heart Mountains</el-menu-item>
                                <el-menu-item index="3">Grey Woods</el-menu-item>
                                <el-menu-item index="4">Halstead</el-menu-item>
                                <el-menu-item index="5">Isle of Alduin</el-menu-item>
                            </el-menu>
                        </template>
                    </el-col>
                    <el-col :span="16" :xs="24">
                        <el-steps v-if="step >= 2" :active="step - 2" align-center>
                            <el-step title="Choose Race" @click="step = 2" />
                            <el-step title="Choose Class" @click="step = 3" />
                            <el-step title="Choose Area" @click="step = 4" />
                            <el-step title="Customize" @click="step = 5" />
                        </el-steps>
                        <el-card style="background: black">
                            <template v-if="step == 1">
                                <h5 class="center">
                                    Characters List
                                </h5>
                                <CharacterList :reload-key="reloadKey" />
                            </template>
                            <template v-if="step == 2">
                                <h5 class="center">
                                    Selected Race
                                </h5>
                                <RaceWidget :raceId="race" @race-done="step = 3" />
                            </template>
                            <template v-if="step == 3">
                                <h5 class="center">
                                    Selected Class
                                </h5>
                                <ClassWidget :classId="clas" @class-done="step = 4" />
                            </template>
                            <template v-if="step == 4">
                                <h5 class="center">
                                    Selected Area
                                </h5>
                                <AreaWidget :areaId="area" @area-done="step = 5" />
                            </template>
                            <template v-if="step == 5">
                                <h5 class="center">
                                    Final Touches
                                </h5>
                                <CreateCharacterWidget :areaId="area" :classId="clas" :raceId="race" @character-created="reloadCharacters" />
                            </template>
                        </el-card>
                    </el-col>
                </el-row>
            </el-main>
        </el-container>
    </el-container>
</template>

<style scoped>
.landing {
    background-image: url('/img/backgrounds/landing.jpg');
    background-size: cover;
    min-height: 100vh;
}
ul {
    list-style-type: none;
}
#landingActions>li {
    margin: 10px;
}
#backBtn {
    cursor: pointer;
}
</style>