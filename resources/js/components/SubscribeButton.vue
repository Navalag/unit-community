<template>
    <button :class="classes" @click="subscribe" v-text="btnText"></button>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn btn-color01 btn-sm', this.active ? 'btn-secondary' : 'btn-primary'];
            },

            btnText() {
                return this.active ? 'Unsubscribe' : 'Subscribe';
            }
        },

        methods: {
            subscribe() {
                axios[
                    (this.active ? 'delete' : 'post')
                    ](location.pathname + '/subscriptions');

                this.active = ! this.active;
            }
        }
    }
</script>
