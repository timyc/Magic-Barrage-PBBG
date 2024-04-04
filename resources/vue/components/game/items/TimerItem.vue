<script lang="ts">
// set timer on mount and clear it on unmount
export default {
    name: 'TimerItem',
    props: {
        battle: {
            type: Number,
            required: true
        }
    },
    emits: ['timerEmitted'],
    data() {
        return {
            timer: null as number | null,
            time2: 5,
        }
    },
    mounted() {
        this.timer = setInterval(() => {
            if (this.time2 > 0) this.time2--;
            this.$emit('timerEmitted', this.time2);
        }, 1000);
    },
    beforeUnmount() {
        clearInterval(this.timer as number);
    },
    watch: {
        battle: {
            handler(val) {
                this.time2 = 5;
            }
        }
    },
}
</script>

<template>
    Timer: {{ time2 }}
</template>