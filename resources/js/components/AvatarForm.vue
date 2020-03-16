<template>
    <div class="row no-gutter">
        <div class="col-auto">
            <div class="tt-avatar">
                <img :src="avatar" width="50" height="50" class="mr-2">
            </div>
        </div>
        <div class="col-auto ml-auto">
            <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
                <image-upload name="avatar" class="mr-1" @loaded="onLoad" :translations="translations.upload_picture"></image-upload>
            </form>
        </div>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';

    export default {
        props: ['user', 'translations'],

        components: { ImageUpload },

        data() {
            return {
                avatar: this.user.avatar_path
            };
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            }
        },

        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post(`/api/users/${this.user.name}/avatar`, data)
                    .then(() => flash('Avatar uploaded!'));
            }
        }
    }
</script>
