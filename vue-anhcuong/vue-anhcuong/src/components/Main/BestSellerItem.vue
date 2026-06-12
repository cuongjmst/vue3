<template>
  <div class="best-seller-item">
    <div class="product-thumbnail">
      <img :src="thumbnailUrl" :alt="title" class="thumbnail" />
    </div>
    <div class="item-description">
      <span class="product-name">{{ title }}</span>
      <span class="product-price">{{ price }}</span>
      <span class="product-status" :class="status === 'Sẵn hàng' ? 'in-stock' : 'out-stock'">
        {{ status }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BestSellerItem',
  props: {
    title: { type: String, required: true },
    thumbnailUrl: { type: String, required: true },
    price: { type: String, required: true },
    status: { type: String, default: 'Sẵn hàng' }
  }
}
</script>

<style scoped>
.best-seller-item { display: flex; flex-direction: row; padding: 8px 0; border-bottom: 1px solid #eee; gap: 8px; }
.product-thumbnail { width: 70px; flex-shrink: 0; }
.thumbnail { width: 100%; height: 60px; object-fit: contain; }
.item-description { flex: 1; display: flex; flex-direction: column; gap: 3px; }
.product-name { font-size: 13px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: #333; }
.product-price { font-size: 13px; color: #D92037; font-weight: 600; }
.product-status { font-size: 12px; font-weight: 500; }
.in-stock { color: #2e7d32; }
.out-stock { color: #c62828; }
</style>