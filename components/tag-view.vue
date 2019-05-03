<template>
    <div>
        <app-header back="tag" />
        <div id="appMain">
            <div id="tag-view">
                <post-card-list :id="id" type="tag" />
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
  props: ['id'],
  components: {
    appFooter,
    appHeader,
    postCardList
  }
}
</script>
<style>
</style>
