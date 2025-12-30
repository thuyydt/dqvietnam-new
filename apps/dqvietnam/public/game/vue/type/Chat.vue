<template>
  <div class="page-wrapper">

    <div class="c-chat">

      <div class="chat-header">
        <h4>Tin nhắn</h4>
        <h3 style="text-transform: uppercase">{{ sender }}</h3>
      </div>

      <div class="chat-main">

        <div class="chat-left">
          <div :class="getItemUserActive(sender, 'lita')">
            <div class="avatar">
              <div class="img-wrapper"><img :src="checkUrlImage('lita', 'avatar')"></div>
            </div>
            <div class="info">
              <div class="name">Lita</div>
              <div class="notification">Lita đã gửi 1 tin nhắn</div>
              <div class="line"></div>
              <div class="line"></div>
            </div>
          </div><!-- / item -->
          <div :class="getItemUserActive(sender, 'alvin')">
            <div class="avatar">
              <div class="img-wrapper"><img :src="checkUrlImage('alvin', 'avatar')"></div>
            </div>
            <div class="info">
              <div class="name">Alvin</div>
              <div class="notification">Alvin đã gửi 1 tin nhắn</div>
              <div class="line"></div>
              <div class="line"></div>
            </div>
          </div><!-- / item -->
          <div :class="getItemUserActive(sender, 'amiga')">
            <div class="avatar">
              <div class="img-wrapper"><img :src="checkUrlImage('amiga', 'avatar')"></div>
            </div>
            <div class="info">
              <div class="name">Amiga</div>
              <div class="notification">Amiga đã gửi 1 tin nhắn</div>
              <div class="line"></div>
              <div class="line"></div>
            </div>
          </div><!-- / item -->
        </div><!-- / left -->

        <div class="chat-right">

          <div class="chat-content">

            <div id="list-item-content">
              <div v-for="(message, index) in chat" :key="index"
                   :class=" message.isBot ? 'item-content' : 'item-content right'">

                <div v-if="message.isBot" class="avatar"><img :src="checkUrlImage(sender, 'avatar')">
                </div>
                <div v-else class="avatar"><img :src="getAvatarUser(account)"></div>

                <div class="inner">
                  <template v-for="(item, iItem) in message.content" :key="iItem">
                    <div class="inner-content">{{ item }}</div>
                    <br>
                  </template>
                </div>
              </div>
            </div>
            <div class="box-chat" style="height: auto;">
              <div v-if="activeSp && !this.game.is_done" class="item-chat">
                <img class="avatar" :src="checkUrlImage(sender, 'avatar')" alt="">
                <div class="list-item">
                                    <span class="item" style="line-height: 0.7 !important; padding: 3vh">
                                        <div style="display: inline-flex;">
                                            <span class="spinner"></span>
                                            <span class="spinner"></span>
                                            <span class="spinner"></span>
                                        </div>
                                    </span>
                </div>
              </div>
            </div>

          </div>

          <div class="btn">
            <div class="btn-group" style="width: 71%" v-if="typeQuestion && !activeSp">
              <a @click="nextGame(true)" href="javascript:;" class="btn-chat"
                 style="width: 40vh; margin: 0 auto">Chọn câu trả lời</a>
            </div>
            <div class="c-btn-group" style="width: 71%" v-if="!typeQuestion && !activeSp">
              <div class="choose-the-answer" style="width: 85vh;">
                <div class="chat-answer hiden" v-for="(item, index) in answers"
                     @click="chooseAnswer(index, item.data)" :key="index">
                  {{ item.data }}
                </div>
              </div>
              <a @click="nextGame(false)" href="javascript:;" class="btn-chat  ">Trả lời</a>
            </div>
            <div class="btn-group" style="width: 71%" v-if="this.game.is_done">
              <a @click="nextGame(true)" href="javascript:;" class="btn-chat"
                 style="width: 40vh; margin: 0 auto">Tiếp tục</a>
            </div>
          </div>

        </div><!-- / right -->

      </div>
    </div>
  </div>
</template>

<script>
import { useGameStore } from '../store/game'

