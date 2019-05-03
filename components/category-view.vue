<template>
    <div>
        <app-header back="category" />
        <div id="appMain">
            <div id="category-view">
                <post-card-list :id="id" type="category" />
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
  props: ['id', 'type'],
  components: {
    appFooter,
    appHeader,
    postCardList
  }
}
</script>
<style>
</style>
