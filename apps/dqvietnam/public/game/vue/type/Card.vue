<template>
  <div class="page-wrapper">

    <div class="page-container">

      <div class="game-04" id="game-card" style="width: 100vh;">

        <div v-for="(card, index) in cards" :key="index"
             :class="classCard(index)" @click="chooseCard(card, index)">
          <div class="wrapper" v-if="this.game.choose_card != index">
            <img class="statu-1" :src="getImg(card)">
          </div>
        </div>

      </div>
    </div>
  </div>
  <div v-if="idSelected" :style="img" id="bg-give-card"></div>
  <div v-if="idSelected" id="give-card">
    <div class="card">
      <img class="img" :src="getImg(selected)" alt="">
    </div>
  </div>
</template>

<script>
import { useGameStore } from '../store/game'

export default {
  name: 'Card',
  props: ['checkAns', 'fnChangeGame', 'audioBg', 'onChose'],
  data() {
    return {
      img: `background-image: url("${base_url}public/game/images/give_gift.gif")`,
      base_url: base_url,
      media_url: media_url,
      cards: [],
      idSelected: false,
      selected: {},
      game: {},
      audioBackgroundCard: {}
    }
  },
  methods: {
    classCard(index) {
      if (this.game.is_done) return 'item';
      return 'item run' + index
    },

    getImg(card) {
      if (card.card.length) return this.media_url + card.card;
      return this.base_url + 'public/game/images/card_empty.webp';
    },

    chooseCard(card, index) {
      const store = useGameStore()
      if (this.game.is_done) return;
      this.selected = card;
      this.idSelected = true;
      store.addCard({card: card.card, index});
      store.saveAnswer(index);
      this.audioBackgroundCard.volume = 0.5;
      playAudio(this.base_url + 'public/game/audio/get_card.mp3');
      this.onChose && this.onChose(true);
      setTimeout(() => {
        $('#give-card img').addClass('save');
        let checkGame = store.correctAnswer;
        if (checkGame.isCorrect) {
          store.logPoint(checkGame.point);
        }
        this.audioBackgroundCard.volume = 1;
      }, 4000);

      setTimeout(() => {
        //this.fnChangeGame();
        this.audioBackgroundCard.pause();
        //this.audioBg.play();
      }, 6000);
    }
  },
  unmounted() {
    this.audioBackgroundCard.pause();
  },
  mounted() {
    const store = useGameStore()
    this.audioBackgroundCard = playAudio(this.base_url + 'public/game/audio/bg_card.mp3', true);

    this.game = store.getGame;
    let content = JSON.parse(this.game.content);
    this.cards = content.cards;
  }
};
</script>
