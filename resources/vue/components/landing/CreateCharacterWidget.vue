<script lang="ts">
import { reactive, ref } from 'vue';
import axios from 'axios';
import races from '@/data/races';
import classes from '@/data/classes';
import areas from '@/data/areas';
import { ElLoading, ElMessage } from 'element-plus';
import type { FormInstance, FormRules } from 'element-plus';
const validateName = (rule: any, value: any, callback: any) => {
    // should be alphanumeric
    if (value.length < 2 || value.length > 20) {
        callback(new Error('Character name should be 2 to 20 letters'));
    } else {
        if (!/^[a-zA-Z0-9]+$/.test(value)) {
            callback(new Error('Character name should be alphanumeric'));
        } else {
            callback();
        }
    }
}
const validateMode = (rule: any, value: any, callback: any) => {
    if (value < 1 || value > 3) {
        callback(new Error('Please select a mode'));
    } else {
        callback();
    }
}
export default {
    name: 'CreateCharacterWidget',
    props: {
        raceId: {
            type: Number,
            required: true,
        },
        classId: {
            type: Number,
            required: true,
        },
        areaId: {
            type: Number,
            required: true,
        },
    },
    emits: ['characterCreated'],
    data() {
        return {
            ruleFormRef: null as FormInstance | null,
            ruleForm: reactive({
                name: '',
                mode: 1,
            }),
            rules: reactive<FormRules>({
                name: [
                    { required: true, message: 'Please name your character', trigger: 'blur' },
                    { validator: validateName, trigger: 'blur' },
                ],
                mode: [
                    { required: true, message: 'Please select a mode', trigger: 'blur' },
                    { validator: validateMode, trigger: 'blur' },
                ],
            }),
            area: areas[this.areaId].name,
            clas: classes[this.classId].name,
            race: races[this.raceId].name,
        }
    },
    methods: {
        async createCharacter() {
            await this.ruleFormRef!.validate((valid, fields) => {
                if (valid) {
                    const load = ElLoading.service({
                        lock: true,
                        text: 'Creating Character...',
                        background: 'rgba(0, 0, 0, 0.7)',
                    });
                    axios.post('/player/create-character', {
                        name: this.ruleForm.name,
                        mode: this.ruleForm.mode,
                        raceId: this.raceId,
                        classId: this.classId,
                        areaId: this.areaId,
                    }).then((response) => {
                        this.$emit('characterCreated');
                    }).catch((error) => {
                        ElMessage.error(error);
                    }). finally(() => {
                        load.close();
                    })
                } else {
                    ElMessage.error('Please fix the errors shown');
                }
            });
        }
    },
    mounted() {
        this.ruleFormRef = this.$refs.ruleFormRef as FormInstance;
    }
}
</script>

<template>
    <el-form ref="ruleFormRef" :model="ruleForm" status-icon :rules="rules">
        <el-row justify="center">
            <el-col :span="12" :xs="24">
                <div>You are a(n) {{ race }} {{ clas }} residing in {{ area }}</div><br />
                <el-form-item prop="name">
                    <el-input v-model="ruleForm.name" placeholder="Character Name" />
                </el-form-item>
            </el-col>
        </el-row>
        <el-row justify="center">
            <el-form-item prop="mode">
                <el-radio-group v-model="ruleForm.mode">
                    <el-space wrap>
                        <el-card>
                            <div class="card-title">Normal</div>
                            <ul>
                                <li>Experience: 100%</li>
                                <li>Gold: 100%</li>
                                <li>Drop Rate: 100%</li>
                                <li>P2P Trading: <span class="green">On</span></li>
                                <li>Auction House: <span class="green">On</span></li>
                                <li>Perma-death: <span class="red">Off</span></li>
                            </ul>
                            <el-radio :label="1" size="large" border>Select Mode</el-radio>
                        </el-card>
                        <el-card>
                            <div class="card-title">Elite</div>
                            <ul>
                                <li>Experience: 125%</li>
                                <li>Gold: 125%</li>
                                <li>Drop Rate: 100%</li>
                                <li>P2P Trading: <span class="red">Off</span></li>
                                <li>Auction House: <span class="red">Off</span></li>
                                <li>Perma-death: <span class="red">Off</span></li>
                            </ul>
                            <el-radio :label="2" size="large" border>Select Mode</el-radio>
                        </el-card>
                        <el-card>
                            <div class="card-title">Nightmare</div>
                            <ul>
                                <li>Experience: 150%</li>
                                <li>Gold: 150%</li>
                                <li>Drop Rate: 200%</li>
                                <li>P2P Trading: <span class="red">Off</span></li>
                                <li>Auction House: <span class="red">Off</span></li>
                                <li>Perma-death: <span class="green">On</span></li>
                            </ul>
                            <el-radio :label="3" size="large" border>Select Mode</el-radio>
                        </el-card>
                    </el-space>
                </el-radio-group>
            </el-form-item>
        </el-row>
        <el-row justify="center">
            <el-button type="success" @click="createCharacter">Create Character</el-button>
        </el-row>
    </el-form>
</template>

<style scoped>
.el-row {
    margin-bottom: 20px;
}

.el-row:last-child {
    margin-bottom: 0;
}

ul {
    font-size: 12px;
}
</style>