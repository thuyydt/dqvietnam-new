<template>
    <a :href="start" class="btn btn-big">BẮT ĐẦU</a>
</template>

<script>
    export default {
        name: 'Step7',
        data() {
            return {
                start: base_url + 'hocbai/training',
            };
        }
    };
</script>
