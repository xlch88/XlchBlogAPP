<template>
  <div id="appHeader">
    <mu-appbar style="width: 100%;" color="pinkA100">
      <mu-button icon slot="left" v-on:click="openBotttomSheet">
        <mu-icon value="menu"></mu-icon>
      </mu-button>
      {{ title }}
      <mu-button v-if="back" icon slot="right" v-on:click="toBack">
        <mu-icon value="arrow_forward"></mu-icon>
      </mu-button>
      <mu-button v-if="refush" icon slot="right" v-on:click="refush">
        <mu-icon value="refresh"></mu-icon>
      </mu-button>
      <mu-button v-if="search" icon slot="right" v-on:click="toggSearch">
        <mu-icon value="search" id="searchIcon"></mu-icon>
      </mu-button>
      <mu-button v-if="pageId == 'index'" icon slot="right" v-on:click="toggSearch">
        <mu-icon value="search" id="searchIcon"></mu-icon>
      </mu-button>
      <mu-button v-if="pageId == 'about'" icon slot="right" v-on:click="miaow">
        <mu-icon value="face"></mu-icon>
      </mu-button>
    </mu-appbar>

    <mu-container>
      <mu-bottom-sheet :open.sync="open">
        <mu-list @item-click="closeBottomSheet">
          <mu-sub-header>菜单</mu-sub-header>
          <mu-list-item button v-on:click="menu('openUrl')">
            <mu-list-item-action>
              <mu-icon value="language" color="green"></mu-icon>
            </mu-list-item-action>
            <mu-list-item-title>使用浏览器打开</mu-list-item-title>
          </mu-list-item>
          <mu-list-item button v-on:click="menu('copyUrl')" data-clipboard-target="#copy" class="copyButton">
            <mu-list-item-action>
              <mu-icon value="language" color="green"></mu-icon>
            </mu-list-item-action>
            <mu-list-item-title>复制页面地址</mu-list-item-title>
          </mu-list-item>
          <mu-list-item button v-on:click="menu('about')">
            <mu-list-item-action>
              <mu-icon value="info" color="orange"></mu-icon>
            </mu-list-item-action>
            <mu-list-item-title>关于</mu-list-item-title>
          </mu-list-item>
          <mu-list-item button v-on:click="menu('joinQQGroup')">
            <mu-list-item-action>
              <mu-icon value="group_add" color="blue"></mu-icon>
            </mu-list-item-action>
            <mu-list-item-title>加入QQ群</mu-list-item-title>
          </mu-list-item>
          <mu-list-item button v-on:click="menu('index')">
            <mu-list-item-action>
              <mu-icon value="home" color="green"></mu-icon>
            </mu-list-item-action>
            <mu-list-item-title>返回首页</mu-list-item-title>
          </mu-list-item>
          <mu-divider></mu-divider>
          <mu-list-item button v-on:click="menu('exit')">
            <mu-list-item-action>
              <mu-icon value="exit_to_app" color="cyan"></mu-icon>
            </mu-list-item-action>
            <mu-list-item-title>退出</mu-list-item-title>
          </mu-list-item>
        </mu-list>
      </mu-bottom-sheet>
    </mu-container>

    <input id="copy" value="" style="display:none" />
  </div>
</template>
<script>
import appFooter from '@/template/app-footer'
var footer = appFooter;
export default {
  props: ['refush', 'back', 'search'],
  data() {
    return {
      title: window.document.categoryName
        ? window.document.categoryName
        : window.document.title,
      navId: window.document.navId,
      pageId: window.document.pageId,
      open: false,
      miao: true
    }
  },
  created() {
    var clipboard = new Clipboard('.copyButton')
    var _this = this
    clipboard.on('success', function(e) {
      _this.$layer.toast({
        content: '复制成功 ~',
        time: 1500
      })
      console.log(e)
    })
    clipboard.on('error', function(e) {
      console.log(e)
      window.prompt('复制失败了.. 手动复制一下吧！', $(e.trigger).val())
    })
  },
  methods: {
    miaow() {
      if (typeof plus !== 'undefined')
        plus.push.createMessage('花Q！花Q！！', 'LocalMSG', { cover: false })

      if (this.miao) {
        this.$layer.toast({
          content: '唔 ~',
          time: 1500
        })
      } else {
        this.$layer.toast({
          content: '喵 ~',
          time: 1500
        })
      }
      this.miao = !this.miao
    },
    getNowUrl() {
      if (this.pageId == 'tag-view') {
        var url = 'https://xlch.me/?tag=' + window.document.categoryName
      } else if (this.pageId == 'category-view') {
        var url = 'https://xlch.me/?cat=' + window.document.now_id
      } else if (this.pageId == 'read') {
        var url = 'https://xlch.me/?p=' + window.document.now_id
      } else {
        var url = 'https://xlch.me/'
      }
      return url
    },
    copyText(text) {
      var $ = window.$
      $('#copy').val(text)
    },
    menu(id) {
      switch (id) {
        case 'openUrl':
          window.document.openUrl(this.getNowUrl())
          break
        case 'copyUrl':
          this.copyText(this.getNowUrl())
          break
        case 'about':
          this.$router.push({ path: '/about' })
          break
        case 'joinQQGroup':
          this.$router.push({ path: '/about' })
          break
        case 'index':
          this.$router.push({ path: '/index' })
          break
        case 'exit':
          if (typeof plus !== 'undefined') plus.runtime.quit()
          else
            this.$layer.toast({
              content: '网页版你退出个卵子啊！',
              time: 1500
            })
          break
      }
    },
    toggSearch() {
      $ = window.jQuery
      if ($('#searchBox').hasClass('open')) {
        $('#searchBox').removeClass('open')
        $('#searchIcon').html('search')
      } else {
        $('#searchBox').addClass('open')
        $('#searchIcon').html('keyboard_arrow_up')
      }
    },
    toBack() {
      window.document.categoryName = ''
      if (this.back == '-1') this.$router.go(-1)
      else this.$router.push({ path: '/' + this.back })
    },
    closeBottomSheet() {
      this.open = false
    },
    openBotttomSheet() {
      this.open = true
    }
  }
}
</script>
<style>
#appHeader {
  position: fixed;
  width: 100%;
  top: 0px;
  z-index: 10000;
}
.mu-appbar-title {
  text-align: center;
}
</style>
