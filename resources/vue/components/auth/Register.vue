<script lang="ts">
import GuestButton from '@/components/auth/GuestButton.vue';
export default {
    name: 'Register',
    components: {
        GuestButton,
    },
}
</script>

<template>
    <el-card>
        <div class="card-title">Newcomers</div>
        <GuestButton />
    </el-card>

</template>