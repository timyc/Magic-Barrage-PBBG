<script setup lang="ts">
import { defineProps } from 'vue';

const props = defineProps<{ 
    name: string,
    id: number
}>();
</script>

<template>
    <el-popover placement="top" :width="400" trigger="click">
        <template #reference>
            <span class="pointer">{{ name }}</span>
        </template>
        oonga
    </el-popover>
</template>