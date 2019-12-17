<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand">Participants list</a>
      </div>
    </nav>
    <div class="container mt-3">
      <div>
        <div v-if="people.length > 0">
          <h2>The people already signed in:</h2>
          <participants-list :list="people"></participants-list>
        </div>
        <em v-else>Sorry, nobody is here :-(</em>
      </div>
      <div class="row">
        <div class="col-md-6 offset-md-3 mt-3">
          <div class="card">
            <h4 class="card-header">Add new participant</h4>
            <new-participant-form class="card-body" @added="addNewParticipant($event)"></new-participant-form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import ParticipantsList from "./ParticipantsList.vue";
  import NewParticipantForm from "./NewParticipantForm.vue";

  export default {
    components: {ParticipantsList, NewParticipantForm},
    data() {
      return {
        people: []
      };
    },
    mounted() {
      this.$http.get('participants').then(response => {
        this.people = response.body;
      });
    },
    methods: {
      addNewParticipant(participant) {
        this.people.push(participant);
      }
    }
  };
</script>
