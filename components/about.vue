<template>
    <div>
        <app-header />
        <div id="appMain">
            <mu-container style="padding: 40px 0 10px 0;">
                <center>
                    <mu-avatar size="100">
                        <img v-lazy="'https://q1.qlogo.cn/g?b=qq&nk=408214421&s=640'" src="/static/img/loading.png">
                    </mu-avatar>
                    <p>二小姐の地下室 APP</p>
                </center>
            </mu-container>
            <mu-container>
                <mu-list toggle-nested>
                    <mu-list-item :ripple="false" avatar button>
                        <mu-list-item-action>
                            <mu-avatar color="red">
                                <div class="mu-avatar-inner">
                                    <i class=" mu-icon  material-icons  " style="user-select: none;">build</i>
                                </div>
                            </mu-avatar>
                        </mu-list-item-action>
                        <mu-list-item-content>
                            <mu-list-item-title style="color:#e91e63">
                               版本 <small style="color:rgb(187,187,187)">Version</small>
                            </mu-list-item-title>
                            <mu-list-item-sub-title>
                                0.0.1 Beta
                            </mu-list-item-sub-title>
                        </mu-list-item-content>
                    </mu-list-item>

                    <mu-divider></mu-divider>

                    <mu-list-item :ripple="false" avatar button>
                        <mu-list-item-action>
                            <mu-avatar color="pink">
                                <div class="mu-avatar-inner">
                                    <i class=" mu-icon  material-icons  " style="user-select: none;">face</i>
                                </div>
                            </mu-avatar>
                        </mu-list-item-action>
                        <mu-list-item-content>
                            <mu-list-item-title style="color:#e91e63">
                               作者 <small style="color:rgb(187,187,187)">Author</small>
                            </mu-list-item-title>
                            <mu-list-item-sub-title>
                                Xlch88
                            </mu-list-item-sub-title>
                        </mu-list-item-content>
                    </mu-list-item>

                    <mu-divider></mu-divider>
                    
                    <mu-list-item :ripple="false" avatar button>
                        <mu-list-item-action>
                            <mu-avatar color="cyan">
                                <div class="mu-avatar-inner">
                                    <i class=" mu-icon  material-icons  " style="user-select: none;">language</i>
                                </div>
                            </mu-avatar>
                        </mu-list-item-action>
                        <mu-list-item-content>
                            <mu-list-item-title style="color:#e91e63">
                               网址 <small style="color:rgb(187,187,187)">Url</small>
                            </mu-list-item-title>
                            <mu-list-item-sub-title>
                                <font style="color:green">https://</font>xlch.me/
                            </mu-list-item-sub-title>
                        </mu-list-item-content>
                    </mu-list-item>

                    <mu-divider></mu-divider>
                    
                    <mu-list-item :ripple="false" avatar button>
                        <mu-list-item-action>
                            <mu-avatar color="teal">
                                <div class="mu-avatar-inner">
                                    <i class=" mu-icon  material-icons  " style="user-select: none;">code</i>
                                </div>
                            </mu-avatar>
                        </mu-list-item-action>
                        <mu-list-item-content>
                            <mu-list-item-title style="color:#e91e63">
                               开发工具 <small style="color:rgb(187,187,187)">Developer tools</small>
                            </mu-list-item-title>
                            <mu-list-item-sub-title>
                                Vue.js
                            </mu-list-item-sub-title>
                        </mu-list-item-content>
                    </mu-list-item>

                    <mu-divider></mu-divider>
                    
                    <mu-list-item :ripple="false" avatar button>
                        <mu-list-item-action>
                            <mu-avatar color="blue">
                                <div class="mu-avatar-inner">
                                    <i class=" mu-icon  material-icons  " style="user-select: none;">group</i>
                                </div>
                            </mu-avatar>
                        </mu-list-item-action>
                        <mu-list-item-content>
                            <mu-list-item-title style="color:#e91e63">
                               QQ交流群 <small style="color:rgb(187,187,187)">QQ group</small>
                            </mu-list-item-title>
                            <mu-list-item-sub-title>
                               732195457
                            </mu-list-item-sub-title>
                        </mu-list-item-content>
                    </mu-list-item>

                </mu-list>
            </mu-container>
        </div>
        <app-footer />
    </div>
</template>
<script>
import appHeader from '@/template/app-header'
import appFooter from '@/template/app-footer'
export default {
  name: 'index',
  props: ['id'],
  components: {
    appFooter,
    appHeader
  }
}
</script>
<style>
</style>