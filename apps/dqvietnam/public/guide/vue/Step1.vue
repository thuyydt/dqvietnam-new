<template>
    <div class="media">
        <div class="media-wrapper">
            <video autoplay controlsList="nodownload" controls preload="metadata" id="video-guide">
                <source :src="video" type="video/mp4">
            </video>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'Step1',
        mounted() {
            let video = document.getElementById('video-guide');
            video.play();
        },
        data() {
            return {
                video: base_url + 'public/guide/videos/video.mp4'
            }
        }
    };
</script>
