require('./bootstrap');

import Trix from 'trix'
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import messages from './components/Messages'
import messageInput from './components/MessageInput'

Alpine.plugin(intersect)
Alpine.data('messages', messages);
Alpine.data('messageInput', messageInput);
Alpine.start();

let updateScreenContainer = () => {
  let element = document.getElementById('screen-container');
  if (element) {
    element.style.height = window.innerHeight + 'px';
  }
}

window.addEventListener('resize', _.debounce(() => {
  updateScreenContainer();
}, 300));

updateScreenContainer();
