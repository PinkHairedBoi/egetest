<template>
  <section class="is-success is-fullheight">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <h3 class="title has-text-grey">Авторизация</h3>
          <p class="subtitle has-text-grey">Система тестирования Биотест.</p>
          <div class="box">
            <form method="POST" action="auth" @submit.prevent="login">
              <input type="hidden" name="_token" :value="csrf">
              <div class="field">
                <div class="control">
                  <input
                    class="input is-large"
                    type="text"
                    v-model="name"
                    placeholder="Имя"
                    autofocus
                  >
                </div>
              </div>
              <div class="field">
                <div class="control">
                  <input
                    class="input is-large"
                    type="password"
                    v-model="password"
                    placeholder="Пароль"
                  >
                </div>
              </div>
              <button class="button is-block is-info is-large is-fullwidth">Войти</button>
              <ul v-if="errors && errors.length">
                <li v-for="(text, key) in errors[0]" :key="key">{{text[0]}}</li>
              </ul>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      name: "",
      password: "",
      errors: [],
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },
  methods: {
    login() {
      axios
        .post(`api/login`, { name: this.name, password: this.password })
        .then(response => {
          this.errors = [];
          this.errors.push(response.data);
          window.location = response.data.redirect;
        })
        .catch(e => {
          this.errors = [];
          this.errors.push(e.response.data.errors);
        });
    }
  }
};
</script>