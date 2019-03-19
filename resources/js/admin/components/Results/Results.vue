<style>
.container .columns {
  margin: 1rem 1rem;
}
table .is-scrollable {
  overflow-y: scroll;
  width: auto;
  position: absolute;
  height: 200px;
}
</style>

<template>
  <div>
    <loader :loading="inProgress"></loader>
    <div class="columns">
      <div class="column is-3">
        <p class="subtitle is-3">Результаты</p>
      </div>
      <div class="column is-9 has-text-centered">
        <b-dropdown v-model="test">
          <button class="button" type="button" slot="trigger">
            <span v-if="test">{{test.name}}</span>
            <span v-else>Выберите тест</span>
            <b-icon icon="caret-down"></b-icon>
          </button>
          <b-dropdown-item :value="null">Не выбрано</b-dropdown-item>
          <b-dropdown-item v-for="test in orderedTests" :key="test.id" :value="test">{{test.name}}</b-dropdown-item>
        </b-dropdown>
        <b-dropdown v-model="question">
          <button class="button" type="button" slot="trigger">
            <span v-if="question">{{question.id}}</span>
            <span v-else>Выберите вопрос</span>
            <b-icon icon="caret-down"></b-icon>
          </button>
          <b-dropdown-item :value="null">Не выбрано</b-dropdown-item>
          <b-dropdown-item
            v-for="question in questionlist"
            :key="question.id"
            :value="question"
          >Вопрос {{question.id}} Тест {{question.test_id}}</b-dropdown-item>
        </b-dropdown>
        <b-dropdown v-model="user">
          <button class="button" type="button" slot="trigger">
            <span v-if="user">{{user.name}}</span>
            <span v-else>Выберите ученика</span>
            <b-icon icon="caret-down"></b-icon>
          </button>
          <b-dropdown-item :value="null">Не выбрано</b-dropdown-item>
          <b-dropdown-item v-for="user in users" :key="user.id" :value="user">{{user.name}}</b-dropdown-item>
        </b-dropdown>
        <b-dropdown v-model="attempt">
          <button class="button" type="button" slot="trigger">
            <span v-if="attempt">{{attempt+1}}</span>
            <span v-else>Выберите попытку</span>
            <b-icon icon="caret-down"></b-icon>
          </button>
          <b-dropdown-item :value="null">Не выбрано</b-dropdown-item>
          <b-dropdown-item v-for="attempt in attempts" :key="attempt" :value="attempt+1">{{attempt+1}}</b-dropdown-item>
        </b-dropdown>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="box content">
          <table class="table is-striped is-hoverable is-fullwidth is-scrollable">
            <thead>
              <tr>
                <th class="is-2">Ученик</th>
                <th class="is-2">
                  <abbr title="Когда был дан ответ">Время</abbr>
                </th>
                <th class="is-2">Попытка</th>
                <th class="is-8">Вопрос</th>
                <th class="is-2">Ответ</th>
              </tr>
            </thead>
            <tbody>
              <result v-for="answer in answers" :key="answer.id" :answer="answer"/>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Result from "./Result";
import Loader from "../Loader";
export default {
  components: {
    Result,
    Loader
  },

  data() {
    return {
      inProgress: false,

      tests: [],
      questionlist: [],
      users: [],
      attempts: [],

      answers: [],

      test: null,
      question: null,
      user: null,
      attempt: null
    };
  },
  methods: {
    update() {
      this.inProgress = true;
      axios.get("/api/getTests").then(response => {
        this.tests = Object.values(response.data);
        axios.get("/api/getUsers").then(response => {
          this.users = response.data;
          this.inProgress = false;
          this.getAnswers();
        });
      });
    },
    getAnswers() {
      this.inProgress = true;
      let data = new FormData();
      if(this.test) data.append("test_id", this.test.id);
      if(this.question) data.append("question_id", this.question.id);
      if(this.user) data.append("user_id", this.user.id);
      if(this.attempt) data.append("attempt", this.attempt);
      axios.post("/api/getAnswers", data).then(response => {
        this.answers = response.data;
        this.inProgress = false;
      });
    },
    getAttempts() {
      if (!this.user || !this.test) {
        this.getAnswers();
        return;
      }
      this.inProgress = true;
      axios
        .post("/api/getAttempts", {
          user_id: this.user.id,
          test_id: this.test.id
        })
        .then(response => {
          this.attempts = Array.from(Array(response.data || 0), (x, index) => index);
          this.inProgress = false;
          this.getAnswers();
        });
    }
  },
  mounted() {
    this.update();
  },
  watch: {
    test: function() {
      if (!this.test) {
        this.questionlist = [];
        this.attempts = [];
        this.getAnswers();
        return;
      }
      this.inProgress = true;
      axios
        .post("/api/getRawQuestions", { test_id: this.test.id })
        .then(response => {
          this.questionlist = response.data;
          this.inProgress = false;
          this.getAttempts();
        });
    },

    user: function() {
      if (!this.user) {
        this.attempts = [];
        this.getAnswers();
        return;
      }
      this.getAttempts();
    },

    question: function() {
      this.getAnswers();
    },

    attempt: function() {
      this.getAnswers();
    }
  },
  computed: {
    orderedTests: function() {
      return this.tests.sort((a, b) => a.order - b.order);
    }
  }
};
</script>