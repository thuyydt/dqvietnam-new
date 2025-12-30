<template>
  <div class="page-wrapper" :data-status="statusGame()">
    <img v-if="image" :src="image" style="height: 55vh;">
    <div class="media" v-if="video">
      <div class="media-wrapper" style="width: 120vh">
        <video v-on:playing="playIng" ref="videoRef" controls autoplay preload="metadata" id="video"
               controlsList="nodownload">
          <source :src="video+'#t=0.5'" type="video/mp4">
        </video>
      </div>
    </div>
    <button style="display: none" ref="btnRef" @click="playVideo">Play</button>

    <div class="firework" v-if="is_firework">
      <img class="" :src="base_url + 'public/game/images/firework.webp'" alt="firework">
    </div>
  </div>
</template>

<script>
import { useGameStore } from '../store/game'

export default {
  name: 'Slide',
  props: [ 'checkAns', 'onPlayEnd'],
  data() {
    return {
      base_url: base_url,
      game: {},
      image: '',
      timing: 0,
      video: '',
      videoElement: null,
      muted: true,
      is_firework: 0
    }
  },
  methods: {
    playIng() {
      const video = document.getElementById('video');
      let watchedTime = 0;
      let currentTime = 0;
      if (video) {
        const instance = this;
        video.addEventListener('ended', function (e) {
          // Your code goes here
          instance.onPlayEnd(true);
        });
        video.addEventListener('timeupdate', function (e) {
          // Your code goes here
          if (!video.seeking) {
            if (video.currentTime > watchedTime) {
              watchedTime = video.currentTime;
              if (watchedTime >= video.duration / 2) {
                instance.onPlayEnd(true);
              }
            } else {
              //tracking time updated  after user rewinds
              currentTime = video.currentTime;
              if (watchedTime >= video.duration / 2) {
                instance.onPlayEnd(true);
              }
            }
          }
          if (!document.hasFocus()) {
            //video.pause();
          }
        });
      }
    },
    statusGame() {
      return this.checkAns;
    },
  },

  async mounted() {
    const store = useGameStore()
    try {
      this.game = store.getGame;
      let content = JSON.parse(this.game.content);
      if (typeof content.is_firework !== "undefined") {
        this.is_firework = content.is_firework;
      }
      if (content.image.length) {
        if (content.image.split('.').at(-1) === 'mp4') {
          this.video = media_url + content.image;
          this.$refs.btnRef.click();
        } else {
          this.image = media_url + content.image;
          this.onPlayEnd && this.onPlayEnd(true)
        }
      }
    } catch (e) {
      this.$refs.btnRef.click()
    }
  }
};
</script>
