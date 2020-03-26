<template>
    <div :class="classes">
        <h6 class="pt-title" v-if="title" v-text="title"></h6>

        <input id="trix" type="hidden" :name="name" :value="value">

        <vue-tribute :options="tributeOptions">
            <trix-editor ref="trix" input="trix" :placeholder="placeholder"></trix-editor>
        </vue-tribute>
    </div>
</template>

<script>
    import Trix from 'trix';
    import VueTribute from 'vue-tribute';

    Vue.config.ignoredElements = ['trix-editor'];

    export default {
        props: ['name', 'value', 'placeholder', 'title', 'shouldClear', 'classNames'],

        components: { Trix, VueTribute },

        data() {
            return {
                tributeOptions: {
                    trigger: '@',
                    values: function (query, cb) {
                        let queryTrim = query.replace("@", "");

                        axios.get('/api/users', { params: { name: queryTrim } })
                            .then(response => {
                                return cb(response.data.result);
                            });
                    },
                    lookup: 'name',
                    fillAttr: 'name',
                    allowSpaces: true,
                    noMatchTemplate: function() {
                        return null;
                    },
                    selectTemplate: function (item) {
                        return (
                            `<a href="/${window.App.locale}/profiles/${item.original.name}">@${item.original.name}</a>`
                        );
                    },
                    menuShowMinLength: 2,
                }
            };
        },

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
