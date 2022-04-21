import _ from "lodash";
import axios from "axios";
import moment from 'moment';

export default (roomId) => ({
  messages: [],
  init() {
    this.getMessages();
  },
  getMessages(messageId) {
    if (messageId == undefined) {
      messageId = ''
    };
    axios.get(`/messages/${roomId}/${messageId}`).then((res) => {
      _.forEach(res.data, (item) => {
        if (_.find(this.messages, { id: item.id }) != undefined) return;
        item.created_at = moment(item.created_at).format('YYYY-MM-DD HH:mm');
        item.updated_at = moment(item.updated_at).format('YYYY-MM-DD HH:mm');
        this.messages.unshift(item);
      });
      this.messages = _.sortBy(this.messages, ['id'], ['asc']);
    });
  }
});
