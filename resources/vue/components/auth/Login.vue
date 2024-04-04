<script lang="ts">
import axios from 'axios';
import { ElLoading, ElMessage } from 'element-plus';
import { useUserStore } from '@/stores/user';
export default {
    name: 'Login',
    setup() {
        const userStore = useUserStore();
        return {
            userStore,
        }
    },
    data() {
        return {
            username: '',
            password: '',
            errorMessage: '',
            error: false,
            loading: false,
        };
    },
    methods: {
        login() {
            let data = {
                name: this.username,
                password: this.password
            }
            const loading = ElLoading.service({
                lock: true,
                text: 'Logging in...',
                background: 'rgba(0, 0, 0, 0.9)',
            });
            axios.post('/login', data)
                .then().catch(errorResponse => {
                    this.errorMessage = errorResponse.response.data.message;
                    this.error = true;
                }).finally(() => {
                    if (!this.error) {
                        axios.get('/player/session')
                            .then(response => {
                                if (response.data > 0) {
                                    window["userID"] = response.data;
                                    this.userStore.loggedIn = true;
                                    setTimeout(() => {
                                        loading.close();
                                        this.$router.push('irdya');
                                    }, 1000);

                                }
                            });
                    } else {
                        setTimeout(() => {
                            this.error = false;
                            ElMessage.error(this.errorMessage);
                            loading.close();
                        }, 1000);
                    }
                });
        },
    },
}
</script>

<template>
    <el-card>
        <div class="card-title">Existing Adventurers</div>
        <el-form label-width="120px" @submit.prevent="login">
            <el-form-item label="Username">
                <el-input v-model="username" />
            </el-form-item>
            <el-form-item label="Password">
                <el-input v-model="password" type="password" />
            </el-form-item>
            <el-form-item>
                <el-input type="submit" style="display:none"></el-input>
                <el-button type="primary" style="margin:auto" @click="login">Login</el-button>
            </el-form-item>
        </el-form>
    </el-card>
</template>