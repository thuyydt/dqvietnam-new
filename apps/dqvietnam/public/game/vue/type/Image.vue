<template>
    <div class="page-wrapper">
        <div class="page-container">
            <div class="content" style="width: 80%; margin: 0 auto">{{ question }}</div>

            <div class="game-img-timer">{{time}}</div>

            <div class="img" v-if="background" style="margin-top: 30px">
                <div class="game-img" id="game-img">
                    <img class="item background" :src="background" alt="">
                    <img @click="saveValue" v-if="!game.is_done" class="item image" :src="image" alt="">
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import { useGameStore } from '../store/game'

    export default {
        name: 'Image',
        props: ['checkAns', 'fnChangeGame', 'fnNextGame'],
        data() {
            return {
                base_url: base_url,
                media_url: media_url,
                background: '',
                question: '',
                image: '',
                game: {},
                time: 30,
                time2 : 30,
                timeRun: {}
            }
        },
        methods: {
            saveValue() {
                const store = useGameStore()
                store.saveAnswer(true);
                this.chooseIs();
            },
            chooseIs() {
                $('.game-img img.image').addClass('choose_image');
                setTimeout(() => {
                    this.fnNextGame();
                }, 3200)
            },

            stopwatch() {
                this.timeRun = setInterval(() => {
                    this.time -= 1;
                    if (!this.time) {
                        clearInterval(this.timeRun);
                        this.chooseIs();
                    }
                }, 1000);
            },

            renderLocationImg() {
                $('.game-img img.background').on("load", function () {
                    let height = $(this).innerHeight() - 100;
                    let width = $(this).innerWidth() - 100;
                    let x = Math.floor(Math.random() * height);
                    let y = Math.floor(Math.random() * width);

                    $('.game-img img.image').css({
                        'display': 'block',
                        'top': x + 'px',
                        'left': y + 'px',
                    })
                });
            }
        },
        unmounted() {
            clearInterval(this.timeRun);
        },
        mounted() {
            const store = useGameStore()
            new Promise(((resolve, reject) => {
                this.game = store.getGame;
                let content = JSON.parse(this.game.content);

                this.question = content.title;
                this.time2 = this.time = this.game.is_done ? 0 : parseInt(content.time);
                this.image = media_url + content.image;
                this.background = media_url + content.background;

                if (this.background && !this.game.is_done) resolve(this)
                else reject()
            }))
                .then((res) => {
                    if (!this.game.is_done) {
                        this.renderLocationImg();
                        this.stopwatch();
                    }
                })
                .catch(() => {
                })

        }
    };
</script>
