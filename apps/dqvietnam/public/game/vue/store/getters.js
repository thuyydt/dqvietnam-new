export default {
    getTask(state) {
        return state.task
    },
    getGame(state) {
        return state.game
    },
    getChat(state) {
        return state.chat
    },
    getLoading(state) {
        return state.isLoad;
    },
    getSound(state) {
        return state.sound = localStorage.getItem('sound')
    },
    getVolume(state) {
        return state.volume = localStorage.getItem('volume')
    },
    getAccount(state) {
        return state.account
    },
    getIsReview(state) {
        return state.isReview
    },
    getIsReviewBack(state) {
        return state.isReviewBack
    },
    getBackList(state) {
        return state.backList
    },
    getPrevGame(state) {
        if (!state.key) return {type: -1}
        let key = state.key - 1;
        return state.task.task_detail[key];
    },
    getCoins(state) {
        return state.coins
    },
    getAnswerOnGameCurrent(state) {
        if (typeof state.answer[state.game.id] !== "undefined") {
            return state.answer[state.game.id];
        }
        return {};
    },

    correctAnswer(state) {
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

            if (state.isReviewBack && state.isWatched.include(`video_${state.game.id}`)) {
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
            // Object.keys(question).map((key) => {
            //     let status = typeof answer.find(e => e == key) !== "undefined";
            //     let pointAnswer = parseInt(question[key].point || 0);
            //
            //     if (status && !question[key].is_right) error = true;
            //     if (!status && question[key].is_right) error = true;
            //
            //     if (question[key].is_right) pointPlus += pointAnswer;
            //
            //     if (status && pointAnswer < 0) pointMinus += pointAnswer;
            // });
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
}
