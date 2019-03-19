<style scoped>
.is-vertical-center {
  display: flex;
  align-items: center;
  justify-content: center;
}

.images {
  margin-top: 10px;
  margin-left: 10px;
  height: 170px;
}

.img {
  display: inline-block;
  border: 1px solid black;
  height: 100%;
  margin: 0 5px;
  width: 168px;
  position: relative;
}

.btn {
  position: absolute;
  right: 5px;
  top: 5px;
}

.textarea {
  height: auto;
  max-height: fit-content;
  margin: 1em;
}
.textarea:not([rows])
{
  max-height: fit-content;
}

img {
  max-height: 400px;
}
</style>


<template>
  <div>
    <div class="columns">
      <div class="column is-3">
        <router-link class="button is-alt is-large" :to="{name: 'questions'}">Назад</router-link>
      </div>
      <div class="column is-6 is-vertical-center">
        <p class="subtitle is-3">Редактирование вопроса</p>
      </div>
      <div class="column is-3 has-text-right">
        <a class="button is-primary is-alt is-large" @click="editQ()">Применить</a>
      </div>
    </div>
    <div class="field">
      <b-dropdown v-model="question.test_id">
        <button class="button" type="button" slot="trigger">
          <span v-if="test">{{test.name}}</span>
          <span v-else>Выберите тест</span>
          <b-icon icon="caret-down"></b-icon>
        </button>
        <b-dropdown-item v-for="test in tests" :key="test.order" :value="test.id">{{test.name}}</b-dropdown-item>
      </b-dropdown>
    </div>
    <div class="field">
      <div class="subtitle">Вопрос:
        <span class="subtitle is-pulled-right button" @click="isView=!isView">Предпросмотр</span>
      </div>
      <div class="control">
        <textarea v-if="!isView" class="textarea" rows="7" v-model="question.question" autofocus></textarea>
        <div v-else class="textarea column is-narrow has-text-centered is-four-fifths">
          <div>
            <img v-for="img in question.images" :key="img.id" :src="img.src">
          </div>
          <div v-html="question.question"></div>
        </div>
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

          <div class="images">
            <div class="img" v-for="(file, index) in question.images" :key="index">
              <img :src="file.src" class="image">
              <button class="delete is-small btn" type="button" @click="deleteFile(file.id, index)"></button>
            </div>
          </div>
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
    <div class="field" style="margin-bottom: 20px;">
      <div class="subtitle">Правильный ответ:</div>
      <div class="control">
        <input
          class="input is-large"
          type="text"
          v-model="question.answer"
          placeholder="Ответ"
          autofocus
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isView: false,
      question: {
        question: "",
        answer: "",
        images: [],
        test_id: 0,
      },
      tests: [],
      images: []
    };
  },
  methods: {
    editQ() {
      if (
        !this.question.test_id ||
        !this.question.answer ||
        !this.question.question
      )
        return;

      let data = new FormData();
      data.append("question", this.question.question);
      data.append("answer", this.question.answer);
      data.append("test_id", this.question.test_id);
      this.images.forEach(img => {
        data.append("images[]", img);
      });

      data.append("_method", "PATCH");

      axios
        .post("/api/questions/" + this.question.id, data, {
          headers: { "content-type": "multipart/form-data" }
        })
        .then(response => {
          this.$router.push({ name: "questions" });
        })
        .catch(e => {
          alert(e.response.data.error);
        });
    },
    deleteDropFile(index) {
      this.images.splice(index, 1);
    },
    deleteFile(id, index) {
      axios.get("/api/images/" + id).then(response => {
        this.question.images.splice(index, 1);
      });
    }
  },
  mounted() {
    axios.get("/api/questions/" + this.$route.params.id).then(response => {
      this.question = response.data;
    });
    axios.get("/api/getTests").then(response => {
      this.tests = Object.values(response.data);
    });
  },
  computed: {
    test: function() {
      return this.tests.find(el => {
        return el.id == this.question.test_id;
      });
    }
  },
  watch: {
    "question.question": function() {
      this.question.question = this.question.question.replace(
        /(?:\r\n|\r|\n)/g,
        "<br />"
      );
    }
  }
};
</script>