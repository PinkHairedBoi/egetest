<style scoped>
.container .columns {
  margin: 1rem 1rem;
}
</style>

<template>
  <div>
    <loader :loading="inProgress"></loader>
    <div class="columns">
      <div class="column is-3">
        <router-link class="button is-primary is-alt is-large" :to="{name: 'useradd'}">Создать</router-link>
      </div>
      <div class="column is-6 has-text-centered">
        <p class="subtitle is-3">Пользователи</p>
      </div>
      <div class="column is-3"></div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="box content">
          <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
              <tr>
                <th class="is-8">Логин</th>
                <th class="is-8">Пароль</th>
                <th class="is-2">Тест</th>
                <th class="is-1"></th>
              </tr>
            </thead>
            <tbody>
              <user
                v-for="user in users"
                :key="user.id"
                :user="user"
                :tests="tests"
                @loading="loading"
              ></user>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import User from "./User";
import Loader from "../Loader";

export default {
  components: {
    Loader,
    User
  },

  data() {
    return {
      inProgress: false,
      users: [],
      tests: []
    };
  },
  methods: {
    update() {
      this.inProgress = true;
      axios.get("/api/users").then(response => {
        this.users = response.data;
        axios.get("/api/getTests").then(response => {
          this.tests = Object.values(response.data);
          this.inProgress = false;
        });
      });
    },

    loading(e) {
      if (e == false) return this.update();
      this.inProgress = e;
    }
  },
  created() {
    this.update();
  }
};
</script>