<template>
  <Loading v-bind:isLoad="isLoad"/>

  <img class="bg-slider" :src="theme.background">
  <div class="section-info">
    <div class="item item-01">
      <img :src="base_url + 'public/game/images/name.webp'">
      <div class="item-info">{{ task.name }}</div>
      <div class="avatar"><img :src="getAvatarUser(account)"></div>
    </div>
    <div class="box">
      <div class="item item-02 btn-menu points">
        <div class="effect-get-gift get-points" :data-status=" parseInt(numCoins) < 0 ? 'minus' : 'plus' "
             v-if="isGetCoins">
          <span class="plus">+</span>{{ numCoins }}
        </div>
        <img :src="base_url + 'public/game/images/vang.webp'">
        <div class="item-info" :key="coins">{{ coins }}</div>
      </div>
      <div class="item item-03 btn-menu cards">
        <div class="effect-get-gift get-cards" v-if="isGetCards">
          +<img :src="base_url + 'public/game/images/card_empty.webp'"/>
        </div>
        <img :src="base_url + 'public/game/images/the-bao.webp'">
      </div>

      <div @click="closeGame()" style="cursor: pointer" class="item item-04">
        <img :src="base_url + 'public/game/images/x.webp'">
      </div>
    </div>
  </div>

  <div class="slider" :id="theme.layout" v-if="isStart">

    <button v-if="showPrevGame && key>0" @click="prevGame" id="prev-game" class="prev-game slick-prev slick-arrow"
            aria-label="Previous" type="button">
      Previous
    </button>

    <div class="page" v-if="!loading">
      <Slide v-bind:checkAns="checkAnswer"
             v-bind:onPlayEnd="onPlayEnd"
             :key="key" v-if="typeGame==0">

      </Slide>

      <Question v-bind:onChose="onChose"
                v-bind:checkAns="checkAnswer" :key="key" v-if="typeGame==1">

      </Question>

      <Fill v-bind:onChose="onChose" v-bind:checkAns="checkAnswer" :key="key" v-if="typeGame==2"></Fill>

      <Crossword v-bind:checkAns="checkAnswer" :key="key" v-if="typeGame==3"></Crossword>

      <Images v-bind:checkAns="checkAnswer" v-bind:fnNextGame="nextGame" v-bind:fnChangeGame="changeGame" :key="key"
              v-if="typeGame==4"></Images>

      <Card
            v-bind:onChose="onChose"
            v-bind:fnChangeGame="changeGame" :key="key"
            v-if="typeGame==5"></Card>

      <Chat v-bind:onChose="onChose" v-bind:user="account" v-bind:checkAns="checkAnswer"
            v-bind:fnChangeGame="changeGame" :key="key"
            v-if="typeGame==6"></Chat>

    </div>

    <button v-if="showNextGame" @click="nextGame" id="next-game" class="next-game slick-next slick-arrow"
            aria-label="Next"
            type="button">
      Next
    </button>

  </div> <!-- / slider -->
  <!--    <div class="slider" v-else>-->
  <!--        <button @click="startGame" class="btn-start">BẮT ĐẦU</button>-->
  <!--    </div>-->

</template>

<script>
import { mapState, mapActions } from 'pinia'
import { useGameStore } from './store/game'

import Slide from "./type/Slide";
import Question from "./type/Question";
import Fill from "./type/Fill";
import Crossword from "./type/Crossword";
import Chat from "./type/Chat";
import Card from "./type/Card";
import Images from "./type/Image";
import Loading from "./type/Loading";

