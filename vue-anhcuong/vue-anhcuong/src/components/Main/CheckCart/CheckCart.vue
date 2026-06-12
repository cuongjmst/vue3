<template>
  <div class="check-cart">
    <div class="checkcart-header">
      <h2>GIỎ HÀNG</h2>
    </div>

    <div v-if="!cartProducts" class="empty-cart">
      <p>🛒 Chưa có sản phẩm nào trong giỏ hàng!</p>
      <router-link to="/">
        <button class="home-button">QUAY LẠI TRANG CHỦ</button>
      </router-link>
    </div>

    <div v-else class="cart-content">
      <table class="cart-table">
        <thead>
          <tr>
            <td></td>
            <td></td>
            <td>Sản phẩm</td>
            <td>Giá</td>
            <td>Số lượng</td>
            <td>Tổng</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="p in cartProducts" :key="p.id">
            <td>
              <button class="remove-btn" @click="removeProduct(p.id)">×</button>
            </td>
            <td>
              <img :src="p.url || '/img/sanpham1.png'" :alt="p.title" class="cart-thumb" />
            </td>
            <td>{{ p.title }}</td>
            <td>{{ vnd(p.price) }}</td>
            <td>
              <div class="qty-controls">
                <button @click="changeAmount(p.id, -1)" class="qty-btn">−</button>
                <input :value="p.countInCart" readonly class="qty-input" />
                <button @click="changeAmount(p.id, 1)" class="qty-btn">+</button>
              </div>
            </td>
            <td>{{ vnd(p.checkOutSumary) }}</td>
          </tr>
        </tbody>
      </table>

      <div class="cart-summary">
        <div class="summary-row">
          <span>Thành tiền:</span>
          <span class="highlight">{{ vnd(totalPrice) }}</span>
        </div>
        <router-link to="/check-cart/check-out" class="checkout-btn">
          TIẾN HÀNH THANH TOÁN
        </router-link>
        <router-link to="/" class="continue-btn">← Tiếp tục mua hàng</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'CheckCart',
  computed: {
    ...mapState(['cart']),
    cartProducts() {
      return this.cart.productList.length > 0 ? this.cart.productList : null
    },
    totalPrice() {
      return this.cart.productList.reduce((sum, p) => sum + parseInt(p.checkOutSumary || 0), 0)
    }
  },
  methods: {
    ...mapActions(['removeProductAction', 'changeAmountProductsAction']),
    removeProduct(id) {
      if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
        this.removeProductAction({ id })
      }
    },
    changeAmount(id, increase) {
      this.changeAmountProductsAction({ id, increase })
    },
    vnd(price) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price)
    }
  }
}
</script>

<style scoped>
.check-cart { width: 100%; font-size: 15px; }
.checkcart-header { border-bottom: 3px solid #EF233C; margin-bottom: 20px; }
.checkcart-header h2 { background: #EF233C; color: #fff; display: inline-block; padding: 8px 16px; font-size: 15px; font-weight: 600; }
.empty-cart { text-align: center; padding: 50px; }
.home-button { margin-top: 16px; padding: 12px 24px; background: #EF233C; color: #fff; border: none; border-radius: 20px; cursor: pointer; font-size: 14px; font-weight: 600; }
.cart-table { width: 100%; border-collapse: collapse; border: 1px solid #ddd; font-size: 14px; }
.cart-table td { padding: 10px 8px; border-bottom: 1px solid #eee; vertical-align: middle; text-align: center; }
.cart-table thead td { background: #f9f9f9; font-weight: 600; border-bottom: 2px solid #EF233C; }
.remove-btn { background: none; border: none; font-size: 20px; color: #EF233C; cursor: pointer; padding: 2px 8px; border-radius: 50%; }
.remove-btn:hover { background: #EF233C; color: #fff; }
.cart-thumb { max-width: 70px; max-height: 60px; object-fit: contain; }
.qty-controls { display: flex; align-items: center; justify-content: center; }
.qty-btn { width: 28px; height: 28px; border: 1px solid #ccc; background: #fff; font-size: 16px; font-weight: 700; cursor: pointer; }
.qty-btn:hover { background: #EF233C; color: #fff; border-color: #EF233C; }
.qty-input { width: 40px; height: 28px; text-align: center; border: 1px solid #ccc; border-left: none; border-right: none; }
.cart-summary { margin-top: 20px; float: right; width: 40%; display: flex; flex-direction: column; gap: 10px; padding: 16px; border: 1px solid #eee; border-radius: 8px; }
.summary-row { display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; }
.highlight { color: #EF233C; font-size: 16px; }
.checkout-btn { display: block; text-align: center; background: #EF233C; color: #fff; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 14px; text-decoration: none; }
.checkout-btn:hover { opacity: 0.85; }
.continue-btn { display: block; text-align: center; color: #555; font-size: 13px; text-decoration: none; }
.continue-btn:hover { color: #EF233C; }
</style>