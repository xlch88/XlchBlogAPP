<template>
  <div>
    <app-header :refush="refresh" />
    <div id="appMain">
      <mu-load-more @refresh="refresh" :refreshing="refreshing">
        <div id="huaQ">
        </div>
      </mu-load-more>

    </div>

    <app-footer />
  </div>
</template>
<script>
import appHeader from '@/template/app-header'
import appFooter from '@/template/app-footer'
import $ from 'webpack-zepto'

export default {
  name: 'tag',
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
      }, 300)
    },
    tagPosts(id, name) {
      window.document.categoryName = name

      this.$router.push({ path: '/tag/' + id })
    },
    showTag() {
      var data = []
      var _this = this
      this.data.forEach(function(value, index, array) {
        _this.data[index]['handlers'] = {
          click: function() {
            _this.tagPosts(value.id, value.text)
          }
        }
      })
      window
        .jQuery('#huaQ')
        .html('')
        .css({ height: window.innerHeight - 56 * 2, width: window.innerWidth })
        .jQCloud(this.data, {
          delayedMode: true
        })
    },
    getData() {
      jQuery.get('https://xlch.me/api.php?do=term&type=tag', res => {
        if (res && (res = JSON.parse(res))) {
          if (res.code == 1) {
            this.data = res.data
            this.showTag()
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
button {
  width: 50%;
  padding: 10px;
}
</style>
