<template>
  <div class="page-wrapper" :data-status="statusGame()">

    <div class="page-container">

      <img class="bg-page" v-if="image && is_background" :src="image">

      <div class="content title-question" v-if="question" style="width: 70%; margin: 0 auto">{{ question }}</div>

      <div class="img" v-if="image && !is_background">
        <img :src="image" style="height:35vh">
      </div>

      <div class="media" v-if="video">
        <div class="media-wrapper">
          <video controls preload="metadata">
            <source :src="video+'#t=0.5'" type="video/mp4">
          </video>
        </div>
      </div>
      <div class="selects" :id="checkAns">
        <div v-for="(answer, index) in answers" :class="classLayout()" :key="index">
          <a @click="choiceAnswer(answer, index)" disabled="true"
             href="javascript:;" :data-key="index" :class="classAnswer(answer, index)">
            {{ answer.title }}
          </a>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { useGameStore } from '../store/game'

export default {
  name: 'Question',
  props: ['checkAns', 'onChose'],
  data() {
    return {
      image: '',
      video: '',
      question: '',
      answers: [],
      is_background: 0,
      hide_effect: false,
      is_chat: 0,
      is_next: 1,
      isAudioBgPause: false,
      isReview: false,
      layout: 1,
      game: {},
      chooseAnswer: null,
      activeIndex: -1,
      multi_answer: 0
    }
  },
  methods: {
    classLayout() {
      switch (this.layout) {
        case 2:
          return 'answer w50';
        case 3:
          return 'answer w33';
        case 4:
          return 'answer w25';
      }
      return 'answer w100';
    },
    classAnswer(answer, index) {
      const store = useGameStore()
      let data = store.getAnswerOnGameCurrent;
      let classBtn = 'btn-answer';
      if (this.checkAns && this.isAudioBgPause) {
        //this.audioBg.play();
      }

      if (this.activeIndex === index || data === index) {
        classBtn = 'btn-answer active';
      }

      if (this.checkAns && answer.is_right && !this.hide_effect) {
        classBtn = 'btn-answer exactly';
      }

      // if (data === index) {
      //   classBtn = 'btn-answer active';
      // }
      return classBtn;
    },
    choiceAnswer(answer, index) {
      if (this.game.is_done) return;
      this.activeIndex = index;
      this.onChose && this.onChose(true);
      if (!this.chooseAnswer || this.chooseAnswer?.title !== answer.title) {
        this.chooseAnswer = answer;
      } else {
        this.chooseAnswer = null;
        this.onChose && this.onChose(false);
        this.activeIndex = -1;
      }
    },
    statusGame() {
      const store = useGameStore()
      if (this.checkAns && this.is_next && !this.game.is_done) {

        //let indexChooseAnswer = Object.keys(this.chooseAnswer);
        store.saveAnswer(this.activeIndex);

        if (this.is_chat) {
          let contentChooseAnswer = [];
          // Object.keys(this.chooseAnswer).map((key, index) => {
          //   contentChooseAnswer.push(this.chooseAnswer[key].title);
          // });
          contentChooseAnswer.push(this.chooseAnswer?.title);

          if (contentChooseAnswer.length) {
            let data = {content: contentChooseAnswer, isBot: false};
            store.addChat(data);
          }
        }

        this.is_next = 0;
      }
      return this.checkAns;
    }
  },
  mounted() {
    const store = useGameStore()
    new Promise(resolve => {
      //const isReviewBack = this.$store.getters.getIsReviewBack;
      this.onChose && this.onChose(this.game.is_done);

      this.game = store.getGame;
      this.isReview = store.getIsReview;
      let content = JSON.parse(this.game.content);
      this.question = content.title;
      this.answers = content.answers;
      this.multi_answer = content.multi_answer ?? 0;

      this.is_background = content.is_background ? 1 : 0;
      this.hide_effect = content.hide_effect;

      this.is_chat = content.is_chat ? 1 : 0;
      if (typeof content.layout !== "undefined") {
        this.layout = parseInt(content.layout);
      }

      if (content.image.length) {
        if (content.image.split('.').at(-1) === 'mp4') {
          this.video = media_url + content.image;
        } else {
          this.image = media_url + content.image;
        }
      }

      if (this.isReview) {

        let answerOld = store.getAnswerOnGameCurrent;
        let contentChooseAnswer = [];
        Object.keys(answerOld).map((key, index) => {
          contentChooseAnswer.push(this.answers[answerOld[key]].title);
        })
        let data = {content: contentChooseAnswer, isBot: false};
        store.addChat(data);
      }

      if (this.answers.length) resolve(this);
    })
        .then(res => {
          if (this.video.length) {
            this.playVideo();
          }
        })
  }
};
</script>
