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
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
             width="100" height="100" viewBox="0 0 791.000000 791.000000"
             preserveAspectRatio="xMidYMid meet">

          <g transform="translate(0.000000,791.000000) scale(0.100000,-0.100000)"
             fill="#2B3674" stroke="none">
            <path d="M3715 7763 c-796 -48 -1550 -338 -2182 -838 -125 -99 -159 -129 -338
-309 -558 -558 -917 -1267 -1040 -2049 -164 -1053 139 -2131 834 -2962 177
-212 481 -492 721 -662 603 -428 1342 -679 2091 -709 l171 -7 -7 -76 c-4 -41
-11 -86 -16 -99 -21 -56 -95 -52 1015 -52 l1023 0 119 122 c66 68 152 161 193
208 41 47 86 99 100 115 197 226 450 582 618 870 521 888 802 1826 803 2672 0
311 -25 545 -91 838 -141 626 -458 1226 -899 1700 -448 482 -1000 839 -1620
1046 -302 101 -645 168 -955 189 -146 9 -416 11 -540 3z m-670 -2082 c22 -10
56 -34 77 -54 20 -21 39 -37 43 -37 3 0 17 25 30 55 14 30 29 55 35 55 12 0
14 -392 3 -404 -4 -4 -13 31 -20 78 -15 104 -50 181 -109 240 -52 52 -99 71
-159 62 -46 -7 -68 -23 -102 -71 -68 -98 -90 -429 -43 -640 19 -83 58 -143
112 -171 38 -20 125 -17 173 5 86 40 128 116 147 264 15 118 27 111 16 -8 -5
-59 -15 -104 -33 -143 -52 -113 -107 -147 -240 -147 -82 0 -97 3 -157 33 -151
74 -228 233 -214 442 7 103 23 175 51 230 90 177 262 270 390 211z m1253 3
c43 -16 62 -47 62 -96 0 -38 -34 -78 -67 -78 -56 0 -84 79 -42 121 27 27 18
49 -20 49 -61 0 -83 -58 -79 -212 l3 -103 58 -3 c40 -2 57 -7 54 -15 -4 -13
-7 -14 -72 -16 l-45 -1 0 -252 c0 -139 4 -259 9 -267 5 -7 32 -16 60 -19 28
-2 51 -8 51 -13 0 -5 -81 -9 -180 -9 -113 0 -180 4 -180 10 0 6 19 10 43 10
80 0 78 -9 75 284 l-3 259 -54 1 c-77 1 -80 24 -4 28 l58 3 6 80 c6 89 18 121
65 181 56 70 124 90 202 58z m-2303 -96 c12 -99 45 -272 96 -509 l52 -237 91
-4 c106 -4 159 -28 210 -91 28 -36 31 -45 31 -114 0 -73 -1 -75 -37 -109 -32
-29 -45 -34 -86 -34 -28 0 -64 8 -87 20 -22 11 -40 20 -42 20 -3 0 6 -26 127
-365 94 -263 106 -289 152 -334 34 -35 100 -70 131 -71 12 0 17 -8 17 -30 l0
-30 -300 0 c-239 0 -300 3 -300 13 0 7 15 18 33 25 41 15 95 67 103 98 8 32 4
52 -49 244 -25 91 -66 248 -92 350 -26 102 -50 189 -55 193 -9 10 -96 -40
-180 -106 -36 -27 -118 -102 -182 -166 l-117 -116 -26 -90 c-59 -199 -36 -340
61 -381 26 -11 33 -19 30 -37 l-3 -22 -239 0 -239 0 -3 26 c-3 23 2 27 29 33
21 4 48 23 74 50 74 80 141 227 258 571 60 176 114 340 122 365 23 80 161 463
214 596 59 146 88 199 138 255 48 53 60 50 68 -13z m2765 32 c25 -13 42 -29
46 -46 9 -35 -2 -105 -18 -115 -47 -30 -115 17 -104 72 6 31 6 32 -27 26 -60
-9 -123 -47 -201 -119 -42 -39 -80 -68 -83 -64 -9 8 59 104 115 163 56 58 141
103 194 103 22 0 57 -9 78 -20z m-1095 -251 c21 -6 54 -26 72 -44 l33 -33 0
-226 c0 -241 6 -276 45 -276 39 0 49 26 53 136 3 60 9 104 14 104 6 0 9 -43 6
-116 -3 -109 -5 -116 -28 -135 -20 -16 -37 -19 -89 -16 -54 3 -67 7 -86 29
-13 15 -25 33 -28 40 -3 9 -12 4 -27 -16 -30 -37 -77 -56 -138 -56 -92 0 -159
72 -148 158 13 104 69 154 198 179 50 9 87 22 95 32 13 17 18 157 7 198 -11
41 -117 43 -164 5 l-22 -18 31 -32 c41 -40 40 -85 -2 -116 -26 -19 -30 -19
-55 -5 -15 8 -32 26 -39 40 -15 32 -2 94 26 123 49 48 159 69 246 45z m1025
-11 c24 -13 56 -39 71 -58 31 -39 59 -132 59 -197 l0 -43 -161 0 -162 0 6 -72
c8 -98 23 -146 57 -180 76 -76 224 13 245 147 3 25 11 45 16 45 12 0 2 -61
-18 -110 -31 -77 -111 -129 -196 -130 -163 -1 -277 179 -237 375 38 188 186
291 320 223z m2203 -554 c38 -29 57 -67 57 -117 0 -39 -5 -49 -35 -76 -43 -37
-61 -38 -106 -8 -29 20 -34 29 -37 70 -3 39 1 51 23 73 29 29 25 44 -11 44
-69 0 -84 -38 -84 -221 l0 -139 70 0 70 0 0 -30 0 -30 -70 0 -70 0 0 -314 c0
-356 -8 -326 91 -326 53 0 59 -2 59 -20 0 -20 -5 -20 -237 -18 -204 3 -238 5
-238 18 0 11 16 17 61 21 33 3 66 9 72 13 9 5 12 90 12 316 l0 309 -72 3 c-70
3 -73 4 -73 28 0 24 3 25 71 28 l71 3 5 82 c9 131 74 247 167 298 48 26 165
22 204 -7z m-2013 -194 l0 -180 90 0 90 0 0 -40 0 -40 -91 0 -91 0 4 -283 c3
-251 5 -286 21 -310 29 -45 86 -32 106 24 6 17 14 91 17 165 7 124 9 134 26
134 19 0 20 -7 16 -157 -3 -170 -9 -192 -64 -228 -61 -39 -178 -27 -237 25
-52 45 -57 78 -57 368 l0 261 -62 3 c-71 3 -87 21 -36 42 61 26 115 74 151
133 36 59 67 165 67 229 0 30 3 34 25 34 l25 0 0 -180z m-1980 -228 l0 -57 19
30 c60 97 144 116 254 57 108 -58 164 -192 155 -373 -4 -73 -11 -107 -31 -151
-61 -135 -138 -203 -245 -214 -56 -6 -101 17 -132 68 l-20 33 0 -192 c0 -112
4 -194 10 -198 5 -3 39 -8 75 -12 54 -5 65 -9 65 -24 0 -18 -13 -19 -240 -19
-228 0 -240 1 -240 19 0 15 11 20 61 25 33 4 67 10 75 13 12 4 14 78 14 488 0
547 10 495 -91 495 -56 0 -59 1 -59 24 0 23 3 24 107 31 59 4 130 11 157 14
28 4 54 6 59 4 4 -2 7 -30 7 -61z m928 30 c70 -34 145 -116 171 -188 78 -207
-3 -435 -187 -526 -66 -32 -178 -32 -241 1 -68 35 -128 98 -163 169 -27 54
-33 79 -36 154 -6 116 11 192 57 262 58 87 136 142 220 155 67 11 119 3 179
-27z m547 11 c69 -25 79 -25 107 2 15 14 31 25 35 25 4 0 7 -64 6 -142 -2
-126 -5 -143 -19 -143 -11 0 -21 14 -29 40 -37 125 -108 195 -196 195 -72 0
-119 -45 -119 -114 0 -66 37 -90 233 -151 141 -44 187 -106 187 -252 0 -82
-30 -139 -94 -178 -44 -27 -58 -30 -131 -30 -75 0 -86 3 -135 33 l-53 33 -38
-43 -38 -43 -1 173 c0 160 1 172 18 172 14 0 22 -13 32 -54 20 -85 70 -178
109 -203 27 -18 48 -23 103 -23 60 0 72 3 93 24 32 32 40 69 26 116 -17 56
-56 83 -159 110 -111 29 -186 76 -220 140 -33 62 -28 166 11 233 56 96 153
124 272 80z m1035 -33 l0 -49 48 48 c54 54 90 65 149 45 58 -20 93 -68 93
-126 0 -60 -14 -90 -51 -112 -93 -55 -174 78 -103 171 l25 33 -25 0 c-33 0
-88 -65 -111 -133 -16 -43 -19 -91 -23 -282 -4 -264 -8 -255 90 -255 51 0 58
-2 58 -20 0 -19 -7 -20 -240 -20 -233 0 -240 1 -240 20 0 18 7 20 54 20 30 0
66 4 80 10 l26 10 0 293 c0 226 -3 297 -13 311 -10 13 -32 19 -80 23 -56 5
-67 9 -67 24 0 14 12 18 73 24 39 3 110 9 157 13 47 5 88 6 93 4 4 -2 7 -25 7
-52z m739 30 c139 -63 210 -187 211 -365 0 -112 -28 -188 -98 -266 -77 -85
-136 -114 -232 -113 -89 0 -156 30 -221 96 -182 188 -126 533 104 647 57 28
174 29 236 1z"/>
            <path d="M1840 5162 c0 -7 -15 -51 -34 -100 -55 -140 -236 -624 -246 -654 -5
