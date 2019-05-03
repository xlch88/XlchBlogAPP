<template>
  <div>
    <app-header />
    <div id="appMain">
      <div id="index" v-on:click="closeSearchBox">
        <post-card-list />
      </div>
      <div id="searchBox">
        <mu-form :model="searchForm" class="searchForm" v-on:submit="search(this)">
          <mu-text-field v-model="searchForm.inputValue" class="searchInput"></mu-text-field>
        </mu-form>
      </div>
    </div>
    <app-footer />
  </div>
</template>

<script>
import postCardList from '@/template/post-card-list'
import appHeader from '@/template/app-header'
import appFooter from '@/template/app-footer'
export default {
  name: 'index',
  components: {
    appHeader,
    appFooter,
    postCardList
  },
  methods: {
    search() {
      window.document.categoryName = '搜索：' + this.searchForm.inputValue
      this.$router.push({ path: '/search/' + this.searchForm.inputValue })
    },
    closeSearchBox() {
      if ($('#searchBox').hasClass('open')) {
        $('#searchBox').removeClass('open')
        $('#searchIcon').html('search')
      }
    }
  },
  data() {
    return {
      title: '二小姐の地下室',
      pageId: 'index',
      data_type: this.type ? this.type : '',
      data_id: this.id ? this.id : '',
      searchForm: {
        inputValue: ''
      }
    }
  }
}
</script>
<style>
#searchBox {
  border: 1px;
  height: 56px;
  width: 100%;
  background: #ff80ab;
  position: fixed;
  top: -10px;
  left: 0px;
  transition: top 0.2s;
}
.searchInput {
  top: 10px;
  width: 90%;
}
.searchForm {
  text-align: center;
}
#searchBox.open {
  top: 56px;
  box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.2), 0 4px 5px 0 rgba(0, 0, 0, 0.14),
    0 1px 10px 0 rgba(0, 0, 0, 0.12);
}
</style>
