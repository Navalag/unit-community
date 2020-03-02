<template>
    <div class="tt-value-wrapper">
        <input type="text" name="title" class="form-control" id="title"
               :placeholder="placeholder"  v-model="val"  :maxlength="max" required>
        <span class="tt-value-input" >{{ count }}</span>
    </div>
</template>
<script>
    export default {
        props: ['value', 'translation', 'maxLength'],

        data() {
            return {
                max: parseInt(this.maxLength),
                placeholder: this.translation,
                val: (this.value != null) ? this.value : '',
            };
        },
        computed: {
            count: function(){
                return (this.max - this.val.length);
            }
        }
    }
</script>
