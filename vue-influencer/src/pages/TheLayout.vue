<template>

<the-nav :user="user"></the-nav>

<main role="main">
  <router-view></router-view>
</main>

</template>

<script>
import TheNav from '../components/TheNav';
import axios from 'axios';
import {User} from '../classes/user';

export default {
    name: "TheLayout",
    components: {
        TheNav
    },
    date() {
      return {
        user: null
      }
    },
    async mounted() {
      if (localStorage.getItem('token')) {
        
        const {data} = await axios.get('user');

        this.user = new User(data.data);

        this.$store.dispatch('setUser', this.user);
      }
    }
}
</script>

<style scoped>
</style>