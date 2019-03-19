<style scoped>
.textarea {
  height: auto;
  max-height: fit-content;
  margin: 1em;
}
.textarea:not([rows])
{
  max-height: fit-content;
}
input {
  margin: 1em 0;
}
.inside {
  margin-top: 1em;
}
.pbody p,
.solution p {
  margin: 0;
  text-indent: 0;
}
.left_margin,
.pbody .left_margin,
.solution .left_margin,
.probtext .left_margin {
  margin: 0;
  text-indent: 25px;
}
.pbody table,
.solution table {
  text-indent: 0;
}
.pbody th,
.pbody td,
.solution td,
.solution th {
  border: 1px solid black;
  border-collapse: collapse;
  padding: 4px;
}
.pbody th,
.solution th {
  background: #dedede;
  color: #000000;
}
.pbody table,
.solution table {
  border-collapse: collapse;
}
.pbody .no_border th,
.pbody .no_border td {
  border: 0px;
  border-collapse: collapse;
  padding: 4px;
}
td {
  border: 1px solid grey;
  padding: 5px 10px;
}
img {
  max-height: 400px;
}
</style>

<template>
  <div class="columns is-mobile is-vcentered is-centered">
    <loader :loading="isLoading"/>
    <div class="column is-narrow has-text-centered is-four-fifths">
      <div v-if="finished">Все тесты пройдены. Ты молодец!</div>
      <div class="inside" v-else-if="is_answered">
        <a
          v-if="test_passed"
          @click="next()"
          class="button block"
          :class="{'is-success': test_correct, 'is-danger': !test_correct}"
        >{{test_correct ? 'Тест успешно пройден!' : 'Не удалось пройти тест.'}}</a>
        <a
          v-else
          @click="next()"
          class="button block"
          :class="{'is-success': is_answer_right, 'is-danger': !is_answer_right}"
        >{{is_answer_right ? 'Верно!' : "Не верно."}}</a>
      </div>
      <div v-else>
        <h1 class="inside">Вопрос {{qnum}} из {{qtotal}}</h1>

        <div class="textarea">
          <div>
            <img v-for="img in question.images" :key="img.id" :src="img.src">
          </div>
          <div v-html="question.question"></div>
        </div>
        <input
          class="input is-rounded has-text-centered"
          type="text"
          v-model="user_answer"
          placeholder="Введите ответ"
        >
        <a @click="answer()" class="button is-success block">Ответить</a>
      </div>
    </div>
  </div>
</template>

<script>
import Loader from "./Loader";
export default {
  components: {
    Loader
  },
  data() {
    return {
      question: {
        images: []
      },
      qnum: 0,
      qtotal: 0,
      user_answer: "",
      is_answer_right: false,
      is_answered: false,
      test_passed: false,
      test_correct: false,
      isLoading: false,
      finished: false
    };
  },
  methods: {
    get() {
      this.isLoading = true;
      axios.get("/api/get").then(response => {
        if (typeof response.data.finished !== "undefined") {
          this.finished = true;
          this.is_answered = true;
        } else if (typeof response.data.passed !== "undefined") {
          this.is_answered = true;
          this.test_passed = true;
          this.test_correct = response.data.passed;
        } else {
          this.question = response.data.q;
          this.qnum = response.data.qnum;
          this.qtotal = response.data.qtotal;
          this.user_answer = "";
        }
        this.isLoading = false;
      });
    },

    answer() {
      this.isLoading = true;
      let finalanswer = this.user_answer.toLowerCase().replace(/ё/g, "е");
      axios.post("/api/answer", { answer: finalanswer }).then(response => {
        this.is_answered = true;
        this.is_answer_right = response.data;
        this.isLoading = false;
      });
    },

    next() {
      this.is_answered = false;
      this.test_passed = false;
      this.get();
    }
  },
  mounted() {
    this.next();
  }
};
</script>
