<style scoped>
.is-vertical-center {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>


<template>
  <div>
    <div class="columns">
      <div class="column is-3">
        <router-link class="button is-alt is-large" :to="{name: 'tests'}">Назад</router-link>
      </div>
      <div class="column is-6 is-vertical-center">
        <p class="subtitle is-3">Редактирование теста {{test.name}}:</p>
      </div>
      <div class="column is-3 has-text-right">
        <a class="button is-primary is-alt is-large" @click="editTest()">Применить</a>
      </div>
    </div>
    <div class="field">
      <label class="label is-large">Название</label>
      <div class="control">
        <input class="input is-large" type="text" v-model="test.name">
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="field">
          <label class="label is-large">Порядок</label>
          <div class="control">
            <input
              class="input is-large"
              type="number"
              v-model="test.order"
              min="1"
              :max="tests.length"
            >
          </div>
        </div>
      </div>
      <div class="column" v-if="changetest != test.name">
        <div class="field">
          <label class="label is-large">Поменяется местами с {{changetest}}</label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tests: [],
      test: {
        name: "",
        order: 0,
        id: 0
      }
    };
  },
  methods: {
    editTest() {
      axios
        .patch("/api/tests/" + this.test.id, this.test)
        .then(response => {
          this.$router.push({ name: "tests" });
        })
        .catch(e => {
          alert(e.response.data.error);
        });
    }
  },
  mounted() {
    axios.get("/api/tests/" + this.$route.params.id).then(response => {
      this.test = response.data;
    });
    axios.get("/api/tests").then(response => {
      this.tests = response.data;
    });
  },
  computed: {
    changetest: function() {
      let test = this.tests.filter(test => test.order == this.test.order);
      return test.length ? test[0].name : null;
    }
  }
};
</script>