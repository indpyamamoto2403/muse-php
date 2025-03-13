<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import { getMenus } from '@/Layouts/AuthenticatedLayout.menu';
import { Link } from '@inertiajs/vue3';

// Font Awesome のコンポーネントとアイコンをインポート
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const page: any = usePage();
type Role = 'company' | 'artist';
const role: Role = page.props.auth.user.role;


// getMenus() で返されるメニュー項目にアイコン情報を追加する例
const menus = getMenus(role);
</script>

<template>
  <div class="min-h-screen flex">
    <!-- 左サイドバー -->
    <nav class="w-64 bg-gradient-to-b from-sky-900 to-indigo-900 text-white flex flex-col border-r border-purple-900/30 max-h-screen fixed inset-0 shadow-lg">
      <!-- ロゴエリア -->
      <div class="p-4 border-b border-sky-800/50 flex items-center justify-center">
        <span class="font-bold text-xl text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Muse</span>
      </div>
      
      <div class="flex-1 overflow-y-auto custom-scrollbar">
        <div class="mt-6 flex flex-col space-y-1">
          <NavLink
            v-for="menu in menus"
            :key="menu.name"
            class="hover:bg-sky-800/50 rounded-md mx-2 transition-all duration-200"
            :href="menu.route"
          >
            <span class="block px-4 py-3 text-base flex items-center">
              <!-- Font Awesome のアイコンを表示 -->
              <FontAwesomeIcon :icon="menu.icon || faPalette" class="mr-3 text-indigo-300" />
              {{ menu.name }}
            </span>
          </NavLink>
        </div>
      </div>
      
      <!-- ユーザードロップダウン -->
      <div class="border-t border-sky-800/50 mt-auto">
        <Link
          :href="route('logout')"
          method="post"
          as="button"
          class="w-full text-left px-6 py-4 flex items-center hover:bg-sky-800/50 transition-colors duration-200"
        >
          <FontAwesomeIcon :icon="faSignOutAlt" class="mr-3 text-red-300" />
          Log Out
        </Link>
      </div>
    </nav>

    <!-- メインコンテンツエリア -->
    <div class="flex-1 flex flex-col ml-64">
      <!-- ヘッダー -->
      <header class="bg-gradient-to-r from-sky-950 to-indigo-950 shadow-md sticky top-0 z-50" v-if="$slots.header">
        <div class="mx-auto px-6 py-4 sm:px-6 lg:px-8 text-slate-200 text-lg flex justify-between items-center">
          <slot name="header" />
          
          <!-- ユーザープロフィール表示 -->
          <div class="flex items-center">
            <div class="relative">
              <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 p-0.5">
                <img 
                  :src="page.props.auth.user.icon_url" 
                  alt="User Profile Photo" 
                  class="rounded-full h-full w-full object-cover border-2 border-transparent" 
                />
              </div>
            </div>
            <div class="ml-3">
              <span class="text-white font-medium">{{ page.props.auth.user.name }}</span>
              <div v-if="page.props.auth.user.role === 'admin'" class="text-yellow-400 text-xs font-semibold">Admin</div>
              <div v-else-if="page.props.auth.user.role === 'artist'" class="text-purple-400 text-xs font-semibold">Artist</div>
              <div v-else class="text-blue-400 text-xs font-semibold">Client</div>
            </div>
          </div>
        </div>
      </header>
      
      <!-- ページコンテンツ -->
      <main class="flex-1 bg-gradient-to-br from-sky-950 to-indigo-950 min-h-screen">
        <div class="relative py-6 px-6 lg:px-[150px]">
          <!-- 装飾的な背景要素 (オリジナルの空間感を残しつつ、モダン要素を追加) -->
          <div class="absolute inset-0 overflow-hidden opacity-5 z-0">
            <div class="absolute top-20 right-20 h-64 w-64 rounded-full bg-purple-500 blur-3xl"></div>
            <div class="absolute bottom-20 left-20 h-64 w-64 rounded-full bg-indigo-500 blur-3xl"></div>
          </div>
          
          <!-- コンテンツ -->
          <div class="relative z-10 w-full">
            <slot />
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<style scoped>
/* カスタムスクロールバースタイル */
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background-color: rgba(0, 0, 0, 0.1);
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(219, 39, 119, 0.3);
  border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: rgba(219, 39, 119, 0.5);
}
</style>
