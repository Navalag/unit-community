<template>
    <button :class="classes" @click="subscribe" v-text="btnText"></button>
</template>

<script>
    export default {
        props: ['active', 'translations'],

        data() {
            return {
                isActive: this.active,
            }
        },

        computed: {
            classes() {
                return ['btn btn-color01 btn-sm', this.isActive ? 'btn-secondary' : 'btn-primary'];
            },

            btnText() {
                return this.isActive ? this.translations.unsubscribe_text : this.translations.subscribe_text;
            }
        },

        methods: {
            subscribe() {
                axios[
                    (this.isActive ? 'delete' : 'post')
                    ](location.pathname + '/subscriptions');

                this.isActive = ! this.isActive;
            }
        }
    }
</script>
