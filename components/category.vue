<template>
  <mu-load-more @refresh="refresh" :refreshing="refreshing">
    <app-header :refush="getData" />
    <div id="appMain">
      <mu-list toggle-nested>
        <template v-for="category in data">
          <mu-list-item v-on:click="categoryPosts(category.term_id,category.name)" v-if="!category.son" avatar :ripple="false" button :key="category.term_id">
            <mu-list-item-action>
              <mu-avatar color="pink100">
                <div class="mu-avatar-inner">
                  <i class=" mu-icon  material-icons  " style="user-select: none;">folder</i>
                </div>
              </mu-avatar>
            </mu-list-item-action>
            <mu-list-item-content>
              <mu-list-item-title style="color:#e91e63">
                {{category.name}}
              </mu-list-item-title>
              <mu-list-item-sub-title>
                共有 {{category['count']}} 篇文章。
              </mu-list-item-sub-title>
            </mu-list-item-content>
          </mu-list-item>

          <mu-list-item v-if="category.son" button :ripple="false" nested :open="false" :key="category.term_id">
            <mu-list-item-action>
              <mu-avatar color="pink100">
                <div class="mu-avatar-inner">
                  <i class=" mu-icon  material-icons  " style="user-select: none;">folder</i>
                </div>
              </mu-avatar>
            </mu-list-item-action>
            <mu-list-item-content>
              <mu-list-item-title style="color:#e91e63">{{category.name}}</mu-list-item-title>
              <mu-list-item-sub-title>
                共有 {{category['count']}} 篇文章。
              </mu-list-item-sub-title>
            </mu-list-item-content>
            <mu-list-item-action>
              <mu-icon class="toggle-icon" size="24" value="keyboard_arrow_down"></mu-icon>
            </mu-list-item-action>

            <mu-list-item v-on:click="categoryPosts(category.term_id,category.name)" button :ripple="false" slot="nested">
              <mu-list-item-title>{{category.name}}
                <span style="color:#999">{{category.count}}篇文章</span>
              </mu-list-item-title>
            </mu-list-item>
            <template v-for="son in category.son">
              <mu-list-item v-on:click="categoryPosts(son.term_id,son.name)" button :ripple="false" slot="nested" :key="son.term_id">
                <mu-list-item-title>{{son.name}}
                  <span style="color:#999">{{son.count}}篇文章</span>
                </mu-list-item-title>
              </mu-list-item>
            </template>
          </mu-list-item>
          <mu-divider></mu-divider>
        </template>
      </mu-list>
    </div>
    <app-footer />
  </mu-load-more>
</template>
<script>
import appHeader from '@/template/app-header'
import appFooter from '@/template/app-footer'
import $ from 'webpack-zepto'
export default {
  name: 'category',
  components: {
    appFooter,
    appHeader
  },
  data() {
    return {
      data: [],
      refreshing: false
    }
  },
  created() {
    this.refresh()
  },
  methods: {
    refresh() {
      this.refreshing = true
      this.getData()
      setTimeout(() => {
        this.refreshing = false
      },300)
    },
    categoryPosts(id, name) {
      window.document.categoryName = name

      this.$router.push({ path: '/category/' + id })
    },
    getData() {
      var cacheName = 'cache_category'
      var cache = ''

      if ((cache = JSON.parse(localStorage.getItem(cacheName)))) {
        this.data = cache;
        console.log('use cache: ' + cacheName);
      }

      $.get('https://xlch.me/api.php?do=term&type=category', res => {
        if (res && (res = JSON.parse(res))) {
          if (res.code == 1) {
            if (res.data != this.data) {
              localStorage.setItem(cacheName, JSON.stringify(res.data))
            }
            this.data = res.data
          } else {
            this.$layer.toast({
              content: '获取失败：' + res.msg,
              time: 1500
            })
          }
        } else {
          this.$layer.toast({
            content: '获取失败!',
            time: 1500
          })
        }
      })
    }
  }
}
</script>
<style>
</style>
