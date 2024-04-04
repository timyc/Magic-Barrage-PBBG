<script lang="ts">
import { defineComponent } from 'vue';
import json from '@/data/classes';
export default defineComponent({
    name: 'ClassWidget',
    props: {
        classId: {
            type: Number,
            required: true,
        },
    },
    emits: ['classDone'],
    data() {
        return {
            clas: json[this.classId],
        };
    },
    updated() {
        this.clas = json[this.classId];
    }
});
</script>

<template>
    <el-row>
        <el-col :span="12" :xs="24">
            <el-image :src="'/img/portraits/' + clas.portrait" fit="contain" />
        </el-col>
        <el-col :span="12" :xs="24">
            <el-row v-html="clas.description">
            </el-row>
            <el-row>
                <ul>
                    <li v-for="perk, index in clas.perks" :key="index" v-html="perk">
                    </li>
                </ul>
            </el-row>
            <el-row class="center">
                <el-button type="success" @click="$emit('classDone')">Select Class</el-button>
            </el-row>
        </el-col>
    </el-row>
</template>

<style scoped>
ul {
    list-style-type: none;
}
.el-image {
    border: 5px solid honeydew;
}
</style>