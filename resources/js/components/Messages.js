import _ from "lodash";
import axios from "axios";

export default (userUuid, sessionId, roomId) => ({
  userUuid: userUuid,
  sessionId: sessionId,
  roomId: roomId,
  messages: [],
  atBottom: false,
  loadingMessages: true,
  deletingMessage: null,
  init() {
    Echo.private(`rooms.${roomId}`).listen('.message.created', (e) => {
      if (this.atBottom == true) {
        this.$nextTick(this.scrollToBottom);
      }
      if (typeof _.find(this.messages, { id: e.message.id }) == 'undefined') {
        this.messages.unshift(e.message);
      };
    }).listen('.message.deleted', (e) => {
      this.messages = _.remove(this.messages, (item) => {
        return e.message.id != item.id;
      });
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
  canDeleteMessage(message) {
    return sessionId == message.owner_session_id || userUuid == message.created_by;
  },
  deleteMessage(messageId, confirmed) {
    this.deletingMessage = messageId;
    if (confirmed) {
      axios.delete(`/messages/${roomId}/${messageId}`);
      this.deletingMessage = null;
    }
  }
});
