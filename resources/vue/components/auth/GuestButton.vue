<script lang="ts">
import { VueRecaptcha } from 'vue-recaptcha';
import { ElMessage, ElMessageBox, ElLoading } from 'element-plus';
import { useUserStore } from '@/stores/user';
import axios from 'axios';
export default {
    name: 'GuestButton',
    components: {
        VueRecaptcha,
    },
    setup() {
        const userStore = useUserStore();
        return {
            userStore,
        }
    },
    data() {
        return {
            recaptcha: '',
            error: false,
            key: import.meta.env.VITE_RECAPTCHA_KEY,
        };
    },
    methods: {
        verifyCallback(response: string) {
            this.recaptcha = response;
            this.makeGuest();
        },
        makeGuest() {
            if (this.recaptcha === '') {
                ElMessage.error('Please verify that you are not a robot.');
                return;
            }
            ElMessageBox.confirm('By joining Magic Barrage, you agree to the Delta Games <a href="https://delta.games/tos" target="_blank">Terms of Service</a>, <a href="https://delta.games/privacy" target="_blank">Privacy Policy</a>, and <a href="https://delta.games/rules" target="_blank">Game Rules</a>.', 'Guest Confirmation', {
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                dangerouslyUseHTMLString: true,
                type: 'info',
            }).then(() => {
                const loading = ElLoading.service({
                    lock: true,
                    text: 'Creating a guest user...',
                    background: 'rgba(0, 0, 0, 0.9)',
                });
                axios.post('/player/create-guest', {
                    recaptcha: this.recaptcha,
                }).then().catch(() => {
                    ElMessage.error('Something went wrong. Please turn off your VPN and try again.');
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
                            }).catch(() => {
                                setTimeout(() => {
                                    this.error = false;
                                    ElMessage.error("Error generating a session. Please try again.");
                                    loading.close();
                                }, 1000);
                            });
                    } else {
                        loading.close();
                    }
                });
            }).catch(() => {
                // reset recaptcha
                this.recaptcha = '';
                (this.$refs.recaptcha as any).reset();
                ElMessage.error('Guest registration cancelled.');
            });
        },
    },
}
</script>

<template>
    <vue-recaptcha ref="recaptcha" :sitekey="key" @verify="verifyCallback">
        <el-button size="large" style="display:flex;margin:auto;font-size:1.5rem;padding:2rem">Join
            instantly!</el-button>
    </vue-recaptcha>

</template>