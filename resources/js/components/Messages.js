import _ from "lodash";
import axios from "axios";

export default (roomId) => ({
  messages: [],
  atBottom: false,
  loadingMessages: true,
  init() {
    Echo.channel(`rooms.${roomId}`).listen('.message.created', (e) => {
      if (this.atBottom == true) {
        this.$nextTick(this.scrollToBottom);
      }
      if (typeof _.find(this.messages, { id: e.message.id }) == 'undefined') {
        this.messages.unshift(e.message);
      };
    }).subscribed(() => {
      this.getMessages().then(this.scrollToBottom);
    });
  },
  getMessages(oldestMessageId) {
    this.loadingMessages = true;
    if (typeof oldestMessageId == 'undefined') {
      oldestMessageId = ''
    };
    return axios.get(`/messages/${roomId}/${oldestMessageId}`).then((res) => {
      _.forEach(res.data, (message) => {
        if (typeof _.find(this.messages, { id: message.id }) == 'undefined') {
          this.messages.push(message);
        };
      });
      this.messages = _.sortBy(this.messages, ['id']).reverse();
      this.loadingMessages = false;
    });
  },
  getMoreMessages() {
    if (this.loadingMessages || this.messages.length == 0) return;
    this.getMessages(this.messages[this.messages.length - 1].id);
  },
  scrollToBottom() {
    document.getElementById('bottom').scrollIntoView();
  },
});
