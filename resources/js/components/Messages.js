import _ from "lodash";
import axios from "axios";

export default (roomId) => ({
  messages: [],
  atBottom: false,
  init() {
    Echo.channel(`rooms.${roomId}`).listen('.message.created', (e) => {
      if (this.atBottom == true) {
        this.$nextTick(this.scrollToBottom);
      }
      this.pushMessage(e.message);
    }).subscribed(() => {
      this.getMessages().then(this.scrollToBottom);
    });
  },
  getMessages(oldestMessageId) {
    if (typeof oldestMessageId == 'undefined') {
      oldestMessageId = ''
    };
    return axios.get(`/messages/${roomId}/${oldestMessageId}`).then((res) => {
      _.forEach(res.data, (message) => {
        this.pushMessage(message);
      });
      this.messages = _.sortBy(this.messages, ['id'], ['asc']);
    });
  },
  pushMessage(message) {
    if (typeof _.find(this.messages, { id: message.id }) == 'undefined') {
      this.messages.push(message);
    };
  },
  scrollToBottom() {
    document.getElementById('bottom').scrollIntoView();
  },
});
