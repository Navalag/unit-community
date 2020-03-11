<template>
    <div>
        <div v-if="signedIn">
            <div class="tt-wrapper-inner">
                <div class="form-group">
                    <wysiwyg name="body"
                             v-model="body"
                             :placeholder="translations.have_something_to_say"
                             :shouldClear="completed"></wysiwyg>
                </div>

                <button type="submit"
                        class="btn btn-secondary"
                        @click="addReply"
                        v-text="translations.publish_reply"></button>
            </div>
        </div>

        <div v-else class="tt-wrapper-inner">
            <h4 class="tt-title-separator"><span v-html="translations.login_to_participate"></span></h4>
        </div>
    </div>
</template>

<script>
    import 'jquery.caret';
    import 'at.js';

    export default {
        props: ['translations'],

        data() {
            return {
                body: '',
                completed: false
            };
        },

        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON("/api/users", {name: query}, function(usernames) {
                            callback(usernames)
                        });
                    }
                }
            });
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';
                        this.completed = true;

                        flash(this.translations.flash_reply_posted);

                        this.$emit('created', data);
                    })
            }
        }
    }
</script>
