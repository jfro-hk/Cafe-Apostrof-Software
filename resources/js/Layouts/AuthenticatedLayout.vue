<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <v-app class="bg-grey-lighten-4 font">
    <v-navigation-drawer v-model="drawer" style="border: unset !important" color="#fff" :rail="rail" permanent>
      <div class="logo pa-5 ml-7">
        <v-img width="100" height="100" src="https://i.postimg.cc/50QZTT0H/ca-logo-2-removebg.png"></v-img>

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
        <div class="side-items">
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
              :class="{ 'fc-primary': $page.url.startsWith(item.to) }"
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
        <div class="track-card pa-15 ml-3">
          <div class="d-flex flex-column">
            <span class="font-weight-bold ml-7 fc-white heading-5">Track</span>
            <span class="ml-5">Your site</span>
          </div>
        </div>
        <div class="pa-2">
          <Link href="/logout" method="post" as="div">
            <v-list-item prepend-icon="mdi-exit-to-app" title="Log Out" link />
          </Link>
        </div>
      </template>
    </v-navigation-drawer>
    <!--    <v-app-bar color="primary">-->
    <!--      <v-app-bar-nav-icon v-if="$vuetify.display.mobile" @click.stop="drawer = !drawer" />-->
    <!--      <v-app-bar-nav-icon v-else @click.stop="rail = !rail" />-->
    <!--      <v-toolbar-title />-->
    <!--    </v-app-bar>-->
    <v-main>
      <v-container>
        <slot />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import md5 from 'crypto-js/md5'
import { useToast } from 'vue-toastification'
// import NavigationMenu from '@/Components/NavigationMenu.vue'
import navigation from '@/Configs/navigation.js'

export default {
  // components: { NavigationMenu },
  data() {
    return {
      drawer: false,
      rail: false,
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
  mounted() {
    this.drawer = !this.$vuetify.display.mobile
  },
}
</script>
