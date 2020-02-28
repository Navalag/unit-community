<template>
    <div class="tt-row py-4" v-if="shouldPaginate">
        <ul class="pagination">
            <li :class="classes(prevUrl)">
                <a class="page-link" href="#" aria-label="Previous" @click.prevent="page--">
                    <span aria-hidden="true" v-html="translations.prev"></span>
                </a>
            </li>

            <li :class="classes(nextUrl)">
                <a class="page-link" href="#" aria-label="Next" @click.prevent="page++">
                    <span aria-hidden="true" v-html="translations.next"></span>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['dataSet', 'translations'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                this.broadcast().updateUrl();
            }
        },

        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {
            classes(isSetPageLink) {
                return ['page-item', ! isSetPageLink ? 'disabled' : ''];
            },

            broadcast() {
                return this.$emit('changed', this.page);
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>
