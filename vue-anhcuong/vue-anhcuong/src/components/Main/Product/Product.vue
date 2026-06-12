<template>
  <div class="product">
    <router-link :to="`/product-detail/${id}`" class="product-thumbnail">
      <img class="thumbnail" :src="thumbnailUrl || '/img/sanpham1.png'" :alt="title" />
    </router-link>
    <div class="description">
      <span class="product-name">{{ title }}</span>
      <span class="product-price">{{ vnd(price) }}</span>
      <div class="product-footer">
        <span class="stock-label" :class="hasStock ? 'in-stock' : 'out-stock'">{{ stockLabel }}</span>
        <button @click="addToCart" :disabled="!hasStock" class="add-btn">🛒</button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'ProductCard',
  props: {
    id: Number,
    title: String,
    thumbnailUrl: String,
    price: [String, Number],
    quanity: [String, Number]
  },
  computed: {
    hasStock() { return parseInt(this.quanity) > 0 },
    stockLabel() { return this.hasStock ? 'Sẵn hàng' : 'Hết hàng' }
  },
  methods: {
    ...mapActions(['addToCartAction']),
    async addToCart() {
      if (!this.hasStock) return
      await this.addToCartAction({ id: this.id })
    },
    vnd(price) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price)
    }
  }
}
</script>

<style scoped>
.product { display: flex; flex-direction: column; width: calc(25% - 1px); background: #fff; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc; }
.product:hover { box-shadow: 0 2px 12px rgba(0,0,0,0.1); }
.product-thumbnail { display: flex; align-items: center; justify-content: center; width: 85%; margin: 10px 7.5%; min-height: 160px; }
.thumbnail { max-width: 100%; max-height: 180px; object-fit: contain; }
.description { padding: 0 7.5% 10px; display: flex; flex-direction: column; gap: 4px; }
.product-name { font-size: 14px; color: #333; height: 38px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
.product-price { font-size: 15px; color: #D92037; font-weight: 700; text-align: right; }
.product-footer { display: flex; justify-content: space-between; align-items: center; }
.stock-label { font-size: 13px; font-weight: 600; }
.in-stock { color: #2e7d32; }
.out-stock { color: #c62828; }
.add-btn { background: none; border: none; font-size: 22px; cursor: pointer; }
.add-btn:disabled { opacity: 0.4; cursor: not-allowed; }
@media (max-width: 900px) { .product { width: calc(50% - 1px); } }
</style>