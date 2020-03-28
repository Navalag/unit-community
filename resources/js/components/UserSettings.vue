<template>
    <form class="form-default" >
        <div class="tt-form-upload">
            <avatar-form :user="userdata" :translations="translations"></avatar-form>
        </div>
        <div class="form-group">
            <label for="settingsUserName" v-text="translations.username"></label>
            <input type="text"
                   name="username"
                   class="form-control"
                   :class="{ hasError: formErrors.username }"
                   id="settingsUserName"
                   v-model="user.name"
                   @focus="removeErrorBorder">
            <div v-if="formErrors.username" v-text="formErrors.username"></div>
        </div>
        <div class="form-group">
            <label for="settingsUserEmail" v-text="translations.email"></label>
            <input type="email"
                   name="email"
                   class="form-control"
                   :class="{ hasError: formErrors.email}"
                   id="settingsUserEmail"
                   v-model="user.email"
                   @focus="removeErrorBorder">
            <div v-if="formErrors.email"> {{ formErrors.email }}</div>
            <div v-if="newEmailNotVerified"> {{ newEmailNotVerified }}</div>
            <div>{{ emailNotVerified }}</div>
        </div>
        <div class="form-group">
            <label for="settingsUserOldPassword" v-text="translations.old_password"></label>
            <input type="password"
                   name="oldPassword"
                   class="form-control"
                   :class="{ hasError: formErrors.oldPassword }"
                   id="settingsUserOldPassword"
                   placeholder="************"
                   v-model="user.oldPassword"
                   @focus="removeErrorBorder">
            <div v-if="formErrors.oldPassword"> {{ formErrors.oldPassword }}</div>
        </div>
        <div class="form-group">
            <label for="settingsUserNewPassword"
                   v-text="translations.new_password"></label>
            <input type="password"
                   name="newPassword"
                   class="form-control"
                   :class="{ hasError: formErrors.newPassword }"
                   id="settingsUserNewPassword"
                   placeholder="************"
                   v-model="user.newPassword"
                   @click="showConfirmPass"
                   @focus="removeErrorBorder">
            <div v-if="formErrors.newPassword"> {{ formErrors.newPassword }}</div>
        </div>
        <div class="form-group confirm-password-hidden" :class="{ isActive: isActive }">
            <label for="confirmUserNewPassword" v-text="translations.confirm_new_password"></label>
            <input type="password"
                   name="confirmNewPassword"
                   class="form-control"
                   :class="{ hasError: formErrors.confirmNewPassword }"
                   id="confirmUserNewPassword"
                   placeholder="************"
                   v-model="user.confirmNewPassword"
                   @focus="removeErrorBorder">
            <div v-if="formErrors.confirmNewPassword" v-text="formErrors.confirmNewPassword"></div>
        </div>
        <div class="form-group">
            <label>Notify me via Email</label>
            <div class="checkbox-group">
                <input type="checkbox" id="settingsCheckBox01" name="checkbox" v-model="notifications.notifyThreadWasUpdated">
                <label for="settingsCheckBox01">
                    <span class="check"></span>
                    <span class="box"></span>
                    <span class="tt-text" v-text="translations.checkbox_thread_was_updated"></span>
                </label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="settingsCheckBox02" name="checkbox" v-model="notifications.notifyReplyReaction">
                <label for="settingsCheckBox02">
                    <span class="check"></span>
                    <span class="box"></span>
                    <span class="tt-text" v-text="translations.checkbox_likes_reply"></span>
                </label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="settingsCheckBox03" name="checkbox" v-model="notifications.notifyMention">
                <label for="settingsCheckBox03">
                    <span class="check"></span>
                    <span class="box"></span>
                    <span class="tt-text" v-text="translations.checkbox_mentions_me"></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-secondary"
                    v-on:click.prevent="submitForm"
                    :disabled="loading">{{ translations.update }}<i v-if="loading" class="fas fa-spinner fa-spin ml-2"></i></button>
        </div>
        <div>{{ statusMessage }}</div>
        <div>
            {{ redirectMessage }} {{ counter }}
            <span class="redirect-message-dots" :class="{ isActive: dots }">...</span>
        </div>
    </form>
</template>

<script>
    import AvatarForm from '../components/AvatarForm.vue';

    export default {
        components: { AvatarForm },

        props: ['userdata', 'translations'],

        data() {
            return {
                user: {
                    email: this.userdata.email,
                    name: this.userdata.name,
                    oldPassword: '',
                    newPassword: '',
                    confirmNewPassword: '',
                },
                isActive: false,
                hasError: false,
                notifications: {
                    notifyThreadWasUpdated: this.userdata.is_receive_thread_updates_mail,
                    notifyReplyReaction: this.userdata.is_receive_reply_reactions_mail,
                    notifyMention: this.userdata.is_receive_mention_mail,
                },
                formErrors: {
                    username: null,
                    email: null,
                    oldPassword: null,
                    newPassword: null,
                    confirmNewPassword: null,
                },
                statusMessage: '',
                newEmailNotVerified: null,
                emailNotVerified: (this.userdata.email_verified_at ? null : this.translations.email_not_verified),
                redirectMessage: '',
                counter: null,
                dots: false,

                loading: false,
            }
        },
        methods: {
            submitForm() {
                this.loading = true;

                axios.patch('/profiles/' + this.userdata.name + '/settings/', {
                    'name': this.user.name,
                    'email': this.user.email,
                    'oldPassword': this.user.oldPassword,
                    'newPassword': this.user.newPassword,
                    'confirmNewPassword': this.user.confirmNewPassword,
                    'notifications' : this.notifications,
                })
                    .then((response) => {
                        this.showStatus(response.data.message);
                        this.newEmailNotVerified = response.data.emailMessage;

                        this.loading = false;
                        this.redirectToNewName(response.data.name);
                    })
                    .catch((error) => {
                        Object.assign(this.formErrors, {
                            username: error.response.data.name === null || error.response.data.name === undefined ? null : JSON.stringify(error.response.data.name).replace(/[\[\]"]/g, ''),
                            email: error.response.data.email === null || error.response.data.email === undefined ? null : JSON.stringify(error.response.data.email).replace(/[\[\]"]/g, ''),
                            oldPassword: error.response.data.oldPassword === null || error.response.data.oldPassword === undefined ? null : JSON.stringify(error.response.data.oldPassword).replace(/[\[\]"]/g, ''),
                            newPassword: error.response.data.newPassword === null || error.response.data.newPassword === undefined ? null : JSON.stringify(error.response.data.newPassword).replace(/[\[\]"]/g, ''),
                            confirmNewPassword: error.response.data.confirmNewPassword === null || error.response.data.confirmNewPassword === undefined ? null : JSON.stringify(error.response.data.confirmNewPassword).replace(/[\[\]"]/g, '')
                        });

                        this.loading = false;
                    });
            },

            showConfirmPass() {
                this.isActive = true;
            },

            removeErrorBorder(e) {
                let property = e.target.name;
                this.formErrors[property] = null;
            },
            showStatus(message) {

                this.statusMessage = message;
                var self = this;

                setTimeout(function(){
                    self.statusMessage = '';
                }, 3000);
            },

            redirectToNewName(name) {
                this.redirectMessage = this.translations.redirect_msg;
                this.counter = 3;
                this.dots = true;
                var self = this;

                setInterval(function () {
                    if (self.counter > 0) {
                        self.counter -= 1;
                    }
                }, 1000);

                setTimeout(function() {
                    window.location.replace(window.location.protocol + '//' + window.location.hostname + '/profiles/' + name);
                }, 3000);
            }
        }
    }
</script>
