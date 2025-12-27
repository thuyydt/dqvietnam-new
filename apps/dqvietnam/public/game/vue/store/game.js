import { defineStore } from 'pinia'
import axios from 'axios'

export const useGameStore = defineStore('game', {
  state: () => ({
    isStart: true,
    isReview: false,
    isTraining: false,
    isReviewBack: false,
    backList: [],
    isLoad: false,
    videoWatched: [],
    task: {},
    game: {},
    account: {},
    key: 0,
    currentKey: 0,
    loading: true,
    answer: {},
    coins: 0,
    point: {},
    isGetCoins: false,
    isGetCards: false,
    isSetting: true,
    sound: 0,
    volume: 0,
    numCoins: 0,
    cards: [],
    chat: [],
    isWatched: []
  }),
  getters: {
    getTask: (state) => state.task,
    getGame: (state) => state.game,
    getChat: (state) => state.chat,
    getLoading: (state) => state.isLoad,
    getSound: (state) => state.sound = localStorage.getItem('sound'),
    getVolume: (state) => state.volume = localStorage.getItem('volume'),
    getAccount: (state) => state.account,
    getIsReview: (state) => state.isReview,
    getIsReviewBack: (state) => state.isReviewBack,
    getBackList: (state) => state.backList,
    getPrevGame: (state) => {
        if (!state.key) return {type: -1}
        let key = state.key - 1;
        return state.task.task_detail[key];
    },
    getCoins: (state) => state.coins,
    getAnswerOnGameCurrent: (state) => {
        if (typeof state.answer[state.game.id] !== "undefined") {
            return state.answer[state.game.id];
        }
        return {};
    },
    correctAnswer: (state) => {
        let answer = state.answer[state.game.id];
        let type = parseInt(state.game.type);
        let point = 0;
        
        let data = {
            point: point,
            isCorrect: false,
            hideEffect: false
        };

        // Check slide
        if (type === 0) {
            point = parseInt(state.game?.point || 0);
            if (!point) return data;

            if (state.isReviewBack && state.isWatched.includes(`video_${state.game.id}`)) {
                return data;
            }
            data.isCorrect = 'right';
            data.point = point;

            return data;
        }

        // check game question
        if (type === 1) {
            if (answer === null) return data;
            const content = JSON.parse(state.game.content);
            let question = content.answers;

            const hideEffect = content.hide_effect;

            let error = false;
            let pointPlus = 0;
            let pointMinus = 0;
            
            const optionRight = question[answer];
            let pointAnswer = parseInt(optionRight?.point || 0);
            if (hideEffect) {
                pointPlus += pointAnswer;
            } else {
                if (optionRight && optionRight.is_right) {
                    if (optionRight.is_right) pointPlus += pointAnswer;
                } else {
                    error = true;
                    pointMinus += pointAnswer;
                }
            }

            data.isCorrect = error ? 'wrong' : 'right';
            data.point = error ? pointMinus : pointPlus;

            if (data.point < 0) {
                data.isCorrect = 'wrong'
            }

            return {...data, hideEffect};
        }

        //check game fill
        if (type === 2) {
            data.isCorrect = 'wrong';
            if (typeof answer === "undefined") return data;
            if (!Object.keys(answer).length) return data;

            let chars = JSON.parse(state.game.content).chars;
            let error = false;

            chars.map((e, key) => {
                if (e.is_fill) {
                    if (typeof answer[key] === "undefined") {
                        error = true;
                    } else if (e.char.toUpperCase() !== answer[key]) {
                        error = true;
                    }
                }
            })

            data.isCorrect = error ? 'wrong' : 'right';
            data.point = error ? 0 : parseInt(state.game?.point || 0);
            return data;
        }

        //check game crossword
        if (type === 3) {
            if (!Object.keys(answer).length) return data;

            let crossword = state.game.crossword;
            let error = false;
            let point = parseInt(state.game.point);
            let pointResult = 0;

            Object.keys(answer).map(function (key, index) {
                let row = key.split('_').at(1);
                let col = key.split('_').at(2);

                if (!crossword[row][col].isRight) {
                    error = true;
                } else {
                    pointResult += point;
                }
            });

            data.isCorrect = error ? 'wrong' : 'right';
            data.point = error ? 0 : pointResult;
            return data;
        }

        //check game image
        if (type === 4) {
            if (typeof answer === "undefined") return data;

            if (answer) {
                data.isCorrect = 'right';
                data.point = parseInt(state.game?.point || 0);
            }

            return data;
        }

        //check game card
        if (type === 5) {
            let cards = JSON.parse(state.game.content).cards;
            point = parseInt(cards[answer]?.point || 0);
            if (!point) return data;
            data.isCorrect = 'right';
            data.point = point;

            return data;
        }

        //check chat
        if (type === 6) {
            let is_check = JSON.parse(state.game.content).check;
            if (!is_check) {
                let answers = JSON.parse(state.game.content).answers;

                point = parseInt(answers[answer]?.point || 0);

                data.isCorrect = 'right';
                data.point = point;

                if (data.point < 0) {
                    data.isCorrect = 'wrong'
                }
                return data;
            }
        }
    }
  },
  actions: {
    saveTask(task) {
        this.task = task;
        this.game = task.task_detail[0];
    },
    saveAccount(account) {
        this.account = account;
    },
    startGame() {
        this.isStart = true;
    },
    updateGame(game) {
        let key = this.key;
        this.game = game;
        this.task.task_detail[key] = game;
    },
    setIsReview() {
        this.isReview = true;
    },
    setIsWatched(value) {
        this.isWatched = [...this.isWatched, value];
    },
    setIsTraining() {
        this.isTraining = true;
    },
    changeGame(typeAction) {
        let key = this.key;

        if ([1, 2, 3, 4, 5, 6].includes(parseInt(this.game.type)) && typeAction === 'next') {
            this.task.task_detail[key].is_done = true;
        }
        if (typeAction === 'next') {
            this.backList = this.backList.filter((i) => i !== key);
            key += 1;
        } else {
            key -= 1;
            this.isReviewBack = true;
            this.backList = [...this.backList, key];
        }
        this.game = this.task.task_detail[key];
        this.key = key;
        this.isLoad = true;
    },
    changeLoading() {
        this.loading = !this.loading;
    },
    setLoad(value) {
        this.isLoad = value;
    },
    changeSound(props) {
        this[props.key] = localStorage.getItem(props.key) ?? 0.2;
    },
    saveAnswer(answer) {
        this.answer[this.game.id] = answer;
    },
    saveAllAnswer(answer) {
        this.answer = answer;
    },
    updateCoins(coin) {
        this.coins += parseInt(coin);
    },
    logPoint(point) {
        if (parseInt(point) === 0) return;

        this.coins += parseInt(point);
        this.isGetCoins = true;
        this.numCoins = parseInt(point);
        this.point[this.game.id] = point;

        setTimeout(() => {
            this.numCoins = 0;
            this.isGetCoins = false;
        }, 3000)
    },
    addCard(card) {
        let key = this.key;
        this.cards.push(card.card);
        this.task.task_detail[key].choose_card = card.index;

        setTimeout(() => {
            this.isGetCards = true;
        }, 3500)

        setTimeout(() => {
            this.isGetCards = false;
        }, 6500)
    },
    addChat(data) {
        this.chat.push(data);
    },
    
    // Async Actions
    async saveStateAction(props) {
        localStorage.setItem(props.key, props.value);
        this.changeSound(props);
    },
    async loadTaskAction() {
        const secret = getCookie('account_secret');
        const data = [];
        const headers = {
            token: secret
        };
        await axios
            .post(base_url + 'api/tasks/getTasks', data, {headers})
            .then((response) => {

                if (response.data.code == 404) {
                    window.location.href = base_url + 'hocbai?status=error';
                }

                this.saveTask(response.data.data);
                this.changeLoading();
                this.setLoad(false);
                this.updateCoins(response.data.points);
                this.saveAccount(response.data.account);
            })
    },
    async reviewTaskAction() {
        const token = getCookie('account_secret');
        const key = getCookie('dq_review_game');
        const data = {key};
        const headers = {token};

        await axios
            .post(base_url + 'api/tasks/reviewTask', data, {headers})
            .then((response) => {
                if (response.data.code == 404) {
                    window.location.href = base_url + 'hocbai?status=error';
                }

                let answer = JSON.parse(response.data.data.answer);
                let task = JSON.parse(response.data.data.task);

                this.saveTask(task);
                this.saveAllAnswer(answer);
                this.changeLoading();
                this.updateCoins(response.data.points);
                this.saveAccount(response.data.account);
                this.setIsReview();
            })
    },
    async trainingTaskAction() {
        const token = getCookie('account_secret');
        const key = getCookie('dq_review_game');
        const data = {key};
        const headers = {token};

        await axios
            .post(base_url + 'api/tasks/trainingTask', data, {headers})
            .then((response) => {
                if (response.data.code == 404) {
                    window.location.href = base_url + 'hocbai?status=error';
                }

                console.log(response.data)

                this.saveTask(response.data.data);
                this.changeLoading();
                this.updateCoins(response.data.points);
                this.saveAccount(response.data.account);
                this.setIsTraining();
            })
    },
    async doneTasksAction() {
        const secret = getCookie('account_secret');
        const data = {
            task_id: this.task.id,
            points: this.point,
            cards: this.cards,
            task: this.task,
            answers: this.answer,
            chat: this.chat,
        };
        const headers = {
            token: secret
        };
        this.setLoad(true);
        await axios
            .post(base_url + 'api/tasks/saveTaskDone', data, {headers})
            .then((response) => {
                this.setLoad(false);
                window.location.href = base_url + 'hocbai';
            })
    }
  }
})
