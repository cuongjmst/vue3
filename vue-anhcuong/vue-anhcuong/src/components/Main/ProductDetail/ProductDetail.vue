<template>
  <div class="detail">
    <div v-if="loading" class="loading">Đang tải sản phẩm...</div>
    <div v-else-if="!product" class="not-found">
      <p>Không tìm thấy sản phẩm!</p>
      <router-link to="/">← Về trang chủ</router-link>
    </div>
    <template v-else>
      <div class="product-overview">
        <div class="left-overview">
          <img :src="product.url || '/img/sanpham1.png'" :alt="product.title" class="main-picture" />
        </div>
        <div class="right-overview">
          <h4>{{ product.title }}</h4>
          <p>Thương hiệu: <strong>{{ product.brand }}</strong> | Mã SP: #{{ product.id }}</p>
          <p class="price-row">Giá: <span class="price-number">{{ productPrice }}</span></p>
          <div v-if="product.quanity > 0" class="action">
            <div class="change-amount">
              <button @click="changeQty(-1)">−</button>
              <input :value="qty" readonly />
              <button @click="changeQty(1)">+</button>
            </div>
            <button class="add-cart" @click="addToCart">THÊM GIỎ HÀNG</button>
          </div>
          <div v-else class="out-of-stock">⚠ Tạm hết hàng</div>
          <div class="promise">
            <p v-for="item in promises" :key="item">✓ {{ item }}</p>
          </div>
        </div>
      </div>
      <div v-if="product.description" class="product-description">
        <div class="desc-header"><h2>MÔ TẢ SẢN PHẨM</h2></div>
        <div class="desc-body" v-html="product.description"></div>
      </div>
    </template>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import database from '@/database/database'

export default {
  name: 'ProductDetail',
  data() {
    return {
      product: null,
      loading: true,
      qty: 1,
      promises: [
        'Hỗ trợ cài đặt qua Zalo Video, TeamView',
        'Ship nội thành Lạng Sơn miễn phí',
        'Ship COD toàn quốc 24h–72h',
        'Bảo hành chính hãng'
      ]
    }
  },
  computed: {
    productPrice() {
      if (!this.product) return ''
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(this.product.price)
    }
  },
  async created() {
    const id = this.$route.params.id
    const data = await database.getDetailProduct(id)
    this.product = data.currentProduct || null
    this.loading = false
  },
  methods: {
    ...mapActions(['addToCartAction']),
    changeQty(inc) {
      const next = this.qty + inc
      if (next < 1 || next > this.product.quanity) return
      this.qty = next
    },
    async addToCart() {
      if (!this.product) return
      await this.addToCartAction({ id: this.product.id })
    }
  }
}
</script>

<style scoped>
.detail { width: 100%; font-size: 15px; }
.loading, .not-found { padding: 40px; text-align: center; color: #888; }
.product-overview { display: flex; gap: 30px; }
.left-overview { width: 40%; }
.main-picture { width: 100%; max-height: 360px; object-fit: contain; }
.right-overview { flex: 1; }
.right-overview h4 { font-size: 18px; font-weight: 700; margin-bottom: 10px; }
.price-row { margin: 10px 0; }
.price-number { font-size: 22px; color: #EF233C; font-weight: 700; margin-left: 8px; }
.action { display: flex; align-items: center; gap: 10px; margin: 15px 0; }
.change-amount { display: flex; align-items: center; border: 1px solid #ccc; border-radius: 20px; overflow: hidden; }
.change-amount button { background: none; border: none; padding: 8px 14px; font-size: 18px; font-weight: 700; cursor: pointer; }
.change-amount input { width: 50px; text-align: center; border: none; border-left: 1px solid #ccc; border-right: 1px solid #ccc; padding: 8px 0; }
.add-cart { padding: 10px 20px; border-radius: 20px; border: none; background: #EF233C; color: #fff; font-weight: 600; cursor: pointer; }
.out-of-stock { background: #fff3cd; border: 1px solid #ffc107; color: #856404; padding: 10px; border-radius: 6px; margin: 15px 0; }
.promise { border: 1px solid #ddd; border-radius: 10px; padding: 12px; margin-top: 15px; font-size: 13px; line-height: 2; }
.desc-header { border-bottom: 3px solid #EF233C; margin: 20px 0 10px; }
.desc-header h2 { background: #EF233C; color: #fff; display: inline-block; padding: 8px 16px; font-size: 14px; }
.desc-body { font-size: 14px; line-height: 1.7; color: #444; }
</style>