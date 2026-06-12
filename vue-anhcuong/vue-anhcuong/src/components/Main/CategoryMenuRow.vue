<template>
  <div class="category-row">
    <a href="#">
      <span class="category-name">{{ title }}</span>
      <span class="arrow">›</span>
    </a>
  </div>
</template>

<script>
export default {
  name: 'CategoryMenuRow',
  props: {
    title: { type: String, required: true }
  }
}
</script>

<style scoped>
.category-row { border-bottom: 1px solid #e0e0e0; }
.category-row a { display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; color: #333; font-size: 14px; text-decoration: none; }
.category-row a:hover { background-color: #fef2f3; color: #D92037; }
.arrow { color: #aaa; }
</style>