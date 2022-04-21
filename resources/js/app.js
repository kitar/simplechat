require('./bootstrap');

import Trix from 'trix'
import Alpine from 'alpinejs'
import messages from './components/Messages'
import messageInput from './components/MessageInput'

Alpine.data('messages', messages);
Alpine.data('messageInput', messageInput);
Alpine.start();
