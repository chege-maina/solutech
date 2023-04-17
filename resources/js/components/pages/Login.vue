<template>
    <div>
        <div class="flex justify-center h-screen">
            <div class="hidden bg-cover lg:block lg:w-2/3 loginBG">
                <div
                    class="flex items-center h-full px-20 bg-[#310058] bg-opacity-60"
                >
                    <div>
                        <h2 class="text-2xl font-bold text-white sm:text-3xl">
                            Welcome to Solutech Task Manager
                        </h2>

                        <p class="max-w-xl mt-3 text-gray-300">
                            Lorem ipsum dolor sit amet consectetur, adipisicing
                            elit. Mollitia atque velit repellendus unde expedita
                            rem saepe nulla, consequatur aut quisquam fugiat! Ut
                            reiciendis aliquam quam, laboriosam ea facilis
                            molestiae magni.
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6"
            >
                <div class="flex-1">
                    <div class="text-center">
                        <div class="flex justify-center mx-auto">
                            <img
                                class="w-auto h-24"
                                src="../../components/assets/logo.png"
                                alt=""
                            />
                        </div>

                        <p class="mt-3 text-[#310058]">
                            Sign in to access your account
                        </p>
                    </div>

                    <div class="mt-8">
                        <p
                            class="text-red-700 font-bold text-xs mb-4 text-center"
                            v-if="error"
                        >
                            {{ error }}
                        </p>
                        <form @submit.prevent="login">
                            <div>
                                <label
                                    for="email"
                                    class="block mb-2 text-sm text-[#310058]"
                                    >Email Address</label
                                >
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    v-model="form.email"
                                    placeholder="Your Email"
                                    required
                                    class="block w-full px-4 py-2 mt-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                                />
                            </div>

                            <div class="mt-6">
                                <div class="flex justify-between mb-2">
                                    <label
                                        for="password"
                                        class="text-sm text-[#310058]"
                                        >Password</label
                                    >
                                </div>
                                <div class="relative">
                                    <input
                                        name="password"
                                        id="password"
                                        placeholder="Your Password"
                                        required
                                        v-model="form.password"
                                        :type="[passView ? 'text' : 'password']"
                                        class="block w-full px-4 py-2 mt-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                                    />
                                    <svg
                                        v-if="passView"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="gray"
                                        class="bi bi-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"
                                        viewBox="0 0 16 16"
                                        @click="togglePass"
                                    >
                                        <path
                                            d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"
                                        />
                                        <path
                                            d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"
                                        />
                                        <path
                                            d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"
                                        />
                                    </svg>

                                    <svg
                                        v-else
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="gray"
                                        class="bi bi-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"
                                        viewBox="0 0 16 16"
                                        @click="togglePass"
                                    >
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"
                                        />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button
                                    type="submit"
                                    class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-[#310058] rounded-lg hover:bg-[#300058b6] focus:outline-none focus:bg-[#300058b6] focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                                >
                                    Sign in
                                </button>
                            </div>
                        </form>

                        <p class="mt-4 text-sm text-center">
                            <router-link
                                class="text-sm text-blue-500 focus:text-blue-500 hover:text-blue-500 hover:underline"
                                :to="{ name: 'ForgotPass' }"
                                >Forgot password?</router-link
                            >
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
export default {
    setup() {
        const router = useRouter();
        const store = useStore();
        let passView = ref(false);
        let form = reactive({
            email: "",
            password: "",
        });
        let error = ref("");

        const login = async () => {
            await axios.post("/api/login", form).then((resp) => {
                if (resp.data.success) {
                    store.dispatch("setUser", resp.data.data);
                    if (store.getters.user.role == 6) {
                        store.dispatch("dashMenus", "schedule");
                    } else {
                        store.dispatch("dashMenus", "courses");
                    }
                    router.push({ name: "Dashboard" });
                } else {
                    error.value = resp.data.message;
                }
            });
        };

        const togglePass = () => {
            passView.value = !passView.value;
        };
        return { form, passView, login, togglePass, error };
    },
};
</script>
<style scoped>
.loginBG {
    background-image: url("../assets/login.png");
}
</style>
