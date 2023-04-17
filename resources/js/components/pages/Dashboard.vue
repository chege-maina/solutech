<template>
    <div class="h-screen">
        <Nav />
        <div>
            <div v-if="warningZone">
                <p class="text-red-700 text-center">
                    You are About to be logged out coz of Inactivity
                </p>
            </div>
            <div v-if="$store.getters.menu === 'users'"><Users /></div>
        </div>
    </div>
</template>

<script>
import Nav from "../../components/includes/Nav.vue";
import Users from "../../components/dashboard/Users.vue";

import { onMounted, ref, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
export default {
    components: {
        Nav,
        Users,
    },
    setup() {
        const router = useRouter();
        const store = useStore();

        let warningTimer = ref(null);
        let logoutTimer = ref(null);
        let warningZone = ref(false);
        const events = ["click", "mousemove", "scroll", "keypress", "load"];

        onMounted(() => {
            events.forEach((event) => {
                window.addEventListener(event, resetTimer);
            });
            setTimers();
        });
        onUnmounted(() => {
            events.forEach((event) => {
                window.removeEventListener(event, resetTimer);
            });
            clearTimeout(warningTimer);
            clearTimeout(logoutTimer);
        });
        const setTimers = () => {
            warningTimer = setTimeout(() => {
                warningMessage();
            }, 14 * 60 * 1000); // 15 minutes----> 15 * 60 * 1000
            logoutTimer = setTimeout(() => {
                logout();
            }, 15 * 60 * 1000);
            warningZone.value = false;
        };
        const warningMessage = () => {
            warningZone.value = true;
        };
        const logout = () => {
            router.push({ name: "Login" });
            store.dispatch("removeToken");
        };
        const resetTimer = () => {
            clearTimeout(warningTimer);
            clearTimeout(logoutTimer);
            setTimers();
        };
        function setMenu(menu) {
            store.dispatch("dashMenus", menu);
        }
        return {
            warningZone,
            setMenu,
        };
    },
};
</script>

<style></style>
