import _ from "lodash";

export default (roomId) => ({
  roomId: roomId,
  users: {},
  init() {
    Echo.join(`rooms.${roomId}`)
        .here((users) => {
          _.forEach(users, (user) => {
            this.users[user.id] = user.username;
          })
        })
        .joining((user) => {
          this.users[user.id] = user.username;
        })
        .leaving((user) => {
          delete this.users[user.id];
        })
        .error((error) => {
          console.error(error);
        });
  },
});
