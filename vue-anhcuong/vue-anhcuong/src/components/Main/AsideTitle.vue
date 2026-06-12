<template>
  <div class="aside-title"><span>{{ title }}</span></div>
</template>

<script>
export default {
  name: 'AsideTitle',
  props: { title: { type: String, required: true } }
}
</script>

<style scoped>
.aside-title { background-color: #D92037; padding: 10px 12px; margin-bottom: 8px; }
.aside-title span { color: #fff; font-size: 15px; font-weight: 700; }
</style>