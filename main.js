// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import VueLazyLoad from 'vue-lazyload'
import App from './App'

import layer from 'vue-layer-mobile'
import 'vue-layer-mobile/need/layer.css'

import 'muse-ui/dist/muse-ui.css'
import 'muse-ui-loading/dist/muse-ui-loading.css' // load css
import MuseUI from 'muse-ui'
import theme from 'muse-ui/lib/theme'
import Router from 'vue-router'
import Loading from 'muse-ui-loading'

import pageIndex from '@/components/index'
import pageCategory from '@/components/category'
import pageCategoryView from '@/components/category-view'
import pageTag from '@/components/tag'
import pageTagView from '@/components/tag-view'
import pageSearch from '@/components/search'
import pageAbout from '@/components/about'
import pageRead from '@/components/read'

Vue.use(MuseUI)
Vue.use(layer)
theme.use('light')
Vue.use(Loading)
Vue.use(Router)
Vue.use(VueLazyLoad, {
  error: './static/img/falied.png',
  loading: './static/img/loading.png'
})

var router = new Router({
  routes: [
    {
      path: '/',
      component: pageIndex,
      meta: { pageId: 'index', title: '二小姐の地下室', navId: 'index' }
    },
    {
      path: '/index',
      component: pageIndex,
      meta: { pageId: 'index', title: '二小姐の地下室', navId: 'index' }
    },
    {
      path: '/read/:id',
      component: pageRead,
      meta: { pageId: 'read', title: '阅读文章', navId: 'index' },
      props: true
    },
    {
      path: '/category',
      component: pageCategory,
      meta: { pageId: 'category', title: '分类目录', navId: 'category' }
    },
    {
      path: '/category/:id',
      component: pageCategoryView,
      meta: { pageId: 'category-view', title: '分类浏览', navId: 'category' },
      props: true
    },
    {
      path: '/tag',
      component: pageTag,
      meta: { pageId: 'tag', title: '标签云', navId: 'tag' }
    },
    {
      path: '/tag/:id',
      component: pageTagView,
      meta: { pageId: 'tag-view', title: '标签云', navId: 'tag' },
      props: true
    },
    {
      path: '/search/:id',
      component: pageSearch,
      meta: { pageId: 'search', title: '搜索', navId: 'index' },
      props: true
    },
    {
      path: '/about',
      component: pageAbout,
      meta: { pageId: 'about', title: '关于', navId: 'about' }
    }
  ]
})

router.beforeEach((to, form, next) => {
  if (to.meta.title) {
    document.title = to.meta.title
    document.pageId = to.meta.pageId
    document.navId = to.meta.navId
  }
  console.log(window.document.navId);
  next()
})

Vue.config.productionTip = false

window.document.openUrl = url => {
  if (typeof plus !== 'undefined') {
    plus.webview
      .create(url, 'target_blank', {
        titleNView: {
          autoBackButton: true,
          backgroundColor: '#ff80ab',
          titleColor: '#fff',
          progress: {
            color: '#ff80c6',
            height: '1px'
          },
          splitLine: {
            color: '#ff80c6',
            height: '1px'
          }
        },
        backButtonAutoControl: 'close',
        scalable: false,
        bounce: 'all'
      })
      .show('pop-in')
  } else {
    window.open(url)
  }
}

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
