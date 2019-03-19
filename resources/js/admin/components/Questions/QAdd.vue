<template>
  <div>
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Создать вопрос</p>
          <router-link tag="button" class="delete" aria-label="close" :to="{name:'questions'}"></router-link>
        </header>
        <section class="modal-card-body">
          <div class="field">
            !!!!!!!!!!
            <b-dropdown v-model="test">
              <button class="button" type="button" slot="trigger">
                <span v-if="test">{{test.name}}</span>
                <span v-else>Выберите тест</span>
                <b-icon icon="caret-down"></b-icon>
              </button>
              <b-dropdown-item v-for="test in tests" :key="test.order" :value="test">{{test.name}}</b-dropdown-item>
            </b-dropdown>
            !!!!!!!!!!
          </div>
          <div class="field">
            <div class="subtitle">Вопрос:</div>
            <div class="control">
              <textarea class="textarea" rows="7" v-model="question" placeholder="Текст" autofocus></textarea>
            </div>
          </div>
          <div class="field">
            <section>
              <b-field>
                <b-upload v-model="images" multiple drag-drop>
                  <section class="section">
                    <div class="content has-text-centered">
                      <p>
                        <b-icon icon="upload" size="is-large"></b-icon>
                      </p>
                      <p>Перенесите или выберите картинки</p>
                    </div>
                  </section>
                </b-upload>
              </b-field>

              <div class="tags">
                <span v-for="(file, index) in images" :key="index" class="tag is-primary">
                  {{file.name}}
                  <button
                    class="delete is-small"
                    type="button"
                    @click="deleteDropFile(index)"
                  ></button>
                </span>
              </div>
            </section>
          </div>
          <div class="field">
            <div class="subtitle">Правильный ответ (если варианты вводить от меньшего к большему):</div>
            <div class="control">
              <input
                class="input is-large"
                type="text"
                v-model="answer"
                placeholder="Ответ"
                autofocus
              >
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" @click="createQ()">Создать</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dropdown: false,

      question: "",
      answer: "",
      images: [],
      test: null,

      tests: []
    };
  },
  methods: {
    back() {
      this.$router.push({
        name: "questions"
      });
    },
    createQ() {
      if (!this.test_id || !this.answer || !this.question) return;

      let data = new FormData();
      data.append("question", this.question);
      data.append("answer", this.answer);
      data.append("test_id", this.test_id);
      this.images.forEach(img => {
        data.append("images[]", img);
      });

      axios
        .post("/api/questions", data, {
          headers: { "content-type": "multipart/form-data" }
        })
        .then(response => {
          this.back();
        });
    },
    chooseTest(t) {
      this.test = t;
      this.dropdown = false;
    },
    deleteDropFile(index) {
      this.images.splice(index, 1);
    }
  },
  mounted() {
    axios.get("/api/getTests").then(response => {
      this.tests = Object.values(response.data);
    });
  },
  computed: {
    test_id: function() {
      return this.test ? this.test.id : null;
    }
  },
  watch: {
    question: function()
    {
      this.question = this.question.replace(/(?:\r\n|\r|\n)/g, '<br />');
    }
  }
};
</script>