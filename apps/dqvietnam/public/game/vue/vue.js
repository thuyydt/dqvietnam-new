import {createApp} from 'vue';
import { createPinia } from 'pinia'

import Play from './Play.vue';
import Replay from './Replay.vue';
import Training from './Training.vue';

const pinia = createPinia()

if (document.querySelector('#play-game')) {
    const play = createApp(Play);
    play.use(pinia)
    play.mount('#play-game');
}

if (document.querySelector('#replay-game')) {
    const replay = createApp(Replay);
    replay.use(pinia)
    replay.mount('#replay-game');
}

if (document.querySelector('#training-game')) {
    const training = createApp(Training);
    training.use(pinia)
    training.mount('#training-game');
}