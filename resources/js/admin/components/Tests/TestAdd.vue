<template>
  <div>
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Создать тест</p>
          <router-link tag="button" class="delete" aria-label="close" :to="{name:'tests'}"></router-link>
        </header>
        <section class="modal-card-body">
          <div class="field">
            <div class="subtitle">Название:</div>
            <div class="control">
              <input class="input is-large" type="text" v-model="name" placeholder="Имя" autofocus>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" @click="createTest()">Создать</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: "Вопрос X"
    };
  },
  methods: {
    back() {
      this.$router.push({
        name: "tests"
      });
    },
    createTest() {
      axios.post("/api/tests", { name: this.name }).then(response => {
        this.$emit("loading", false);
        this.back();
      });
    }
  }
};
</script>