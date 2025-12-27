export default {
    saveTask(state, task) {
        state.task = task;
        state.game = task.task_detail[0];
    },
    saveAccount(state, account) {
        state.account = account;
    },
    startGame(state) {
        state.isStart = true;
    },
    updateGame(state, game) {
        let key = state.key;
        state.game = game;
        state.task.task_detail[key] = game;
    },
    setIsReview(state) {
        state.isReview = true;
    },
    setIsWatched(state, value) {
        state.isWatched = [...state.isWatched, value];
    },
    setIsTraining(state) {
        state.isTraining = true;
    },

    changeGame(state, typeAction) {
        let key = state.key;

        if ([1, 2, 3, 4, 5, 6].includes(parseInt(state.game.type)) && typeAction === 'next') {
            state.task.task_detail[key].is_done = true;
        }
        if (typeAction === 'next') {
            state.backList = state.backList.filter((i) => i !== key);
            key += 1;
        } else {
            key -= 1;
            state.isReviewBack = true;
            state.backList = [...state.backList, key];
        }
        state.game = state.task.task_detail[key];
        state.key = key;
        state.isLoad = true;
    },
    changeLoading(state) {
        state.loading = !state.loading;
    },
    setLoad(state, value) {
        state.isLoad = value;
    },
    changeSound(state, props) {
        state[props.key] = localStorage.getItem(props.key) ?? 0.2;
    },

    saveAnswer(state, answer) {
        state.answer[state.game.id] = answer;
    },
    saveAllAnswer(state, answer) {
        state.answer = answer;
    },
    updateCoins(state, coin) {
        state.coins += parseInt(coin);
    },
    logPoint(state, point) {
        if (parseInt(point) === 0) return;

        state.coins += parseInt(point);
        state.isGetCoins = true;
        state.numCoins = parseInt(point);
        state.point[state.game.id] = point;

        setTimeout(() => {
            state.numCoins = 0;
            state.isGetCoins = false;
        }, 3000)
    },
    addCard(state, card) {
        let key = state.key;
        state.cards.push(card.card);
        state.task.task_detail[key].choose_card = card.index;

        setTimeout(() => {
            state.isGetCards = true;
        }, 3500)

        setTimeout(() => {
            state.isGetCards = false;
        }, 6500)
    },
    addChat(state, data) {
        state.chat.push(data);
    }
}
