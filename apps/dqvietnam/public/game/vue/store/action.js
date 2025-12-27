import axios from 'axios'

export default {
    async saveState({commit}, props) {
        localStorage.setItem(props.key, props.value);
        commit('changeSound', props);
    },
    async setIsWatched({commit}, props) {
        commit('setIsWatched', props);
    },
    async loadTask({commit}) {
        const secret = getCookie('account_secret');
        const data = [];
        const headers = {
            token: secret
        };
       // commit('setLoad', true);
        await axios
            .post(base_url + 'api/tasks/getTasks', data, {headers})
            .then((response) => {

                if (response.data.code == 404) {
                    window.location.href = base_url + 'hocbai?status=error';
                }

                commit('saveTask', response.data.data);
                commit('changeLoading');
                commit('setLoad', false);
                commit('updateCoins', response.data.points);
                commit('saveAccount', response.data.account);
            })
    },

    async reviewTask({commit}) {
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

                commit('saveTask', task);
                commit('saveAllAnswer', answer);
                commit('changeLoading');
                commit('updateCoins', response.data.points);
                commit('saveAccount', response.data.account);
                commit('setIsReview');
            })
    },

    async trainingTask({commit}) {
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

                commit('saveTask', response.data.data);
                commit('changeLoading');
                commit('updateCoins', response.data.points);
                commit('saveAccount', response.data.account);
                commit('setIsTraining');
            })
    },


    // async logPoint({commit, state}, point = 0) {
    //     if (!point) return false;
    //
    //     const secret = getCookie('account_secret');
    //     const data = {
    //         task_detail : state.game.id,
    //         point: point
    //     };
    //     const headers = {
    //         token : secret
    //     };
    //     await axios
    //         .post(base_url + 'api/point/log_point', data, {headers})
    //         .then((response) => {
    //             if (typeof response.data.point !== "undefined") {
    //                 commit('updateCoins', response.data.point);
    //             }
    //         })
    // },

    async doneTasks({commit, state}) {
        const secret = getCookie('account_secret');
        const data = {
            task_id: state.task.id,
            points: state.point,
            cards: state.cards,
            task: state.task,
            answers: state.answer,
            chat: state.chat,
        };
        const headers = {
            token: secret
        };
        commit('setLoad', true);
        await axios
            .post(base_url + 'api/tasks/saveTaskDone', data, {headers})
            .then((response) => {
                commit('setLoad', false);
                window.location.href = base_url + 'hocbai';
            })
    }
}
