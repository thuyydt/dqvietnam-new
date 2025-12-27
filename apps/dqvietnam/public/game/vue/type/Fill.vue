<template>
  <div class="page-wrapper">

    <div class="page-container">

      <div class="game-01" :data-status="checkAnswer()">
        <div class="img-game" v-if="image">
          <img :src="image">
        </div>

        <div class="media" v-if="video">
          <div class="media-wrapper">
            <video controls preload="metadata">
              <source :src="video+'#t=0.5'" type="video/mp4">
            </video>
          </div>
        </div>

        <div class="box" v-for="(box, iBox) in chars" :key="iBox">
          <div class="item" v-for="(char, iChar) in box" :key="char.index">
            <input v-if="char.is_fill && !game.is_done" :class="classChar(char.char, iChar)"
                   @input="enterChar($event, char.index)" maxlength="1"
                   type="text" :value="checkAns ? char.char : getAnswers(char.index)">
            <template v-else>{{ char.char }}</template>
          </div>
        </div>
      </div>

    </div>

  </div>
</template>

<script>

import {toRaw} from "vue";
import { useGameStore } from '../store/game'

export default {
  name: 'Fill',
  props: ['checkAns', 'onChose'],
  data() {
    return {
      image: '',
      video: '',
      question: '',
      chars: [],
      game: {},
      answers: {}
    }
  },
  methods: {
    getAnswers(index) {
      const store = useGameStore()
      let data = store.getAnswerOnGameCurrent;
      if (!data) return '';
      if (typeof data[index] !== "undefined") return data[index];
      return '';
    },
    enterChar(event, index) {

      this.answers[index] = event.target.value.toUpperCase();

      const isFill = this.chars.flat().filter(char => char.is_fill);
      const values = Object.values(toRaw(this.answers));

      if (values.length === isFill.length) {
        this.onChose && this.onChose(true);
      } else {
        this.onChose && this.onChose(false);
      }
    },
    classChar(answer, index) {
      if (this.checkAns) {
        return 'fill-char exactly-char';
      }
      return 'fill-char';
    },
    checkAnswer() {
      const store = useGameStore()
      if (this.checkAns) {
        store.saveAnswer(this.answers);
      }
      return this.checkAns;
    },
  },
  mounted() {
    const store = useGameStore()
    this.game = store.getGame;
    this.onChose && this.onChose(this.game.is_done);
    let content = JSON.parse(this.game.content);
    this.question = content.title;
    let key = 0;
    this.chars[key] = [];
    content.chars.map((e, i) => {
      if (e.is_space) {
        key += 1;
        this.chars[key] = [];
      } else {
        e.index = i;
        this.chars[key].push(e);
      }
    });

    if (content.image.length) {
      if (content.image.split('.').at(-1) === 'mp4') {
        this.video = media_url + content.image;
      } else {
        this.image = media_url + content.image;
      }
    }
  }
};
</script>
