import axios from "axios";

export default (roomId) => ({
  init() {
    this.$refs.trix.addEventListener('keydown', (event) => {
      if (event.key == 'Enter') {
        if (! event.isComposing && ! event.shiftKey) {
          event.preventDefault();
          this.post(this.$refs.trix.value);
          this.$refs.trix.value = '';
        }
      }
    });
  },
  post(value) {
    if (value.length == 0) return;
    axios.post('/messages', {
      room_id: roomId,
      message: value
    });
  }
});
