<script lang="ts">
import { defineComponent } from 'vue';
import json from '@/data/areas';
export default defineComponent({
    name: 'AreaWidget',
    props: {
        areaId: {
            type: Number,
            required: true,
        },
    },
    emits: ['areaDone'],
    data() {
        return {
            area: json[this.areaId],
        };
    },
    updated() {
        this.area = json[this.areaId];
    }
});
</script>
<template>
    <el-row class="center" style="margin:auto">
        <el-image style="max-width:800px;border:5px solid honeydew" :src="'/img/areas/' + area.portrait" fit="contain" />
    </el-row>
    <el-row style="padding: 20px">
        <el-col :span="12" :xs="24" v-html="area.description"></el-col>
        <el-col class="center" :span="12" :xs="24">
            <el-button type="success" @click="$emit('areaDone')">Select Starting Area</el-button>
        </el-col>
    </el-row>
</template>