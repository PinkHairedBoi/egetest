<template>
  <div>
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Добавление пользователя</p>
          <router-link tag="button" class="delete" aria-label="close" :to="{name:'users'}"></router-link>
        </header>
        <section class="modal-card-body">
          <div class="field">
            <div class="subtitle">Имя пользователя:</div>
            <div class="control">
              <input class="input is-large" type="text" v-model="name" placeholder="Alexander_Shmoylov" autofocus>
            </div>
          </div>
          <div class="subtitle">!Пароль будет аналогичен имени!</div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" @click="createUser()">Добавить</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: ''
    };
  },
  methods: {
    back() {
      this.$router.push({
        name: "users"
      });
    },
    createUser() {
      axios.post("/api/users", { name: this.name }).then(response => {
        this.back();
      });
    }
  }
};
</script>