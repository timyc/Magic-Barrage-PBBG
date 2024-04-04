<script setup lang="ts">
import { ref, defineExpose } from 'vue';

const visible = ref(false);

defineExpose({
    visible
});
</script>

<template>
    <el-dialog v-model="visible" title="Ranking">
        poopers
    </el-dialog>
</template>