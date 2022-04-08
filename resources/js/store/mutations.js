export default {

    setListCardData(state, payload) {
      state.lists = payload
    },

    setCardData(state, payload) {
      state.cards = payload
    },

    createNewList(state, payload) {
      const list = {
        id: payload.uid,
        title: payload.title,
      };
      state.lists.push(list);
    },

    createNewCard(state, payload) {
      const card = {
        list_card_id: payload.listId,
        id: payload.uid,
        title: payload.title,
        description: null,
      };
      state.cards.push(card);
      console.log(state.cards)
    },

    toggleOverlay(state) {
      state.overlay = !state.overlay;
    },


    openForm(state, payload) {
      state.currentData = payload;
    },

    saveCard(state, payload) {
      state.cards = state.cards.map((card) => {
        if (card.id === payload.id) {
          return Object.assign(card, payload);
        }
        return card;
      });
      state.cards.sort(( a, b )  => {
        if ( a.order < b.order ){
          return -1;
        }
        if ( a.order > b.order ){
          return 1;
        }
        return 0;
      } );
    },

    deleteCard(state, payload) {
      const indexToDelete = state.cards
        .map((card) => card.id)
        .indexOf(payload);
      state.cards.splice(indexToDelete, 1);
    },

    deleteList(state, payload) {
      const indexToDelete = state.lists
        .map((list) => list.id)
        .indexOf(payload);
      state.lists.splice(indexToDelete, 1);
      const newCards = state.cards.filter((card,index) => {
        if(card.list_card_id == payload) {
          return false
        }else {
          return true
        }
      })
      state.cards = newCards
    },

  };