<template>
  <input
    class="input-card"
    type="text"
    placeholder="Create a Card"
    v-model="cardTitle"
    @keyup.enter="createCard"
  />
</template>

<script>
import { nanoid } from 'nanoid';

export default {
  props: ["listId"],

  data() {
    return {
      cardTitle : '',
    };
  },

  methods: {
    createCard() {
      if (this.cardTitle !== "") {
        const card = {
          listId: this.listId,
          title: this.cardTitle,
          uid: nanoid(),
        };
        this.$store.dispatch("createCard", card);
        this.cardTitle = "";
      }
    },
  },
};
</script>

<style>
.input-card {
  position: relative;
  background-color: white;
  min-height: 30px;
  width: 100%;
  display: flex;
  align-items: center;
  border-radius: 5px;
  padding: 10px;
  word-break: break-all;
  font-size: 16px;
}
</style>