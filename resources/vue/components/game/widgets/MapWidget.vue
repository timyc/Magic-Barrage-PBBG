<script lang="ts">
import { useUserStore } from '@/stores/user';
import areas from '@/data/areas';
export default {
    name: 'MapWidget',
    setup() {
        const userStore = useUserStore();
        return {
            userStore, areas
        }
    },
}
</script>

<template>
    <el-card id="map" class="widget-card" :body-style="{padding: '10px'}">
        <div class="widget-card-title">Map</div>
        <div class="widget-card-content">
            <el-row class="center">{{ areas[userStore.charInfo.area].name }}</el-row>
            <el-row class="center">({{ userStore.charInfo.x }}, {{ userStore.charInfo.y }})</el-row>
            <el-row>
                <el-col :span="8"></el-col>
                <el-col :span="8"><div id="up"></div></el-col>
                <el-col :span="8"></el-col>
            </el-row>
            <el-row justify="center">
                <el-col class="col-right" :span="8"><div id="left"></div></el-col>
                <el-col class="col-tele" :span="8"><div id="teleport"></div></el-col>
                <el-col class="col-left" :span="8"><div id="right"></div></el-col>
            </el-row>
            <el-row justify="center">
                <el-col :span="8"></el-col>
                <el-col :span="8"><div id="down"></div></el-col>
                <el-col :span="8"></el-col>
            </el-row>
        </div>
    </el-card>
</template>

<style scoped>
#map {
    min-width: 200px;
}
.el-col {
    display: flex;
    justify-content: center;
}
.col-right {
    max-width: 52px;
    justify-content: flex-end !important;
}
.col-left {
    max-width: 52px;
    justify-content: flex-start !important;
}
.col-tele {
    max-width: 52px;
}
#teleport {
    width: 52px;
    height: 52px;
    background: url('/img/ui/tp.png');
    background-size: cover;
    cursor: pointer;
    border-radius: 50%;
    box-shadow: 0 0 50px 5px #e04848;
}
#up {
    width: 52px;
    height: 52px;
    background: url('/img/ui/arrow.png');
    transform: rotate(270deg);
    cursor: pointer;
    z-index: 1;
}
#down {
    width: 52px;
    height: 52px;
    background: url('/img/ui/arrow.png');
    transform: rotate(90deg);
    cursor: pointer;
}
#left {
    width: 52px;
    height: 52px;
    background: url('/img/ui/arrow.png');
    transform: rotate(180deg);
    cursor: pointer;
}
#right {
    width: 52px;
    height: 52px;
    background: url('/img/ui/arrow.png');
    cursor: pointer;
}
</style>