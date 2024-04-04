<script lang="ts">
import axios from 'axios';
import { ElLoading, ElMessageBox, ElMessage } from 'element-plus';
import { useUserStore } from '@/stores/user';
export default {
    name: 'GameView',
    setup() {
        const userStore = useUserStore();
        return {
            userStore,
        }
    },
    methods: {
        logout() {
            ElMessageBox.confirm(
                'Are you sure you want to log out?',
                'Warning',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'error',
                }
            )
                .then(() => {
                    const loading = ElLoading.service({
                        lock: true,
                        text: 'Logging out',
                        background: 'rgba(0, 0, 0, 0.7)',
                    });
                    axios.post('/logout').then(response => {
                        this.userStore.$reset();
                        loading.close();
                        this.$router.push('/');
                    });
                })
                .catch(() => {
                    ElMessage({
                        type: 'success',
                        message: 'Log out canceled',
                    })
                });
        },
    },
}
</script>

<template>
    <el-button type="danger" @click="logout">Logout</el-button>
</template>