<template>
    <div class="py-3.5 px-6 shadow md:flex justify-between items-center">
        <div class="flex items-center cursor-pointer text-[#002D74]">
            <span class="text-4xl mr-1">
                <img
                    class="h-11 w-28"
                    src="../../components/assets/logo.png"
                    alt=""
                />
            </span>
        </div>
        <span
            class="absolute md:hidden right-6 top-1.5 cursor-pointer text-4xl"
            @click="openMenu()"
        >
            <i :class="[open ? 'bi bi-x' : 'bi bi-filter-left']"></i
        ></span>
        <ul
            class="md:flex md:items-center md:px-0 px-3 md:pb-0 pb-10 md:static absolute md:w-auto w-full top-14 duration-700 ease-in text-[#310058] bg-gray-50 md:bg-inherit"
            :class="[open ? 'left-0' : 'left-[-100%]']"
        >
            <li class="md:mx-4 md:my-0 my-6">
                <div
                    @click="setMenu('analysis'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Dashboard' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >Analysis</router-link
                    >
                </div>
            </li>
            <li
                class="md:mx-4 md:my-0 my-6"
                v-if="$store.getters.user.role < 2"
            >
                <div
                    @click="setMenu('tasks'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Dashboard' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >Tasks</router-link
                    >
                </div>
            </li>
            <li class="md:mx-4 md:my-0 my-6">
                <div
                    @click="setMenu('my tasks'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Dashboard' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >My Tasks</router-link
                    >
                </div>
            </li>
            <li
                class="md:mx-4 md:my-0 my-6"
                v-if="$store.getters.user.role < 2"
            >
                <div
                    @click="setMenu('users'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Dashboard' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >Users</router-link
                    >
                </div>
            </li>
            <li
                class="md:mx-4 md:my-0 my-6"
                v-if="$store.getters.user.role < 2"
            >
                <div
                    @click="setMenu('report'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Dashboard' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >Report</router-link
                    >
                </div>
            </li>
            <Menu as="div" class="relative mx-4 my-6 md:my-0">
                <MenuButton
                    class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#310058] rounded-full"
                    ><img
                        class="h-10 w-10 inline rounded-full"
                        src="../../components/assets/avatar.png"
                        alt=""
                /></MenuButton>
                <transition
                    enter-active-class="transition transform duration-100 ease-out"
                    enter-from-class="opacity-0 scale-90"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition transform duration-100 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-90"
                >
                    <MenuItems
                        class="origin-top-right absolute right-0 bg-[#310058] rounded-md shadow-lg border w-full md:w-64 py-1 items-center text-center"
                    >
                        <MenuItem>
                            <div
                                class="px-4 py-1 text-lg font-semibold text-gray-400 capitalize"
                            >
                                UserName:
                            </div>
                        </MenuItem>
                        <MenuItem>
                            <div
                                class="px-4 py-1 text-base font-bold text-gray-400 capitalize"
                            >
                                {{ $store.getters.user.name }}
                            </div>
                        </MenuItem>
                        <MenuItem>
                            <button
                                class="bg-red-400 text-white duration-500 py-2 mx-4 my-1 hover:bg-red-500 rounded w-40"
                                @click="logout"
                            >
                                Logout
                            </button>
                        </MenuItem>
                    </MenuItems>
                </transition>
            </Menu>
        </ul>
    </div>
</template>
<script>
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import { ref } from "vue";
export default {
    components: { Menu, MenuButton, MenuItems, MenuItem },
    setup() {
        const router = useRouter();
        const store = useStore();
        let open = ref(false);
        function logout() {
            router.push({ name: "Login" });
            store.dispatch("removeToken");
        }
        function setMenu(menu) {
            store.dispatch("dashMenus", menu);
        }
        function openMenu() {
            open.value = !open.value;
        }
        function closeMenu() {
            open.value = false;
        }
        return {
            logout,
            setMenu,
            open,
            openMenu,
            closeMenu,
        };
    },
};
</script>