export default {
  name: "Chat",
  props: ['checkAns', 'fnChangeGame', 'user', 'onChose'],

  data() {
    return {
      content: [],
      sender: "",
      answers: [],
      chat: [],
      game: {},
      account: {},
      url_image: "",
      isActive: 0,
      activeSp: true,
      typeQuestion: false,
      isReview: false,
      isChooseAnswer: 0,
      saveChooseAnswer: 0,
      contentChooseAnswer: '',
    };
  },
  methods: {
    getItemUserActive(sender, name) {
      if (sender === name) return 'item-user active';
      return 'item-user'
    },
    chooseAnswer(index, content) {
      this.isChooseAnswer = 1;
      this.saveChooseAnswer = index;
      this.contentChooseAnswer = content;
      this.onChose && this.onChose(true);

    },
    checkUrlImage: (sender, type = 'bg') => {

      return `public/game/images/chat/${type}-${sender}.webp`;
    },
    getAvatarUser(account) {
      if (account.avatar == '') {
        return `public/game/images/avatar.webp`;
      }

      return account.avatar;
    },
    animationScroll() {
      $(".chat-content").animate({
        scrollTop: $(".chat-content")[0].scrollHeight,
      }, 800);
    },
    showMessage() {

      let id = this.makeID(10);
      let avatar = this.checkUrlImage(this.sender, 'avatar')
      let htmlChat = `<div class="item-content" id="${id}" style="display: none">
                                    <div class="avatar"> <img src="${avatar}" alt=""> </div>
                                    <div class="inner"></div>
                                </div>`
      $('#list-item-content').append(htmlChat);
      this.animationScroll();

      let timeRender = 1500;
      if (this.game.is_done) timeRender = 1;

      const render = setInterval(() => {
        this.renderMessage(id, this.content, this.isActive);
        this.animationScroll()
        this.isActive++;
        this.activeSp = this.clearRenderMessage(this.isActive, render, this.content.length);
      }, timeRender);
    },
    renderMessage: (id, content = [], index) => {
      $(document).find(`#${id}`).show();
      $(document).find(`#${id} .inner`).append(`<div class="inner-content">${content[index]}</div><br>`);
    },
    clearRenderMessage(limit, item, index) {
      if (limit == index) {
        clearInterval(item);
        return false;
      }
      return true;
    },
    nextGame(isNoChoice = false) {
      const store = useGameStore()
      if (!this.isChooseAnswer && !isNoChoice) {
        alert('Hãy chọn câu trả lời bạn nhé!');
        return;
      }
      if (!this.game.is_done) {
        this.addChat(this.content, true)
      }
      let content = [this.contentChooseAnswer]

      if (this.isReview) {
        if (!isNoChoice) this.addChat(content, false);
        this.fnChangeGame();
      } else if (this.isChooseAnswer) {
        store.saveAnswer(this.saveChooseAnswer);
        setTimeout(() => {
          let checkGame = store.correctAnswer;
          if (checkGame.isCorrect) {
            store.logPoint(checkGame.point);
          }
          this.addChat(content, false);
          this.fnChangeGame();
        }, 200)
      } else if (isNoChoice) {
        this.fnChangeGame();
      }
    },
    makeID(length) {
      var result = '';
      var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
    },
    addChat(content, isBot = true) {
      const store = useGameStore()
      let data = {content, isBot};
      store.addChat(data);
    }
  },
  mounted() {
    const store = useGameStore()
    this.game = store.getGame;
    this.chat = store.getChat;
    this.account = store.getAccount;
    let content = JSON.parse(this.game.content);

    this.isReview = store.getIsReview;

    if (this.isReview) this.game.is_done = false;

    this.typeQuestion = content.check;
    this.answers = content.answers;
    this.sender = content.sender;
    this.url_image = this.checkUrlImage(this.sender);
    if (content.title) {
      this.content = content.title.split(",");
    }

    if (!this.game.is_done) {
      setTimeout(() => {
        this.showMessage();
      }, 500)
    }

    $(document).on("click", ".chat-answer", function () {
      $(document).find(".chat-answer").removeClass("active");
      $(this).addClass("active");
    });
  },
  computed: {
    backgroundImage() {
      return `background-image: url(${this.url_image}); box-shadow: 0px 0.8333333333333334vh 4.537037037037037vh 0px rgba(66, 183, 251, 0.58) ;`;
    },
  },
};
</script>
