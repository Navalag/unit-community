<template>
    <div :class="classes">
        <h6 class="pt-title" v-text="title"></h6>
        
        <input id="trix" type="hidden" :name="name" :value="value">

        <trix-editor ref="trix" input="trix" :placeholder="placeholder"></trix-editor>
    </div>
</template>

<script>
    import Trix from 'trix';

    Vue.config.ignoredElements = ['trix-editor'];

    export default {
        props: ['name', 'value', 'placeholder', 'title', 'shouldClear', 'classNames'],

        components: { Trix },

        mounted () {
            this.$refs.trix.addEventListener('trix-change', e => {
                this.$emit('input', e.target.innerHTML);
            });

            this.$watch('shouldClear', () => {
                this.$refs.trix.value = '';
            });
        },

        computed: {
            classes() {
                return ['pt-editor form-default', this.classNames];
            }
        }
    }
</script>
