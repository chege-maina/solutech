<template>
    <!--Modal Backdrop-->
    <transition name="backdrop-transition">
        <div
            class="h-screen w-full fixed left-0 top-0 flex justify-center bg-black bg-opacity-50 overflow-y-auto"
            v-show="modalActive"
        >
            <!--Modal-->
            <transition name="modal-transition">
                <div
                    class="bg-gradient-to-tl from-[#b985ca] to-[#e6d4a5] rounded-lg shadow-lg w-fit h-fit m-4 md:m-0"
                    v-show="modalActive"
                >
                    <div
                        class="flex items-center justify-between border-b p-2 mx-4"
                    >
                        <h1 class="font-bold text-[#510a8b] text-2xl">
                            {{ heading }}
                        </h1>
                        <span
                            class="text-3xl text-[#510a8b] cursor-pointer hover:text-[#9A031E] ml-5"
                            @click="close"
                        >
                            <i class="bi bi-x-circle-fill"></i>
                        </span>
                    </div>

                    <!--Modal Content-->
                    <slot />
                </div>
            </transition>
        </div>
    </transition>
</template>
<script>
export default {
    props: ["modalActive", "heading"],
    setup(props, { emit }) {
        const close = () => {
            emit("close");
        };
        return { close };
    },
};
</script>

<style></style>
