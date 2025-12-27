<template>
    <div class="page-wrapper">
        <div class="page-container">

            <div class="game-03__content">
                <div class="wrapper strokeme">
                    Tìm các từ ẩn giấu trong ô<br>chữ bằng cách "nhấn" vào<br>ô chữ cần tìm.

                    <div class="info">
                        <p v-for="(item, index) in question" :key="index">{{index+1}}. {{ item.trim() }}</p>
                    </div>

                </div>
            </div>

            <div class="game-03" :data-status="checkAnswer()">
                <div class="game-wrapper">
                    <template v-for="(row, iRow) in crossword">
                        <div v-for="(col, iCol) in row" :class="classCell(col, iRow, iCol)"
                             :id="'cell_' + iRow + '_' + iCol" @click="chooseCell($event, iRow, iCol)">
                            <span> {{ col.char }} </span>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import { useGameStore } from '../store/game'

    export default {
        name: 'Crossword',
        props: ['checkAns'],
        data() {
            return {
                base_url: base_url,
                image: '',
                video: '',
                crossword: [],
                question: [],
                game: {},
                answers: {}
            }
        },
        methods: {
            classCell(cell, iRow, iCol) {
                if (this.game.is_done) {

                    if (cell.isRight) return 'item is-right'

                    if (typeof this.answers[`cell_${iRow}_${iCol}`] !== "undefined") {
                        return 'item active';
                    }

                    return 'item';
                }

                if (this.checkAns == 3) {
                    return cell.isRight ? 'item is-right' : 'item';
                } else if (this.checkAns) {
                    return cell.isRight ? 'item exactly-char' : 'item';
                }

                return 'item';
            },

            checkAnswer() {
                const store = useGameStore()
                if (this.checkAns == 1) {
                    store.saveAnswer(this.answers);
                }
                return this.checkAns;
            },

            chooseCell(event, iRow, iCol) {
                playAudio(this.base_url + 'public/guide/audio/click.mp3');

                if (this.game.is_done) return;

                let id = `cell_${iRow}_${iCol}`;
                if (typeof this.answers[id] === "undefined") {
                    this.answers[id] = true;
                } else {
                    delete this.answers[id];
                }

                let block = event.target;
                if (event.target.localName === 'span') {
                    block = event.target.parentNode;
                }

                block.classList.toggle('active');
            },

            getChar(char) {
                return char.toUpperCase();
            },

            getRandomChar() {
                let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
                return chars[Math.floor(Math.random() * chars.length)];
            }
        },
        mounted() {
            const store = useGameStore()
            this.game = store.getGame;
            this.answers = store.getAnswerOnGameCurrent;
            let content = JSON.parse(this.game.content);
            let question = content.title;
            this.question = question.length ? question.split(',') : [];

            let crossword = content.crossword;
            let rowCrossword = [];

            if (typeof this.game.crossword === "undefined") {
                crossword.map((row, iRow) => {
                    row.map((col, iCol) => {
                        if (iCol === 0 && iRow > 0) {
                            this.crossword.push(rowCrossword);
                            rowCrossword = [];
                        }

                        let char = col.length ? this.getChar(col) : this.getRandomChar();
                        let isRight = !!col.length;

                        rowCrossword.push({char, isRight});
                    })
                });

                this.game.crossword = this.crossword;
                store.updateGame(this.game);
            } else {
                this.crossword = this.game.crossword;
            }
        }
    };
</script>