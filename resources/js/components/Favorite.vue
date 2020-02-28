<template>
    <a href="#" :class="classes" @click.prevent="toggle">
        <i class="tt-icon"><svg><use xlink:href="#icon-favorite"></use></svg></i>
        <span class="tt-text" v-text="count"></span>
    </a>
</template>

<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['reply'],

        components: { Favorite },

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited,
            }
        },

        computed: {
            classes() {
                return [
                    'tt-icon-btn',
                    this.active ? 'active' : ''
                ];
            },

            endpoint() {
                return `/${window.App.locale}/replies/${this.reply.id}/favorites`;
            }
        },

        methods: {
            toggle() {
                this.active ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoint);

                this.active = true;
                this.count++;
            },

            destroy() {
                axios.delete(this.endpoint);

                this.active = false;
                this.count--;
            }
        }
    }
</script>
