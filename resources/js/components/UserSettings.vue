<template>
        <form class="form-default" >
            <div class="tt-form-upload">
                <avatar-form :user="user"></avatar-form>
            </div>
            <div class="form-group">
                <label for="settingsUserName">Username</label>
                <input class="d-none" type="password" name="whatever" autocomplete="new-password" />
                <input type="text" name="username" class="form-control" :class="{ hasError: formErrors.username }" id="settingsUserName" v-model="username" :placeholder="usernamePlaceholder" @focus="removeErrorBorder">
                <div v-if="formErrors.username"> {{ formErrors.username }}</div>
            </div>
            <div class="form-group">
                <label for="settingsUserEmail">Email</label>
                <input type="email" name="email" class="form-control" :class="{ hasError: formErrors.email}" id="settingsUserEmail" v-model="email" :placeholder="emailPlaceholder" @focus="removeErrorBorder">
                <div v-if="formErrors.email"> {{ formErrors.email }}</div>
                <div v-if="newEmailNotVerified"> {{ newEmailNotVerified }}</div>
                <div>{{ emailNotVerified }} </div>
            </div>
            <div class="form-group">
                <label for="settingsUserOldPassword">Old password</label>
                <input type="password" name="oldPassword" class="form-control"  :class="{ hasError: formErrors.oldPassword }" id="settingsUserOldPassword" placeholder="************" v-model="oldPassword" @focus="removeErrorBorder">
                <div v-if="formErrors.oldPassword"> {{ formErrors.oldPassword }}</div>
            </div>
            <div class="form-group">
                <label for="settingsUserNewPassword">New password</label>
                <input  type="password" name="newPassword" class="form-control" :class="{ hasError: formErrors.newPassword }" id="settingsUserNewPassword" placeholder="************" v-model="newPassword" @click="showConfirmPass" @focus="removeErrorBorder">
                <div v-if="formErrors.newPassword"> {{ formErrors.newPassword }}</div>
            </div>
            <div class="form-group confirm-password-hidden" :class="{ isActive: isActive }">
                <label for="confirmUserNewPassword">Confirm new password</label>
                <input type="password" name="confirmNewPassword" class="form-control" :class="{ hasError: formErrors.confirmNewPassword }"  id="confirmUserNewPassword" placeholder="************" v-model="confirmNewPassword" @focus="removeErrorBorder">
                <div v-if="formErrors.confirmNewPassword"> {{ formErrors.confirmNewPassword }}</div>
            </div>
            <div class="form-group">
                <button href="#" class="btn btn-secondary" v-on:click.prevent="submitForm" :disabled="disableButton">Save</button>
            </div>
            <div> {{ statusMessage }}</div>
            <div> {{ redirectMessage }} {{ counter }} <span class="redirect-message-dots" :class="{ isActive: dots }">...</span></div>

        </form>
</template>

<script>
    import AvatarForm from '../components/AvatarForm.vue';

    export default {
        props: [
            'userdata'
        ],
        data() {
            return {
                user: this.userdata,
                username: null,
                email: null,
                emailPlaceholder: this.userdata.email,
                usernamePlaceholder: this.userdata.name,
                about: '',
                oldPassword: '',
                newPassword: '',
                oldName: this.userdata.name,
                isActive: false,
                hasError: false,
                confirmNewPassword: '',
                formErrors: {
                    username: null,
                    email: null,
                    oldPassword: null,
                    newPassword: null,
                    confirmNewPassword: null,
                },
                statusMessage: '',
                newEmailNotVerified: null,
                emailNotVerified: (this.userdata.email_verified_at ? null : 'Your email not verified'),
                redirectMessage: '',
                counter: null,
                dots: false,
            }
        },
        components:{
          AvatarForm
        },
        computed:{
            disableButton: function()
            {
                 if((this.email != null && this.email.length > 0) || (this.username != null && this.username.length > 0) || this.oldPassword != null && this.oldPassword.length > 0){
                     return false;
                 }
                return true;
            }
        },
        methods: {
            submitForm()
            {
                axios.patch('/profiles/' + this.userdata.name + '/settings/', {
                    name: this.username,
                    email: this.email,
                    oldPassword: this.oldPassword,
                    newPassword: this.newPassword,
                    confirmNewPassword: this.confirmNewPassword,
                })
                .then((response) => {
                    this.showStatus(response.data.message);
                    this.newEmailNotVerified = response.data.emailMessage;
                    if(String(response.data.name) != String(this.oldName)){
                        this.redirectToNewName(response.data.name);
                    }
                })
                .catch((error) => {
                      Object.assign(this.formErrors, {
                          username: error.response.data.name === null || error.response.data.name === undefined ? null : JSON.stringify(error.response.data.name).replace(/[\[\]"]/g, ''),
                          email: error.response.data.email === null || error.response.data.email === undefined ? null : JSON.stringify(error.response.data.email).replace(/[\[\]"]/g, ''),
                          oldPassword: error.response.data.oldPassword === null || error.response.data.oldPassword === undefined ? null : JSON.stringify(error.response.data.oldPassword).replace(/[\[\]"]/g, ''),
                          newPassword: error.response.data.newPassword === null || error.response.data.newPassword === undefined ? null : JSON.stringify(error.response.data.newPassword).replace(/[\[\]"]/g, ''),
                          confirmNewPassword: error.response.data.confirmNewPassword === null || error.response.data.confirmNewPassword === undefined ? null : JSON.stringify(error.response.data.confirmNewPassword).replace(/[\[\]"]/g, '')
                      });
                });
            },
            showConfirmPass()
            {
                this.isActive = true;
            },
            removeErrorBorder(e)
            {
                let property = e.target.name;
                this.formErrors[property] = null;
            },
            showStatus(message)
            {
                this.statusMessage = message;
                var self = this;
                setTimeout(function(){
                    self.statusMessage = '';
                }, 3000);
            },
            redirectToNewName(name)
            {
                this.redirectMessage = 'Take you to profile with a new username ';
                this.counter = 3;
                this.dots = true;
                var self = this;
                setInterval(function () {
                    self.counter -= 1;
                }, 1000);
                setTimeout(function(){
                    window.location.replace(window.location.protocol + '//' + window.location.hostname + '/profiles/' + name);
                }, 3000);
            }
        }
    }
</script>
