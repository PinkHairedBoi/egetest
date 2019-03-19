<style>
.container .columns {
  margin: 1rem 1rem;
}
</style>

<template>
  <div>
    <loader :loading="inProgress"></loader>
    <div class="columns">
      <div class="column is-3">
        <router-link class="button is-primary is-alt is-large" :to="{name: 'qadd'}">Добавить</router-link>
      </div>
      <div class="column is-6 has-text-centered">
        <p class="subtitle is-3">Вопросы</p>
      </div>
      <div class="column is-3">
        <div>!ДЛЯ ПРОСМОТРА!</div>
        <b-dropdown v-model="test">
          <button class="button" type="button" slot="trigger">
            <span v-if="test">{{test.name}}</span>
            <span v-else>Выберите тест</span>
            <b-icon icon="caret-down"></b-icon>
          </button>
          <b-dropdown-item :value="{id: -1, name: 'Все тесты'}">Выбрать всё</b-dropdown-item>
          <b-dropdown-item v-for="test in tests" :key="test.id" :value="test">{{test.name}}</b-dropdown-item>
        </b-dropdown>
        <b-field>
          <b-input placeholder="Введите текст/ответ" v-model="search"></b-input>
        </b-field>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="box content">
          <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
              <tr>
                <th class="is-1">ID</th>
                <th class="is-4">Вопрос</th>
                <th class="is-1">Ответ</th>
                <th class="is-1">Картинки</th>
                <th class="is-1"></th>
              </tr>
            </thead>
            <tbody>
              <question
                v-for="question in filteredquestionlist"
                :key="question.id"
                :question="question"
                @loading="loading"
              ></question>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Question from "./Question";
import Loader from "../Loader";

export default {
  components: {
    Question,
    Loader
  },

  data() {
    return {
      inProgress: false,
      questionlist: [],
      test: null,
      tests: [],
      search: ""
    };
  },
  methods: {
    update() {
      this.test = null;
      this.inProgress = true;
      axios.get("/api/getTests").then(response => {
        this.tests = Object.values(response.data);
        this.inProgress = false;
      });
    },

    loading(e) {
      if (e == false) return this.update();
      this.inProgress = e;
    }
  },
  watch: {
    test: function() {
      if (!this.test) {
        this.questionlist = [];
        return;
      }
      this.inProgress = true;
      axios
        .post("/api/getQuestions", { test_id: this.test.id })
        .then(response => {
          this.questionlist = response.data;
          this.inProgress = false;
        });
    }
  },
  mounted() {
    this.update();
  },
  computed: {
    filteredquestionlist: function() {
      var finallist =
        this.search == ""
          ? this.questionlist
          : this.questionlist.filter(e => {
              return (
                e.question.toLowerCase().includes(this.search.toLowerCase()) ||
                e.answer.toLowerCase().includes(this.search.toLowerCase())
              );
            });
      if (this.test) {
        if (this.test.id == -1) finallist = finallist.slice(0, 60);
      }
      return finallist;
    }
  }
};
</script>