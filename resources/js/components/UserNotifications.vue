<template>
        <div class="nav-item dropdown tt-notifications">
            <a href="#" class="tt-btn-icon" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                <div class="tt-icon">
                    <svg><use xlink:href="#icon-notification"></use></svg>
                    <div class="notification-counter" v-show="count"> {{ count }} </div>
                </div>
            </a>
            <div  v-show="notifications.length" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <form>
                    <div v-for="(notification, index) in notifications" class="notifications-item">
                        <a v-text="notification.data.greeting"
                           class="dropdown-item"
                           :href="notification.data.actionUrl"
                           @click="markAsRead(notification, index)"
                        ></a>
                        <button @click.prevent="markAsRead(notification, index)"> <svg><use xlink:href="#icon-cancel"></use></svg></button>
                    </div>
                </form>
            </div>
        </div>
</template>

<script>
    export default {
        data() {
            return {
                notifications: false,
                count: 0,
            }
        },

        created() {
            axios.get(`/${window.App.locale}/profiles/${window.App.user.name}/notifications`)
                 .then((response) => {
                     this.notifications = response.data;
                     this.count = this.notifications.length;
                 });
        },

        methods: {
            markAsRead(notification, index) {
                axios.delete(`/${window.App.locale}/profiles/${window.App.user.name}/notifications/${notification.id}`);
                this.notifications.splice(index, 1);
                this.count -= 1;
            }
        }
    }
</script>
