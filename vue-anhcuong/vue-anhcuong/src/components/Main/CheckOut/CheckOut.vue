<template>
  <div class="check-out">
    <div class="checkout-header">
      <h2>THANH TOÁN</h2>
    </div>

    <div v-if="!cartProducts" class="empty-checkout">
      <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
      <router-link to="/">← Về trang chủ</router-link>
    </div>

    <form v-else @submit.prevent="handleSubmit" class="checkout-form">
      <div class="form-layout">
        <div class="form-left">
          <div class="form-section">
            <div class="section-title">THÔNG TIN MUA HÀNG</div>
            <div class="form-field">
              <label>Họ và tên <span class="required">*</span></label>
              <input v-model="form.customer_name" type="text" placeholder="Nhập họ và tên" :class="{ 'input-error': errors.customer_name }" />
              <span v-if="errors.customer_name" class="error-msg">{{ errors.customer_name }}</span>
            </div>
            <div class="form-field">
              <label>Địa chỉ <span class="required">*</span></label>
              <input v-model="form.customer_address" type="text" placeholder="Địa chỉ giao hàng" :class="{ 'input-error': errors.customer_address }" />
              <span v-if="errors.customer_address" class="error-msg">{{ errors.customer_address }}</span>
            </div>
            <div class="form-field">
              <label>Số điện thoại <span class="required">*</span></label>
              <input v-model="form.customer_phone" type="tel" placeholder="Số điện thoại" :class="{ 'input-error': errors.customer_phone }" />
              <span v-if="errors.customer_phone" class="error-msg">{{ errors.customer_phone }}</span>
            </div>
            <div class="form-field">
              <label>Email</label>
              <input v-model="form.customer_email" type="email" placeholder="email@example.com" />
            </div>
          </div>

          <div class="form-section">
            <div class="section-title">PHƯƠNG THỨC THANH TOÁN</div>
            <label class="radio-label">
              <input type="radio" v-model="form.payment_method" value="cod" /> Thanh toán khi nhận hàng (COD)
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.payment_method" value="banking" /> Chuyển khoản ngân hàng
            </label>
            <div v-if="form.payment_method === 'banking'" class="banking-info">
              <p>MB Bank - Nguyễn Văn Lâm - 5150 168 9999 68</p>
            </div>
          </div>

          <div class="form-section">
            <div class="section-title">GHI CHÚ</div>
            <textarea v-model="form.order_note" rows="3" placeholder="Ghi chú đơn hàng..." class="order-note"></textarea>
          </div>
        </div>

        <div class="form-right">
          <div class="form-section">
            <div class="section-title">ĐƠN HÀNG CỦA BẠN</div>
            <table class="order-table">
              <thead>
                <tr><th>Sản phẩm</th><th>SL</th><th>Tiền</th></tr>
              </thead>
              <tbody>
                <tr v-for="p in cartProducts" :key="p.id">
                  <td>{{ p.title }}</td>
                  <td style="text-align:center">{{ p.countInCart }}</td>
                  <td style="text-align:right;color:#D92037;font-weight:600">{{ vnd(p.checkOutSumary) }}</td>
                </tr>
              </tbody>
            </table>
            <div class="order-total">
              <div class="total-line final-line">
                <span>Thành tiền:</span>
                <span class="final-price">{{ vnd(totalPrice) }}</span>
              </div>
            </div>
            <button type="submit" class="submit-btn">ĐẶT HÀNG NGAY</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'CheckOut',
  data() {
    return {
      form: { customer_name: '', customer_address: '', customer_phone: '', customer_email: '', payment_method: 'cod', order_note: '' },
      errors: {}
    }
  },
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
    ...mapActions(['removeProductAction']),
    validate() {
      const e = {}
      if (!this.form.customer_name.trim()) e.customer_name = 'Vui lòng nhập họ tên.'
      if (!this.form.customer_address.trim()) e.customer_address = 'Vui lòng nhập địa chỉ.'
      if (!this.form.customer_phone.trim()) e.customer_phone = 'Vui lòng nhập số điện thoại.'
      else if (!/^[0-9]{9,11}$/.test(this.form.customer_phone.replace(/\s/g, ''))) e.customer_phone = 'Số điện thoại không hợp lệ.'
      this.errors = e
      return Object.keys(e).length === 0
    },
    async handleSubmit() {
      if (!this.validate()) return
      alert(`🎉 Đặt hàng thành công!\nThành tiền: ${this.vnd(this.totalPrice)}\nCảm ơn bạn đã mua hàng!`)
      const products = [...this.cart.productList]
      for (const p of products) await this.removeProductAction({ id: p.id })
      this.$router.push('/')
    },
    vnd(price) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price)
    }
  }
}
</script>

<style scoped>
.check-out { width: 100%; font-size: 15px; }
.checkout-header { border-bottom: 3px solid #EF233C; margin-bottom: 20px; }
.checkout-header h2 { background: #EF233C; color: #fff; display: inline-block; padding: 8px 16px; font-size: 15px; font-weight: 600; }
.empty-checkout { text-align: center; padding: 40px; color: #666; }
.form-layout { display: flex; gap: 20px; }
.form-left { flex: 1.2; display: flex; flex-direction: column; gap: 16px; }
.form-right { flex: 0.8; }
.form-section { border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
.section-title { background: #f5f5f5; border-bottom: 1px solid #e0e0e0; padding: 10px 16px; font-size: 13px; font-weight: 700; }
.form-field { display: flex; flex-direction: column; gap: 4px; padding: 10px 16px; border-bottom: 1px solid #f0f0f0; }
.form-field label { font-size: 13px; color: #555; font-weight: 500; }
.required { color: #EF233C; }
.form-field input { height: 38px; border: 1px solid #ccc; border-radius: 6px; padding: 0 12px; font-size: 14px; }
.form-field input:focus { border-color: #EF233C; outline: none; }
.input-error { border-color: #EF233C !important; }
.error-msg { color: #EF233C; font-size: 12px; }
.radio-label { display: flex; align-items: center; gap: 8px; padding: 10px 16px; font-size: 13px; cursor: pointer; }
.banking-info { background: #f9f9f9; margin: 0 16px 10px; padding: 10px; border-radius: 6px; font-size: 13px; }
.order-note { width: 100%; border: none; resize: vertical; padding: 10px 16px; font-size: 13px; outline: none; }
.order-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.order-table th { background: #f9f9f9; padding: 8px 10px; font-weight: 600; border-bottom: 1px solid #eee; }
.order-table td { padding: 8px 10px; border-bottom: 1px solid #f5f5f5; }
.order-total { padding: 12px 16px; }
.total-line { display: flex; justify-content: space-between; font-size: 13px; }
.final-line { font-weight: 700; padding-top: 8px; border-top: 1px solid #eee; }
.final-price { color: #EF233C; font-size: 16px; }
.submit-btn { display: block; width: calc(100% - 32px); margin: 12px 16px 16px; padding: 14px; background: #EF233C; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; }
.submit-btn:hover { opacity: 0.88; }
@media (max-width: 768px) { .form-layout { flex-direction: column; } }
</style>