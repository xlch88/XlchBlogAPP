<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      title: window.document.title,
      navId: window.document.navId,
      pageId: window.document.pageId
    }
  },
  created() {
    var $ = window.$;
    var _this = this;
    window.onload=function(){
      window.document.addEventListener('plusready', function () {});
      _this.initBackButton();
    }
  },
  methods: {
    initBackButton() {
      var appInfo = {
        version: '1.0.0'
      }
      var deviceInfo =
        typeof plus !== 'undefined'
          ? {
              'plus.device.imei': plus.device.imei,
              'plus.device.imsi': plus.device.imsi,
              'plus.device.model': plus.device.model,
              'plus.device.vendor': plus.device.vendor,
              'plus.device.uuid': plus.device.uuid,
              'plus.screen.resolutionHeight': plus.screen.resolutionHeight,
              'plus.screen.resolutionWidth': plus.screen.resolutionWidth,
              'plus.screen.scale': plus.screen.scale,
              'plus.screen.dpiX': plus.screen.dpiX,
              'plus.screen.dpiY': plus.screen.dpiY,
              'plus.screen.getBrightness()': plus.screen.getBrightness(),
              'plus.display.resolutionHeight': plus.display.resolutionHeight,
              'plus.display.resolutionWidth': plus.display.resolutionWidth,
              'plus.networkinfo.getCurrentType()': plus.networkinfo.getCurrentType(),
              'plus.os.language': plus.os.language,
              'plus.os.version': plus.os.version,
              'plus.os.name': plus.os.name,
              'plus.os.vendor': plus.os.vendor
            }
          : {}
      var _this = this;
      plus.key.addEventListener('backbutton', function() {
        if (document.pageId === 'index') {
          if (plus.os.name === 'Android') {
            _this.$layer.toast({
              content: '再次点击返回键退出应用',
              time: 1500
            })
            setTimeout(function() {
              plus.key.removeEventListener('backbutton', () => {})
            }, 1000)

            plus.key.addEventListener('backbutton', () => {
              plus.runtime.quit()
            })
          } else {
            _this.$layer.toast({
              content: 'iPhone 就！是！个！垃！圾！',
              time: 1500
            })
          }
        } else {
          _this.$router.go(-1)
        }
      })

      var $ = window.$
      $.post(
        'https://xlch.me/api.php?do=start',
        {
          info: JSON.stringify({ appInfo: appInfo, deviceInfo: deviceInfo })
        },
        res => {}
      )
    }
  }
}
</script>
<style>
#appMain {
  margin: 56px 0 56px 0;
}
</style>
