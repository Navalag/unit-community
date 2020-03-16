<template>
    <li v-show="notifications.length" class="nav-item dropdown">
        <a href="#" class="tt-btn-icon dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <i class="tt-icon"><svg><use xlink:href="#icon-notification"></use></svg></i>
        </a>

        <div v-for="notification in notifications" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a v-text="notification.data.message"
               class="dropdown-item"
               :href="notification.data.link"
               @click="markAsRead(notification)"
            ></a>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return { notifications: false }
        },

        created() {
            axios.get(`/${window.App.locale}/profiles/${window.App.user.name}/notifications`)
                 .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete(`/${window.App.locale}/profiles/${window.App.user.name}/notifications/${notification.id}`);
            }
        }
    }
</script>
