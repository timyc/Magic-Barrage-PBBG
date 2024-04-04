<script lang="ts">
import BattleUI from '@/components/game/widgets/main/BattleUI.vue';
export default {
    name: 'MainWidget',
    components: {
        BattleUI
    },
    data() {
        return {
            ui: 'battle',
        };
    },
}
</script>

<template>
    <el-card id="main">
        <BattleUI v-if="ui === 'battle'" />
    </el-card>
</template>

<style scoped>
#main {
    text-align: center;
    font-size: 12px;
    margin-bottom: 20px;
    background: #120909;
    border: 1px solid #5c3e20;
    height: 400px;
    overflow: auto;
}
</style>