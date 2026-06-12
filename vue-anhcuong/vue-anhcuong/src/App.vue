<template>
  <div class="app-wrapper">
    <AppHeader />
    <div class="main-content">
      <AppMain />
    </div>
  </div>
</template>

<script>
import AppHeader from './components/Header/Header.vue'
import AppMain from './components/Main/Main.vue'

export default {
  name: 'App',
  components: {
    AppHeader,
    AppMain
  }
}
</script>

<style>
.app-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  background-color: #f5f5f5;
}

.main-content {
  width: 100%;
  max-width: 1200px;
  margin-top: 20px;
  padding: 0 10px;
}
</style>