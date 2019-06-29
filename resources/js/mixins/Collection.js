export default {
    data() {
        return {
            items: []
        };
    },

    methods: {
        add(data) {
            this.items.push(data);

            this.$emit('added');
        },

        remove(index) {
            this.items.splice(index, 1);

            this.$emit('removed');

            //TODO: fix this
            // flash('Reply was deleted');
        }
    }
}
