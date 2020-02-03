<template>
<div class="container">
    <div class="tt-topic-list">
            <div v-for="activity_obj in activities">
                    <div class="tt-item" v-for="activity in activity_obj">
                        <div class="tt-col-avatar">
                            <img class="tt-icon" src="<%= BASE_URL %>/images/svg-sprite/icon-ava-v.svg" alt="">
                        </div>
                        <div class="tt-col-description">
                            <h6>
                                <a href="">
                                    {{ activity.subject.title }}
                                </a>
                            </h6>
                        </div>
                        <div class="tt-col-message">
                        </div>
                        <div class="tt-col-category"><span class="tt-colortt-badge"></span></div>
                        <div class="tt-col-value hide-mobile"></div>

                    </div>
            </div>
    </div>
</div>
</template>

<script>

    export default {
            props: [
                "activities"
            ],
            data(){
                return{
                    mess: 'fuck',
                    loading:false,
                    nextItem: 1,
                    itens: [],
                };
            },

            mounted() {
                console.log('OK');
            }
    }
</script>
