<script setup>
import {Link} from '@inertiajs/vue3'
import BreadcrumbsComponent from "@/Components/Breadcrumbs.vue";
import TopBar from "@/Components/TopBar.vue";
</script>

<template>
  <v-app class="bg-grey-lighten-4 font">
    <v-navigation-drawer v-model="sidebarDrawer" style="border: unset !important" color="#fff" :rail="rail">
      <div class="logo pa-5 ml-7">
        <!--        <v-img width="100" height="100" src="https://i.postimg.cc/50QZTT0H/ca-logo-2-removebg.png"></v-img>-->
        <span class="heading-4 fs-cursive">Apoli</span>
      </div>

      <!--      <v-list>-->
      <!--        <v-list-item-->
      <!--          :prepend-avatar="avatar"-->
      <!--          :title="$page.props.auth.user.name"-->
      <!--          :subtitle="$page.props.auth.user.email"-->
      <!--        />-->
      <!--      </v-list>-->
      <!--      <NavigationMenu class="mt-5" />-->
      <v-divider color="#A3AED0"></v-divider>
      <v-list nav>
        <!-- List Menu -->
        <div class="side-items d-flex flex-column ga-4">
          <Link
            v-for="(item, key) in navigation.items"
            :key="key"
            :class="{ 'side-items-active font-weight-bold': $page.url.startsWith(item.to) }"
            :href="item.to"
            as="div"
          >
            <v-list-item
              class="cursor-pointer w-100"
              :exact="item.exact"
            >
              <div class="d-flex justify-space-between align-center">
                <div class="d-flex gap-12 align-center">
                  <span v-html="item.icon"></span>
                  <span class="fc-primary">{{ item.title }}</span>
                </div>
              </div>
            </v-list-item>
          </Link>
        </div>
        <!-- Log Out -->
      </v-list>
      <template #append>
<!--        <div class="track-card pa-15 ml-3">-->
<!--          <div class="d-flex flex-column">-->
<!--            <span class="font-weight-bold ml-7 fc-white heading-5">Track</span>-->
<!--            <span class="ml-5">Your site</span>-->
<!--          </div>-->
<!--        </div>-->
        <div class="pa-2">
          <Link href="/logout" method="post" as="div">
            <v-list-item prepend-icon="mdi-exit-to-app" title="Log Out" link/>
          </Link>
        </div>
      </template>
    </v-navigation-drawer>
    <!--    <v-app-bar color="primary">-->
    <!--      <v-app-bar-nav-icon v-if="$vuetify.display.mobile" @click.stop="drawer = !drawer" />-->
    <!--      <v-app-bar-nav-icon v-else @click.stop="rail = !rail" />-->
    <!--      <v-toolbar-title />-->
    <!--    </v-app-bar>-->
    <v-navigation-drawer v-model="settingsDrawer" style="border: unset !important" color="#fff" location="end" :rail="rail">
      <div class="mt-3 ml-3">
        <h1>Settings</h1>
      </div>
      <div class="ma-3 mt-8">
        <v-label class="font-reg">The opening video</v-label>
        <v-text-field v-model="settingsData.video" class="input" placeholder="Url" variant="text"></v-text-field>
        <v-label class="font-reg">Total Chairs</v-label>
        <v-text-field v-model="settingsData.total_tables" class="input" type="number" min="1" placeholder="Tables" variant="text"></v-text-field>
      </div>
      <template #append>
        <div class="d-flex justify-space-between ma-3">

          <v-btn
            variant="outlined"
            color="#0E0F3D"
            @click="settingsDrawer = false"
            rounded
          >
            Close
          </v-btn>
          <v-btn
            color="#0E0F3D"
            @click="settingsApply"
            rounded
            variant="flat"
          > Apply
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>
    <v-main>
      <v-container>
        <v-row class="justify-end">
          <v-col cols="12">
            <top-bar @sidebar="sidebarDrawer = !sidebarDrawer" @settings="settingsDrawer = !settingsDrawer"/>
          </v-col>
        </v-row>
        <BreadcrumbsComponent :items="breadcrumbs" class="pa-0 mt-1"/>
        <slot/>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import md5 from 'crypto-js/md5'
import {useToast} from 'vue-toastification'
// import NavigationMenu from '@/Components/NavigationMenu.vue'
import navigation from '@/Configs/navigation.js'
import {router, usePage} from "@inertiajs/vue3";

export default {
  // components: { NavigationMenu },
  data() {
    return {
      drawer: false,
      settingsDrawer: false,
      sidebarDrawer: false,
      rail: false,
      breadcrumbs: [
        {
          title: 'Dashboard',
          disabled: true,
        },
      ],
      settingsData:{
        video:'',
        total_tables:''
      }
    }
  },
  methods:{
    ensureEmbedUrl(url) {
      if (url){
      if (url.includes('youtu.be') && !url.includes('embed')) {
        url = url.replace('youtu.be', 'youtube.com/embed');
      }

      return url;
      }
    },
    settingsApply(){
      router.post(`/settings-update/${this.$page.props.auth.settings.id}`,{
        video:this.ensureEmbedUrl(this.settingsData.video),
        total_tables:this.settingsData.total_tables,
      })
    }
  },
  computed: {
    navigation() {
      return navigation
    },
    avatar() {
      return `https://www.gravatar.com/avatar/${md5(this.$page.props.auth.user.email)}?s=200`
    },
  },
  watch: {
    $page: {
      handler() {
        const toast = useToast()
        const flash = this.$page.props.flash
        if (flash.success) {
          toast.success(flash.success)
        } else if (flash.error) {
          toast.error(flash.error)
        }
      },
    },
  },
  // need fixing
  mounted() {
    this.settingsData.video = usePage().props.auth.settings.video
    this.settingsData.total_tables = usePage().props.auth.settings.total_tables
    this.sidebarDrawer = !this.$vuetify.display.mobile
  },
}
</script>
