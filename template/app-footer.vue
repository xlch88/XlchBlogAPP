<template>
  <div id="appFooter">
    <mu-bottom-nav :value.sync="shift" color="pinkA100" v-on:change="change">
      <mu-bottom-nav-item value="index" title="首页" icon="home"></mu-bottom-nav-item>
      <mu-bottom-nav-item value="category" title="分类" icon="view_list"></mu-bottom-nav-item>
      <mu-bottom-nav-item value="tag" title="标签云" icon="turned_in"></mu-bottom-nav-item>
      <mu-bottom-nav-item value="about" title="关于" icon="info"></mu-bottom-nav-item>
    </mu-bottom-nav>
  </div>
</template>
<script>
export default {
  data() {
    return {
      open: false,
      window: window,
      shift: window.document.navId
    }
  },
  methods: {
    change(value) {
      window.document.categoryName = ''
      this.$router.push({ path: '/' + value })
    }
  }
}
</script>
<style>
#appFooter {
  position: fixed;
  bottom: 0px;
  width: 100%;
  z-index:1000;
}
</style>
