<template>
  <draggable :list="cards"  group="cardsGroup" ghostClass="ghost" @change="onChange(listId)">
    <span
      class="element-card"
      v-for="(card, index) in cards"
      :key="index"
      @click="togglePopup(card)"
      :data-id = card.id
    >
      {{ card.title }}
    </span>
  </draggable>
</template>

<script>
import VueDraggable from 'vuedraggable';

export default {
  
  props: ["listId", "listTitle"],
  components: {
    draggable: VueDraggable,
  },
  
  data(){
    return {
      cards : [],
    }
  },

  beforeCreate() {
    this.$store.watch((state) => {
      return state.cards
    }, (newValue, oldValue) => {
      this.cards = newValue.filter((card) => {
        if (card.list_card_id === this.listId) {
          return true;
        } else {
          return false;
        }
      });
    })

  },

  methods: {
    
    togglePopup(data) {
      const currentData = {
        listId: this.listId,
        listTitle: this.listTitle,
        id: data.id,
        title: data.title,
        description: data.description,
      };
      this.$store.dispatch("toggleOverlay");
      this.$store.dispatch("openForm", currentData);
    },

    onChange(listId) {
      this.cards.map((card, index) => {
          card.order = index + 1;
          card.list_card_id = listId;
      });
      this.$store.dispatch('changeCardOrder',this.cards)
    }

  },
  computed: {
    overlayIsActive() {
      return this.$store.getters["overlay"];
    },
  },
};
</script>

<style>
.element-card {
  position: relative;
  background-color: white;
  height: auto;
  display: flex;
  align-items: center;
  padding: 10px;
  border-radius: 5px;
  min-height: 30px;
  margin-bottom: 10px;
  word-break: break-all;
  text-align: left;
}
</style>
