<template>
  <mu-load-more @refresh="refresh" :refreshing="refreshing">
    <app-header back="-1" />
    <div id="appMain">
      <div id="read">
        <mu-card>
          <mu-card-media :title="data.post_title" :sub-title="data.sub_title" class="img">
            <img :src="data.img">
          </mu-card-media>
          <mu-card-text id="page" class="article-content" style="word-break:break-all;word-wrap:break-word;"></mu-card-text>
        </mu-card>

        <mu-container style="padding: 0px 0 30px 0;">
          <center>
            <mu-button v-if="!liked" large fab color="red" style="margin: 30px 0 30px 0;" v-on:click="like">
              <mu-icon value="thumb_up"></mu-icon>
            </mu-button>
            <mu-button v-if="liked" large fab color="pink100" style="margin: 30px 0 30px 0;" v-on:click="$layer.toast({content: '已经对这篇文章点过赞啦!',time: 1500})">
              <mu-icon value="thumb_up"></mu-icon>
            </mu-button>
            <share v-if="share" :config="share"></share>
          </center>
        </mu-container>
      </div>
    </div>
    <app-footer />
  </mu-load-more>
</template>
<script>
import appHeader from '@/template/app-header'
import appFooter from '@/template/app-footer'

import Vue from 'vue'
import Share from 'vue-social-share'
import 'vue-social-share/dist/client.css'
import '@/assets/style/read.css'

import $ from 'webpack-zepto'

Vue.use(Share)

export default {
  name: 'read',
  props: ['id'],
  components: {
    appFooter,
    appHeader
  },
  data() {
    return {
      data: {
        post_title: '加载中_(:з」∠)_',
        sub_title: '稍等一下下...',
        img: './static/img/loading.png'
      },
      refreshing: false,
      share: false,
      liked: !!localStorage.getItem('like_' + this.id)
    }
  },
  created() {
    this.refresh()

    window.document.now_id = this.id
  },
  methods: {
    refresh() {
      this.refreshing = true
      this.getData()
      setTimeout(() => {
        this.refreshing = false
      }, 300)
    },
    like() {
      var $ = window.$
      $.post(
        'https://xlch.me/wp-admin/admin-ajax.php',
        { action: 'bigfa_like', um_id: this.id, um_action: 'ding' },
        res => {
          if (res) {
            this.$layer.toast({ content: '点赞成功!', time: 1500 })
            localStorage.setItem('like_' + this.id, 'true')
            this.liked = true
          } else {
            this.$layer.toast({
              content: '点赞失败啦!重新试一下吧!',
              time: 1500
            })
          }
        }
      )
    },
    initRead(data) {
      var $ = window.$

      $('#page').html(data.text)
      this.parseLink('#page a')
      window.prettyPrint && window.prettyPrint()
    },
    parseLink(dom) {
      var $ = window.$
      console.log($(dom))
      $(dom).each(function() {
        $(this).unbind()
        var url = $(this).attr('href')
        if (url != 'javascript:') {
          $(this).attr('href', 'javascript:')
          $(this).click(function() {
            window.document.openUrl(url)
          })
        }
      })
    },
    getData() {
      var $ = window.$

      var cacheName = 'cache_read_' + this.id
      var cache = ''

      if ((cache = JSON.parse(localStorage.getItem(cacheName)))) {
        this.data = cache
        this.initRead(cache)
        console.log('use cache: ' + cacheName)
      }

      $.get('https://xlch.me/api.php?do=read&id=' + this.id, res => {
        if (res && (res = JSON.parse(res))) {
          if (res.code == 1) {
            $.get('https://xlch.me/?huaq=1&p=' + this.id, res2 => {
              res.data.text = res2

              if (res.data != this.data) {
                this.data = res.data
                localStorage.setItem(cacheName, JSON.stringify(res.data))

                this.initRead(res.data)
              }

              this.share = {
                url: 'http://xlch.me/?p=' + this.id,
                source: 'http://xlch.me/', // 来源（QQ空间会用到）, 默认读取head标签：<meta name="site" content="http://overtrue" />
                title: this.data.post_title, // 标题，默认读取 document.title 或者 <meta name="title" content="share.js" />
                description:
                  this.data.post_content
                    .replace(/<\/?.+?>/g, '')
                    .substr(0, 100) + '...', // 描述, 默认读取head标签：<meta name="description" content="PHP弱类型的实现原理分析" />
                image: this.data.img, // 图片, 默认取网页中第一个img标签
                disabled: ['diandian', 'tencent', 'twitter'], // 禁用的站点
                wechatQrcodeTitle: '微信扫一扫：分享', // 微信二维码提示文字
                wechatQrcodeHelper:
                  '<p>微信里点“发现”，扫一下</p><p>二维码便可将本文分享至朋友圈。</p>'
              }
              setTimeout(() => {
                this.parseLink('.social-share a')
              }, 1000)
            })
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
