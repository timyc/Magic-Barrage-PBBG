<script setup lang="ts">
import { ref, defineExpose } from 'vue';

const visible = ref(false);

defineExpose({
    visible
});
</script>

<template>
    <el-drawer v-model="visible" title="Wiki">
        <span>poopers</span>
    </el-drawer>
</template>