<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea name="body"
                          id="body"
                          class="form-control"
                          placeholder="Have something to say?"
                          rows="5"
                          v-model="body"
                          required></textarea>
            </div>

            <button type="submit"
                    class="btn btn-primary"
                    @click="addReply">Post</button>
        </div>
        <p v-else class="text-center">
            Please <a href="/login">Sing In</a> to participate in this discussion.
        </p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: ''
            };
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        // flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';

                        //TODO: fix this
                        // flash('Reply has been posted.');

                        this.$emit('created', data);
                    })
            }
        }
    }
</script>