export default {
  name: 'Play Game',
  data() {
    return {
      checkAnswer: 0,
      showSetting: false,
      hideEffect: false,
      base_url,
      showNextGame: 1,
      showPrevGame: 1,
      typeGame: -1,
      isChooseAnswer: false,
      isWatched: false,
      isLoad: false,
      theme: {
        background: '',
        layout: ''
      },
    };
  },
  components: {Loading,  Slide, Question, Fill, Crossword, Chat, Card, Images},
  methods: {
    ...mapActions(useGameStore, {
        setIsWatched: 'setIsWatched',
        startGameAction: 'startGame',
        changeGameAction: 'changeGame',
        logPoint: 'logPoint',
        loadTask: 'loadTaskAction',
        doneTasks: 'doneTasksAction'
    }),
    onPlayEnd(value) {
      this.isWatched = value;
      if (this.game.type == 0 && this.video) {
        this.setIsWatched(`video_${this.game.id}`);
      }
    },
    onChose(value) {
      this.isChooseAnswer = value
    },
    onShowSetting() {
      this.showSetting = !this.showSetting;
    },
    startGame() {
      // this.audioBackground = playAudio(this.base_url + 'public/game/audio/bg_game.mp3', true);
      // this.startGameAction();
    },
    closeGame() {
      window.location.href = this.base_url + 'hocbai';
    },
    nextGame() {
      if (this.game.type == 0 && !this.isWatched && !this.isReviewBack) {
        alert('Hãy xem hết video bạn nhé!');
        return false;
      }
      const content = JSON.parse(this.game.content);
      this.hideEffect = content.hide_effect;
      const backList = this.getBackList;
      if (!this.isChooseAnswer && !backList.includes(this.key) && [1, 2, 3, 5, 6].includes(parseInt(this.game.type))) {
        alert('Hãy chọn câu trả lời bạn nhé!');
        return;
      }
      if (this.game.type === 0) {
        this.isLoad = true;
      } else {
        setTimeout(() => this.isLoad = true, 800);
      }

      $('#next-game').attr('disabled', 'disabled');
      $('#prev-game').attr('disabled', 'disabled');
      if (this.key == this.task.task_detail.length - 1) {
        this.showNextGame = false;
        this.showPrevGame = false;
      }

      if (this.game.is_done) {
        this.changeGame();
      } else if (this.game.type == 3) {
        this.checkAnswer = 1;
        this.audioAnswer();

        setTimeout(() => {
          this.checkAnswer = 3;
        }, 1000);

        setTimeout(() => {
          this.changeGame();
          this.checkAnswer = 0;
        }, 3000)

      } else {
        this.checkAnswer = 1;
        this.audioAnswer();
        setTimeout(() => {
          this.changeGame();
          this.checkAnswer = 0;
        }, 1500);
      }
    },
    prevGame() {
      this.changeGameAction('prev');
      console.log("THIS BACKLIST", this.backList);

    },
    changeGame() {
      this.isChooseAnswer = false;
      if (this.key == this.task.task_detail.length - 1) {
        this.doneTasks();
      } else {
        this.changeGameAction('next');
      }
    },
    audioAnswer() {
      setTimeout(() => {
        let checkGame = this.correctAnswer;
        if (checkGame.isCorrect && !checkGame.hideEffect) {
          //if (checkGame.isCorrect === 'right')
          new Audio(base_url + 'public/game/audio/' + checkGame.isCorrect + '.mp3').play();
          this.logPoint(checkGame.point);
        }
        if (checkGame.hideEffect) {
          this.logPoint(checkGame.point);
        }
      }, 200)
    },
    getAvatarUser(account) {
      if (account.avatar == '') {
        return `public/game/images/avatar.webp`;
      }

      return account.avatar;
    },
  },
  created() {
    this.loadTask();

  },
  mounted() {
    let isAutoPlay = getCookie('dq_play_audio_background');
    if (!isAutoPlay) {
      this.audioBackground = playAudio(this.base_url + 'public/game/audio/bg_game.mp3', true);
    } else {
      this.audioBackground = {
        play: () => false,
        pause: () => true
      }
    }

    if (this.isLoad) {
      this.isLoad = false;
    }

  },
  computed: {
    ...mapState(useGameStore, [ 'isStart', 'task', 'loading', 'game', 'key', 'coins', 'isGetCoins', 'isSetting', 'numCoins', 'isGetCards', 'account', 'getBackList', 'correctAnswer']),
  },
  watch: {
    isLoad: {
      handler() {
        setTimeout(() => this.isLoad = false, 1000)
      }
    },
    task: {
      handler(task) {
        let key = parseInt(task.key);

        if (key <= 10) {
          this.theme.background = this.base_url + 'public/game/images/bgk1.webp';
          this.theme.layout = 'round-1';
        } else if (key <= 20) {
          this.theme.background = this.base_url + 'public/game/images/bgk2.webp';
          this.theme.layout = 'round-2';
        } else if (key <= 30) {
          this.theme.background = this.base_url + 'public/game/images/bgk3.webp';
          this.theme.layout = 'round-3';
        } else if (key <= 40) {
          this.theme.background = this.base_url + 'public/game/images/bgk4.webp';
          this.theme.layout = 'round-4';
        } else if (key <= 50) {
          this.theme.background = this.base_url + 'public/game/images/bgk5.webp';
          this.theme.layout = 'round-5';
        } else if (key <= 60) {
          this.theme.background = this.base_url + 'public/game/images/bgk6.webp';
          this.theme.layout = 'round-6';
        } else if (key <= 70) {
          this.theme.background = this.base_url + 'public/game/images/bgk7.webp';
          this.theme.layout = 'round-7';
        } else if (key <= 80) {
          this.theme.background = this.base_url + 'public/game/images/bgk8.webp';
          this.theme.layout = 'round-8';
        }
      }
    },
    game: {
      handler(game) {
        this.isLoad = false;
        if (typeof game === "undefined") {
          window.location.href = base_url + 'hocbai?status=error';
          return;
        }

        let type = this.typeGame = parseInt(game.type);

        if (type === 6) {
          this.showPrevGame = 0;
          this.showNextGame = 0;
        } else {
          this.showPrevGame = 1;
          this.showNextGame = 1;
        }

        setTimeout(() => {
          $('#next-game').removeAttr('disabled')
          $('#prev-game').removeAttr('disabled')
        }, 300)
      }
    }
  }
};
</script>
