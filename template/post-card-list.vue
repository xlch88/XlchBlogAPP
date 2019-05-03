<template>
  <mu-load-more @refresh="refresh" :refreshing="refreshing" :loading="loading" @load="load">
    <template v-for="card in data">
      <mu-card class="m20" v-on:click="read(card.ID)">
        <mu-card-media :title="card.post_title" :sub-title="card.sub_title" class="img">
          <img v-lazy="card.img" src="/static/img/loading.png">
        </mu-card-media>
        <mu-card-text>
          {{card.post_content}}
        </mu-card-text>
      </mu-card>
    </template>
  </mu-load-more>
</template>
<script>
import $ from 'webpack-zepto'

export default {
  name: 'cardList',
  props: ['id', 'type'],
  data() {
    return {
      num: 10,
      refreshing: false,
      loading: false,
      data: [],
      page: 0
    }
  },
  created() {
    this.refresh(), (window.document.now_id = this.id)
  },
  methods: {
    read(id) {
      this.$router.push({ path: '/read/' + id })
    },
    refresh() {
      this.refreshing = true
      this.page = 0
      this.data = []
      this.getData()
      setTimeout(() => {
        this.refreshing = false
      }, 300)
    },
    load() {
      this.loading = true
      setTimeout(() => {
        this.page++
        this.getData()
        this.loading = false
      }, 300)
    },
    getData() {
      var type = this.type
      var id = this.id
      var page = typeof this.page != 'undefined' ? this.page : 0

      var cacheName = 'cache_postList' + '_' + type + '_' + id
      var cache = ''

      if (page == 0 && (cache = JSON.parse(localStorage.getItem(cacheName)))) {
        this.data = cache
        console.log('use cache: ' + cacheName)
      }

      $.get(
        'https://xlch.me/api.php?do=post&page=' +
          page +
          (type ? '&type=' + type + '&cid=' + id : ''),
        res => {
          if (res && (res = JSON.parse(res))) {
            if (res.code == 1) {
              if (res.data.length == 0) {
                this.$layer.toast({
                  content: '没有更多的信息啦！',
                  time: 1500
                })
              } else {
                if (page == 0 && res.data != this.data) {
                  this.data = res.data
                  localStorage.setItem(cacheName, JSON.stringify(this.data))
                } else {
                  this.data =
                    typeof this.data != 'undefined'
                      ? this.data.concat(res.data)
                      : res.data
                }
              }
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
        }
      )
    }
  }
}
</script>
<style>
.m20 {
  margin: 20px;
}
.img {
  min-height: 200px;
}
</style>
