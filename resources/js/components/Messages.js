import _ from "lodash";
import axios from "axios";
import moment from 'moment';

export default (roomId) => ({
  messages: [],
  init() {
    Echo.channel(`rooms.${roomId}`).listen('.message.created', (e) => {
      this.pushMessage(e.message);
    }).subscribed(() => {
      this.getMessages();
    });
  },
  getMessages(oldestMessageId) {
    if (typeof oldestMessageId == 'undefined') {
      oldestMessageId = ''
    };
    axios.get(`/messages/${roomId}/${oldestMessageId}`).then((res) => {
      _.forEach(res.data, (message) => {
        this.pushMessage(message);
      });
      this.messages = _.sortBy(this.messages, ['id'], ['asc']);
    });
  },
  pushMessage(message) {
    if (typeof _.find(this.messages, { id: message.id }) == 'undefined') {
      message.created_at = moment(message.created_at).format('YYYY-MM-DD HH:mm');
      message.updated_at = moment(message.updated_at).format('YYYY-MM-DD HH:mm');
      this.messages.push(message);
    };
  },
});
