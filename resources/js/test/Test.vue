<template>
  <div>
    <navigation :user="user"/>
    <question />
  </div>
</template>

<script>
import Navigation from "./components/Navigation";
import Question from "./components/Question";
export default {
  components: { Navigation, Question },
  data() {
    return {
      isOpen: false,
      user: {}
    };
  },
  mounted() {
    axios.get("/api/user").then(response => {
      this.user = response.data;
    });
  }
};
</script>
