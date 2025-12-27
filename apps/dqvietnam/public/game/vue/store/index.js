import actions from "./action";
import getters from "./getters";
import mutations from "./mutations";

const state = () => ({
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
})

export default {
    state,
    actions,
    getters,
    mutations
}
