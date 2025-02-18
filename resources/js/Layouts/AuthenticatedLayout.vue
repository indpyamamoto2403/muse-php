<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import { getMenus } from '@/Layouts/AuthenticatedLayout.menu';
import { Link } from '@inertiajs/vue3';

// Font Awesome のコンポーネントとアイコンをインポート
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faHome, faUser, faCog, faSignOutAlt } from '@fortawesome/free-solid-svg-icons';

const page: any = usePage();
type Role = 'company' | 'artist';
const role: Role = page.props.auth.user.role;

// getMenus() で返されるメニュー項目にアイコン情報を追加する例
const menus = getMenus(role)
</script>

<template>
  <div class="min-h-screen flex">
    <!-- 左サイドバー -->
    <nav class="w-64 bg-sky-900 text-white flex flex-col border-r-2 border-r-black max-h-screen fixed inset-0">
      <div class="flex-1 overflow-y-auto">
        <div class="mt-6 flex flex-col">
          <NavLink
            v-for="menu in menus"
            :key="menu.name"
            class="hover:bg-sky-800 block"
            :href="menu.route"
          >
            <span class="block px-6 py-3 text-lg flex items-center">
              <!-- Font Awesome のアイコンを表示 -->
              <FontAwesomeIcon :icon="menu.icon" class="mr-2" />
              {{ menu.name }}
            </span>
          </NavLink>
        </div>
      </div>
      <!-- ユーザードロップダウン（今回は Log Out のみ） -->
    <div class="border-t border-sky-800">
        <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="hover:bg-sky-800 w-full text-left px-4 py-4 flex items-center"
        >
            <FontAwesomeIcon :icon="faSignOutAlt" class="mr-2" />
            Log Out
        </Link>
    </div>
    </nav>

    <!-- メインコンテンツエリア -->
    <div class="flex-1 flex flex-col ml-64">
      <!-- ヘッダー（必要に応じて） -->
      <header class="bg-black shadow sticky top-0 z-50" v-if="$slots.header">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 text-slate-200 text-lg">
          <slot name="header" />
        </div>
      </header>
      <!-- ページコンテンツ -->
      <main class="flex-1 p-4 bg-sky-950">
        <slot />
      </main>
    </div>
  </div>
</template>
