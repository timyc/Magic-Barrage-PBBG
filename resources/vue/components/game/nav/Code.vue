<script setup lang="ts">
import { defineExpose } from 'vue';
import { ElMessage, ElMessageBox } from 'element-plus'

const open = () => {
  ElMessageBox.prompt('Please enter your redemption code', 'Tip', {
    confirmButtonText: 'Redeem',
    cancelButtonText: 'Cancel',
  }).catch(() => {
      ElMessage({
        type: 'info',
        message: 'No code redeemed',
      })
    })
}

defineExpose({
  open
});
</script>

<template></template>