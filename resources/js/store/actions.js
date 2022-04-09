import axios from "axios";


export default {

    fetchAllData(context) {

      axios.get('api/list-cards/list?access_token=$2a$12$YymtY78e6WNLVfK0AloPReeYKOnc0X1eo1bkyXKUjnAcg0xElQslW&status=1')
      .then(response => {

        context.commit("setListCardData",response.data.data);

          axios.get('api/cards/list?access_token=$2a$12$YymtY78e6WNLVfK0AloPReeYKOnc0X1eo1bkyXKUjnAcg0xElQslW&status=1')
          .then(response => {
            context.commit("setCardData",response.data.data);
          }).catch(error => {
            console.log(error)
          })

      }).catch(error => {
        console.log(error)
      })

    },

    createList(context, payload) {

      context.commit("createNewList",payload);
      axios.post('api/list-card/create?access_token=$2a$12$YymtY78e6WNLVfK0AloPReeYKOnc0X1eo1bkyXKUjnAcg0xElQslW',{
        'title' : payload.title
      }).then(response => {
        if(response.status == 200) {
          context.state.lists.forEach(list => {
            if(payload.uid == list.id){
              list.id = response.data.data.id
            }
          })
        }else{
          console.log('Changes not saved')
        }
      })
      .catch(error => {
        console.log(error)
      })

    },

    createCard(context, payload) {

      context.commit("createNewCard",payload);

      axios.post('api/card/create?access_token=$2a$12$YymtY78e6WNLVfK0AloPReeYKOnc0X1eo1bkyXKUjnAcg0xElQslW',{
        'title' : payload.title,
        'list_card_id' : payload.listId
      })
      .then(response => {
        if(response.status == 200) {
          context.state.cards.forEach(card => {
            if(payload.uid == card.id){
              card.id = response.data.data.id
            }
          })
        }else{
          console.log('Changes not saved')
        }
      }).catch(error => {
        console.log(error)
      })

    },

    toggleOverlay(context) {
      context.commit("toggleOverlay");
    },

    openForm(context, payload) {
      context.commit("openForm", payload);
    },

    saveCard(context, payload) {

      context.commit("saveCard",payload);

      axios.post('api/card/update?access_token=$2a$12$YymtY78e6WNLVfK0AloPReeYKOnc0X1eo1bkyXKUjnAcg0xElQslW',{
        'title' : payload.title,
        'list_card_id' : payload.list_card_id,
        'description' : payload.description,
        'card_id' : payload.id
      })
      .then(response => {
        if(response.status == 200) {
          console.log('Changes saved')
        }else{
          console.log('Changes not saved')
        }
      }).catch(error => {
        console.log(error)
      })

    },

    deleteCard(context, payload) {

      context.commit("deleteCard",payload.id);

      axios.get('api/card/'+payload.id+'/delete?access_token=$2a$12$YymtY78e6WNLVfK0AloPReeYKOnc0X1eo1bkyXKUjnAcg0xElQslW')
      .then(response => {
        if(response.status == 200) {
          console.log('Changes saved')
        }else{
          console.log('Changes not saved')
        }
      }).catch(error => {
        console.log(error)
      })

    },

    deleteList(context, payload) {

      context.commit("deleteList",payload);

      axios.get('api/list-card/'+payload+'/delete?access_token=$2a$12$YymtY78e6WNLVfK0AloPReeYKOnc0X1eo1bkyXKUjnAcg0xElQslW')
      .then(response => {
        if(response.status == 200) {
          console.log('Changes saved')
        }else{
          console.log('Changes not saved')
        }
      }).catch(error => {
        console.log(error)
      })

    },

    changeCardOrder(context,payload) {

      axios.post('api/card/order/change?access_token=$2a$12$YymtY78e6WNLVfK0AloPReeYKOnc0X1eo1bkyXKUjnAcg0xElQslW',{
        'arrayOfCards' : payload
      })
      .catch(error => {
        console.log(error)
      })

    },
    downloadDB(context, payload) {
        axios({
            url: 'api/dump?access_token=$2a$12$YymtY78e6WNLVfK0AloPReeYKOnc0X1eo1bkyXKUjnAcg0xElQslW',
            method: 'GET',
            responseType: 'blob',
        }).then((response) => {
             var fileURL = window.URL.createObjectURL(new Blob([response.data]));
             var fileLink = document.createElement('a');
             fileLink.href = fileURL;
             fileLink.setAttribute('download', 'dump.sql');
             document.body.appendChild(fileLink);
             fileLink.click();
        }).catch(error => {
          console.log(error)
        });
      },

};