-16 -7 -28 -5 -28 2 0 23 28 48 63 66 93 168 199 252 261 40 31 78 56 84 56
17 0 14 22 -35 214 -41 160 -64 227 -64 188z"/>
            <path d="M2180 4676 c0 -22 17 -28 24 -10 9 22 8 24 -9 24 -8 0 -15 -6 -15
-14z"/>
            <path d="M3580 5082 c-86 -21 -102 -45 -107 -156 -5 -110 6 -139 56 -144 48
-5 105 57 114 123 9 65 9 183 0 188 -5 2 -33 -3 -63 -11z"/>
            <path d="M4559 5332 c-35 -31 -59 -111 -59 -200 l0 -53 103 3 102 3 -2 85 c-5
167 -64 234 -144 162z"/>
            <path d="M3008 4389 c-57 -33 -98 -174 -98 -343 0 -236 53 -354 146 -320 39
13 62 51 75 119 14 76 7 449 -9 487 -24 59 -71 82 -114 57z"/>
            <path d="M3640 4387 c-55 -28 -80 -127 -80 -323 0 -213 16 -286 72 -327 33
-24 87 -25 128 -1 44 27 70 120 77 274 10 211 -21 350 -82 378 -34 15 -83 15
-115 -1z"/>
            <path d="M5990 4393 c-33 -12 -61 -50 -77 -103 -22 -72 -25 -366 -4 -454 18
-82 53 -116 116 -116 59 0 80 12 104 59 33 63 44 159 39 334 -5 177 -18 230
-66 267 -24 19 -78 25 -112 13z"/>
          </g>
        </svg>
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
