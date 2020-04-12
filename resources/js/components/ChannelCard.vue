<template>
    <div class="col-md-6 col-lg-4">
        <div class="tt-item">
            <div v-if="editing">
                <div class="form-group">
                    <label for="name" v-text="translate.name"></label>
                    <input type="text" name="name" class="form-control" id="name" v-model="channel.name">
                </div>
                <div class="form-group">
                    <label for="description" v-text="translate.description"></label>
                    <textarea type="text" name="description" rows="3" class="form-control" id="description" v-model="channel.description"></textarea>
                </div>
                <button type="button" @click="editing = false" class="btn btn-sm btn-primary" v-text="translate.cancel"></button>
                <a v-if="channel.threads_count === 0"
                   :href="`/${localePrefix}/channels/${channel.slug}`"
                   :data-confirm-message="translate.dialog_confirm"
                   data-method="delete" class="btn btn-sm btn-link float-right" v-text="translate.delete"></a>
                <button type="button" @click="update" class="btn btn-sm btn-secondary float-right" v-text="translate.update"></button>
            </div>
            <div v-else>
                <div class="tt-item-header">
                    <ul class="tt-list-badge">
                        <li>
                            <a :href="`/${localePrefix}/threads/${channel.slug}`">
                                <span :class="['tt-color' + channel.id, 'tt-badge']" v-text="channel.name"></span>
                            </a>
                        </li>
                    </ul>
                    <h6 class="tt-title">
                        <a :href="`/${localePrefix}/threads/${channel.slug}`">
                            {{ translate.threads }} - {{ channel.threads_count }}
                        </a>
                    </h6>
                </div>
                <div class="tt-item-layout">
                    <div class="innerwrapper" v-text="channel.description"></div>
                    <div v-if="authorize('isAdmin')" class="innerwrapper text-right">
                        <button type="button" class="btn btn-sm btn-link" @click="editing = true" v-text="translate.edit"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['channelInitial', 'translate'],

        data() {
            return {
                localePrefix: window.App.locale,
                channel: this.channelInitial,
                editing: false,
            }
        },

        methods: {
            update() {
                axios.patch(
                    `/${this.localePrefix}/channels/${this.channel.slug}`, {
                        name: this.channel.name,
                        description: this.channel.description
                    })
                    .then((response) => {
                        this.channel = response.data.channel;

                        flash('Updated!');

                        this.editing = false;
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');

                        this.editing = true;
                    });
            },
        }
    }
</script>
