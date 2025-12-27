<template>
    <div class="app" style="background-image: url(./public/guide/images/bg-main.jpg);">

        <Step1 v-if="step===1"></Step1>
        <Step2 v-if="step===2"></Step2>
        <Step3 v-if="step===3"></Step3>
        <Step4 v-if="step===4"></Step4>
        <Step5 v-if="step===5"></Step5>
        <Step6 v-if="step===6"></Step6>
        <Step7 v-if="step===7"></Step7>

        <div class="btn-box" v-if="step<7">
            <a v-if="step > 1" @click="step--" href="javascript:;" class="btn">TRỞ LẠI</a>
            <a @click="step++" href="javascript:;" class="btn">TIẾP TỤC</a>
        </div>
    </div>
</template>

<script>
    import Step1 from "./Step1";
    import Step2 from "./Step2";
    import Step3 from "./Step3";
    import Step4 from "./Step4";
    import Step5 from "./Step5";
    import Step6 from "./Step6";
    import Step7 from "./Step7";

    export default {
        name: 'Guide',
        data() {
            return {
                step: 1,
                audioBackground: new Audio(base_url + 'public/guide/audio/audio-guide.mp3')
            };
        },
        components: {
            Step1, Step2, Step3, Step4, Step5, Step6, Step7
        },
        mounted() {
            this.audioBackground.addEventListener('ended', function () {
                this.currentTime = 0;
                this.play();
            }, false);
        },
        watch: {
            step: {
                handler(step) {
                    if (step===1) {
                        this.audioBackground.pause();
                    }
                    if (step>1) {
                        this.audioBackground.play();
                    }
                }
            }
        }
    };
</script>