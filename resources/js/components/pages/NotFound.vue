<template>
    <div class="flex items-center justify-center min-h-screen py-48">
        <div class="flex flex-col">
            <!-- Error Container -->
            <div class="flex flex-col items-center">
                <div class="text-indigo-500 font-bold text-7xl">404</div>

                <div
                    class="font-bold text-3xl xl:text-7xl lg:text-6xl md:text-5xl mt-10"
                >
                    This page does not exist
                </div>

                <div
                    class="text-gray-800 font-medium text-sm md:text-xl lg:text-2xl mt-8"
                >
                    The page you are looking for could not be found.
                </div>
                <p class="mt-6 text-sm text-center">
                    <router-link
                        class="text-sm text-blue-500 focus:text-blue-500 hover:text-blue-500 hover:underline"
                        :to="{ name: 'Login' }"
                        ><i class="bi bi-arrow-left-circle-fill"></i> Back to
                        Home</router-link
                    >
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style></style>
