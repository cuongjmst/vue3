<template>
  <header class="header">
    <div class="top-header">
      <router-link to="/" class="logo">
        <img src="/img/header-logo.png" alt="Logo" />
      </router-link>
      <div class="search-bar">
        <div class="search-form">
          <input type="text" v-model="keyword" placeholder="Tìm kiếm sản phẩm..." />
          <button type="button">🔍</button>
        </div>
        <div class="header-contact">
          <span>📞</span>
          <span class="hotline-number">08 888 03 999</span>
        </div>
      </div>
    </div>

    <nav class="navbar">
      <div class="navbar-container">
        <div class="category-button">
          <span>☰</span>
          <span class="category-label">DANH MỤC SẢN PHẨM</span>
        </div>
        <div class="navbar-main">
          <div class="navbar-pc">
            <router-link to="/">TRANG CHỦ</router-link>
            <a href="#">GIỚI THIỆU</a>
            <a href="#">SẢN PHẨM</a>
            <a href="#">TIN TỨC</a>
            <a href="#">LIÊN HỆ</a>
          </div>
          <router-link to="/check-cart" class="cart-link">
            <div class="cart">
              <span class="cart-count">{{ cart.count }}</span>
              <span>🛒</span>
            </div>
          </router-link>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'AppHeader',
  data() {
    return { keyword: '' }
  },
  computed: {
    ...mapState(['cart'])
  }
}
</script>

<style scoped>
.header {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.08);
}

.top-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  max-width: 1200px;
  padding: 10px;
}

.logo img {
  max-height: 80px;
}

.search-bar {
  display: flex;
  align-items: center;
  gap: 30px;
}

.search-form {
  display: flex;
  height: 38px;
  width: 380px;
  border: 1px solid #a9a9a9;
  border-radius: 3px;
  overflow: hidden;
}

.search-form input {
  flex: 1;
  border: none;
  padding: 0 10px;
  font-size: 14px;
  outline: none;
}

.search-form button {
  background-color: #EF233C;
  border: none;
  padding: 0 12px;
  cursor: pointer;
  color: white;
}

.header-contact {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 16px;
}

.hotline-number {
  color: #DD4333;
  font-weight: 700;
}

.navbar {
  width: 100%;
  background-color: #EF233C;
  display: flex;
  justify-content: center;
}

.navbar-container {
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 1200px;
}

.category-button {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 250px;
  padding: 18px 15px;
  background-color: #D92037;
  cursor: pointer;
  color: white;
}

.category-label {
  font-size: 14px;
  font-weight: 600;
}

.navbar-main {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex: 1;
}

.navbar-pc {
  display: flex;
  gap: 4px;
  padding: 18px 10px;
}

.navbar-pc a {
  color: white;
  text-decoration: none;
  font-size: 14px;
  padding: 0 8px;
  font-weight: 500;
}

.navbar-pc a:hover { color: #FAEB31; }

.cart-link { text-decoration: none; }

.cart {
  display: flex;
  align-items: center;
  position: relative;
  padding: 18px 15px;
  background-color: #D92037;
  cursor: pointer;
  color: white;
  font-size: 22px;
}

.cart-count {
  position: absolute;
  top: 8px;
  right: 6px;
  background-color: #fff;
  color: #D92037;
  font-size: 11px;
  font-weight: 700;
  min-width: 18px;
  height: 18px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

@media (max-width: 900px) {
  .navbar-pc { display: none; }
  .category-label { display: none; }
  .category-button { width: auto; }
  .search-form { width: 200px; }
}
</style>