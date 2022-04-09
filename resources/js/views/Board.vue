<template>
  <main class="list-container">
    <Overlay />
    <Popup />
    <section class="list-wrapper">
        <div class="list-card" v-for="(list, index) in lists" :key="index">
          <div class="list-header">
            <div>
              {{ list.title }}
            </div>
            <div>
              <button @click="deleteList(list.id)">X</button>
            </div>
          </div>
          <div class="list-content">
            <CardsList :listId="list.id" :listTitle="list.title" />
          </div>
          <div class="list-footer">
            <Card :listId="list.id" />
          </div>
        </div>
      <input
        type="text"
        class="input-new-list"
        placeholder="Create a List"
        v-model="listTitle"
        @keyup.enter="createList"
      />
      <button class="dump_db_button" @click="downloadDB()">Export DB</button>
    </section>
  </main>
</template>

<script>

import CardsList from "../components/CardsList";
import Card from "../components/Card.vue";
import Overlay from "../components/Overlay";
import Popup from "../components/Popup";
import { nanoid } from 'nanoid'

export default {

  components: {
    CardsList,
    Card,
    Overlay,
    Popup,
  },

  data() {
    return {
      listTitle: "",
    };
  },

  methods: {

    createList() {
      if (this.listTitle !== "") {
        const payload = {
          'title' : this.listTitle,
          'uid' : nanoid()
        }
        this.$store.dispatch("createList", payload);
        this.listTitle = "";
      }

    },
    deleteList(id) {
      this.$store.dispatch("deleteList",id);
    },
    downloadDB(){
        this.$store.dispatch("downloadDB");
    },

  },

  computed: {

    lists() {
      return this.$store.getters["lists"];
    },

  },

};
</script>

<style>
.list-container {
  position: relative;
  display: flex;
  width: 100vw;
  height: 100vh;
  border: 1px;
  z-index: 10;
}

.list-wrapper {
  position: relative;
  display: flex;
  flex-direction: row;
  box-sizing: border-box;
  min-width: 100vw;
  height: 100vh;
  padding: 20px;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
  background-image: url('https://wallpaperaccess.com/full/51364.jpg');
  gap: 20px;
  overflow-x: scroll;
  overflow-y: hidden;
}
.dump_db_button{
    cursor:pointer;
    background-color:#c4e5b0;
    display:block;
    height: 10%;
    width: 8%;
    border-radius: 50%;
    border: 1px solid red;
    position: absolute;
    bottom: 10%;
    right: 11%;
    font-size: 18px;
}
.ghost {
  opacity: 0.5;
}

.list-draggable {
  display: flex;
  gap: 20px;
}

.input-new-list {
  display: flex;
  height: 30px;
  padding: 10px;
  border-radius: 5px;
  background-color: rgba(235, 236, 240, 0.5);
  min-width: 260px;
}

.input-new-list::placeholder {
  color: white;
}

.list-card {
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 300px;
  height: auto;
}

.list-header {
  position: relative;
  display: flex;
  justify-content: space-between;
  word-break: break-all;
  align-items: center;
  min-width: 280px;
  max-width: 280px;
  line-height: 50px;
  padding: 0px 20px 0px 20px;
  background-color: rgba(235, 236, 240, 1);
  border-radius: 10px 10px 0px 0px;
  color: rgba(24, 43, 77, 1);
  user-select: none;
}

.list-content {
  overflow-y: scroll;
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 280px;
  max-width: 280px;
  height: auto;
  background-color: rgba(235, 236, 240, 1);
  padding: 0px 10px 0px 10px;
  box-shadow: 1.5px 1.5px 1.5px 0.1px rgba(255, 255, 255, 0.1);
  color: rgba(24, 43, 77, 1);
}

.list-footer {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 280px;
  background-color: rgba(235, 236, 240, 1);
  border-radius: 0px 0px 10px 10px;
  color: white;
  border-top: 0.5px solid rgba(255, 255, 255, 0.25);
  padding: 0px 10px 10px 10px;
}
</style>
