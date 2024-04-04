<script lang="ts">
import { defineComponent } from 'vue';
import json from '@/data/races';
export default defineComponent({
    name: 'RaceWidget',
    props: {
        raceId: {
            type: Number,
            required: true,
        },
    },
    emits: ['raceDone'],
    data() {
        return {
            race: json[this.raceId],
        };
    },
    updated() {
        this.race = json[this.raceId];
    },
});
</script>
<template>
    <el-row class="center">
        <h3>{{ race.name }} ({{ race.tag }})</h3>
    </el-row>
    <el-row class="center" style="margin:auto">
        <el-image style="border:5px solid honeydew" :src="'/img/portraits/' + race.portrait" fit="contain" />
    </el-row>
    <el-row style="padding: 20px">
        <el-col :span="12" :xs="24">
            {{ race.description }}
        </el-col>
        <el-col class="center" :span="12" :xs="24">
            <el-button type="success" @click="$emit('raceDone')">Select Race</el-button>
        </el-col>
    </el-row>
</template>