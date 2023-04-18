<template>
    <div>
        <div class="flex justify-center h-screen">
            <div class="hidden bg-cover lg:block lg:w-2/3 loginBG">
                <div
                    class="flex items-center h-full px-20 bg-[#310058] bg-opacity-40"
                >
                    <div>
                        <h2 class="text-2xl font-bold text-white sm:text-3xl">
                            Welcome to Solutech Task Manager
                        </h2>

                        <p class="max-w-xl mt-3 text-gray-300">
                            Lorem ipsum dolor, sit amet consectetur adipisicing
                            elit. Voluptatibus necessitatibus voluptates, quae
                            quis iste sequi. Nisi repellendus voluptatum, fuga
                            soluta error culpa, aliquam totam velit facere
                            dolorem omnis, delectus nobis!
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

                        <p class="mt-3 text-[#310058]">Change Password</p>
                    </div>

                    <div class="mt-8">
                        <p
                            class="text-red-700 font-bold text-xs mt-4 text-center"
                            v-if="error"
                        >
                            {{ error }}
                        </p>
                        <p
                            class="text-green-700 font-bold text-xs mt-4 text-center"
                            v-if="success"
                        >
                            {{ success }}
                        </p>
                        <form @submit.prevent="changePassword">
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
                                <button
                                    :disabled="!buttonsActive"
                                    type="submit"
                                    class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-[#310058] rounded-lg hover:bg-[#300058b6] focus:outline-none focus:bg-[#300058b6] focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                                    :class="[
                                        buttonsActive
                                            ? ''
                                            : 'bg-[#808080] text-white hover:bg-[#808080]',
                                    ]"
                                >
                                    Send Password Link
                                </button>
                            </div>
                        </form>

                        <p class="mt-6 text-sm text-center">
                            <router-link
                                class="text-sm text-blue-500 focus:text-blue-500 hover:text-blue-500 hover:underline"
                                :to="
                                    !buttonsActive
                                        ? { name: 'ForgotPass' }
                                        : { name: 'Login' }
                                "
                                ><i class="bi bi-arrow-left-circle-fill"></i>
                                Back to Sign in?</router-link
                            >
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { usePost } from "../composables/post";
export default {
    setup() {
        let email = "";
        const buttonsActive = ref(true);
        let error = ref("");
        let success = ref("");
        const router = useRouter();
        const { res: resp, message: msg, postData: postData } = usePost();
        let form = reactive({
            email: "",
        });

        const changePassword = () => {
            buttonsActive.value = false;

            postData("/api/forgotpsw", form).then(() => {
                if (resp.value) {
                    error.value = "";
                    success.value = msg.value;
                    close();
                } else {
                    error.value = msg.value;
                    buttonsActive.value = true;
                }
            });
        };

        const close = () => {
            setTimeout(() => {
                router.push({ name: "Login" });
            }, 4 * 1000);
        };

        return {
            email,
            error,
            success,
            form,
            changePassword,
            buttonsActive,
        };
    },
};
</script>
<style scoped>
.loginBG {
    background-image: url("../assets/login.png");
}
</style>
