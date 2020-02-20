<template>
    <div>
        <label for="imgupload" class="btn btn-primary custom-upload">Upload picture</label>
        <input type="file" id="imgupload" accept="image/*" class="btn btn-primary custom-upload d-none" @change="onChange">
    </div>
</template>

<script>
    export default {
        methods: {
            onChange(e) {
                if (! e.target.files.length) return;

                let file = e.target.files[0];

                let reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = e => {
                    let src = e.target.result;

                    this.$emit('loaded', { src, file });
                };
            }
        }
    }
</script>
