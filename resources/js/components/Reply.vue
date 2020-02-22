<template>
    <div class="tt-item" :id="'reply-'+id" :class="isBest ? 'tt-wrapper-success': ''">
        <div class="tt-single-topic">
            <div class="tt-item-header pt-noborder">
                <div class="tt-item-info info-top">
                    <div class="tt-avatar-icon">
                        <i class="tt-icon"><img :src="reply.owner.avatar_path" alt=""></i>
                    </div>
                    <div class="tt-avatar-title">
                        <a :href="'/profiles/' + reply.owner.name" v-text="reply.owner.name"></a>
                    </div>
                    <a href="#" class="tt-info-time">
                        <i class="tt-icon"><img src="/images/svg-sprite/icon-time.svg" alt=""></i>{{ ago }}
                    </a>
                </div>
            </div>
            <div v-if="editing" class="tt-item-description">
                <form @submit="update">
                    <div class="form-group">
                        <wysiwyg v-model="body" class-names="'pt-3'"></wysiwyg>
                    </div>

                    <button class="btn btn-secondary btn-sm">Update</button>
                    <button class="btn btn-link btn-sm" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>
            <div v-else class="tt-item-description" v-html="body"></div>
            <div class="tt-item-info info-bottom" v-if="signedIn">
                <favorite :reply="reply"></favorite>
                <div class="col-separator"></div>
                <button class="btn btn-primary btn-sm mr-2"
                        v-if="authorize('owns', reply) && ! editing"
                        @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-sm mr-2"
                        v-if="authorize('owns', reply)"
                        @click="destroy">Delete</button>
                <button class="btn btn-success btn-sm ml-2"
                        v-if="authorize('owns', reply.thread) && ! editing"
                        @click="markBestReply">Best Reply?</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            };
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow();
            }
        },

        created () {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);
            },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best');

                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>
