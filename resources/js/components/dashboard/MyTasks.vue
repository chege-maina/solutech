<template>
    <div class="container w-full md:w-4/5 xl:w-4/5 mx-auto px-2 my-3 m-3">
        <div class="sm:flex items-center justify-between mb-3">
            <h1
                class="font-bold text-[#510a8b] text-2xl md:text-4xl text-center md:text-left"
            >
                Your Tasks
            </h1>
        </div>
        <div class="m-2 md:flex justify-end hidden text-[#510a8b]">
            <input
                class="p-1 px-2 rounded-xl border"
                type="text"
                name="search"
                id="search"
                v-model="SearchItem"
                placeholder="Search Here..."
                @keyup="searchList"
            />
            <button
                class="hover:bg-[#510a8b] rounded-full hover:text-white py-1 px-2 hover:scale-105 duration-300 mx-1"
                data-bs-toggle="tooltip"
                title="Prev"
                @click="prevPage"
            >
                <i class="bi bi-caret-left-fill"></i>Prev
            </button>
            <button
                class="hover:bg-[#510a8b] rounded-full hover:text-white py-1 px-2 hover:scale-105 duration-300 mx-1"
                data-bs-toggle="tooltip"
                title="Next"
                @click="nextPage"
            >
                Next<i class="bi bi-caret-right-fill"></i>
            </button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            <div
                class="max-w-full overflow-hidden shadow-md bg-gray-200 rounded-lg"
                v-for="task in filteredTasks"
                :key="task.id"
            >
                <div>
                    <div>
                        <div class="flex border-b-2 border-[#510a8b]">
                            <div
                                class="p-2 text-base h-auto w-full font-semibold text-gray-800 hover:text-gray-600 text-center"
                            >
                                {{ task.task.name }}
                            </div>
                        </div>
                        <div
                            class="p-2 text-sm text-gray-600 text-left h-52 border-b-2 border-[#510a8b]"
                        >
                            <span class="font-semibold">Due Date:</span>
                            {{ task.task.due_date }}
                            <div
                                class="flex text-xs my-2 items-center justify-start"
                            >
                                <span class="mr-4"
                                    ><span class="font-semibold"
                                        >Starting Time:</span
                                    >
                                    {{ task.task.start_time }}</span
                                >
                            </div>
                            <span class="font-semibold">Task Description:</span>
                            {{ task.task.description }}
                        </div>
                        <div
                            class="p-2 text-sm text-left h-auto border-b-2 border-[#510a8b]"
                        >
                            <span class="font-semibold text-gray-600"
                                >Task Status:</span
                            >
                            {{ task.task.status.name }}
                        </div>
                        <div class="p-2 text-sm text-left h-16">
                            <span class="font-semibold text-gray-600"
                                >Task Remarks:</span
                            >
                            {{ task.remarks }}
                        </div>
                    </div>

                    <div
                        class="pt-2 flex items-center justify-between text-sm md:text-base font-semibold w-full"
                    >
                        <button
                            class="rounded-bl-lg py-2 px-4 w-full"
                            @click="setComplete(task)"
                            :disabled="task.task.status_id != 2"
                            :class="[
                                task.task.status_id == 2
                                    ? 'text-[#510a8b] hover:border hover:border-[#510a8b] duration-300'
                                    : 'bg-[#808080] text-white',
                            ]"
                        >
                            Complete Task
                        </button>
                        <button
                            class="rounded-br-lg py-2 px-4 w-full"
                            @click="setRemarks(task)"
                            :disabled="task.task.status_id != 2"
                            :class="[
                                task.task.status_id == 2
                                    ? 'text-[#510a8b] hover:border hover:border-[#510a8b] duration-300'
                                    : 'bg-[#808080] text-white',
                            ]"
                        >
                            Edit Remarks
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Modal @close="toggleModal" :modalActive="modalActive" :heading="heading">
        <p
            class="text-[#9A031E] font-bold text-xs px-4 mt-2 text-center"
            v-if="error"
        >
            {{ error }}
        </p>
        <div class="my-8 px-4" v-if="heading === 'Complete Task'">
            <div class="grid grid-cols-1 gap-4">
                <p>
                    <span class="text-[#510a8b] font-semibold"
                        >{{ modalData }}
                    </span>
                </p>
            </div>
            <div
                class="sm:flex items-right justify-end m-2 border-t p-2 sm:space-x-2"
            >
                <button
                    class="bg-[#510a8b] rounded-full text-white py-2 px-4 hover:scale-105 duration-300 mt-3 sm:mt-0 sm:w-auto w-full"
                    @click="completeTask"
                    type="submit"
                >
                    Submit
                </button>
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from "../../components/includes/Modal.vue";
import { ref, onMounted, reactive } from "vue";
import { useStore } from "vuex";
import { usePost } from "../composables/post";
import { useGet } from "../composables/get";

export default {
    components: { Modal },
    setup() {
        const { resData: getRes, getData: getData } = useGet();
        const { res: resp, message: msg, postData: postData } = usePost();

        let initialState = {
            id: "",
            remarks: "",
        };
        const form = reactive({ ...initialState });
        const store = useStore();
        let error = ref("");
        let SearchItem = ref();
        let lstTasks = ref([]);
        let filteredTasks = ref([]);
        const modalActive = ref(false);
        const heading = ref();
        let modalData = ref("");
        let taskId = ref("");

        onMounted(() => {
            getData("/api/userTasks/" + store.getters.user.id)
                .then(() => {
                    if (getRes.value) {
                        lstTasks.value = getRes.value;
                        setPage(0, 3);
                    }
                })
                .catch((e) => {
                    error.value = e;
                    console.log(e);
                });
        });
        const toggleModal = () => {
            modalActive.value = !modalActive.value;
            clearForm();
        };
        const setHeading = (headSet) => {
            heading.value = headSet;
        };
        const clearForm = () => {
            Object.assign(form, initialState);
            error.value = null;
        };
        const setPage = (first, last) => {
            filteredTasks.value = lstTasks.value.slice(first, last);
        };
        const prevPage = () => {
            let itemArr = filteredTasks.value[0];
            let ind = lstTasks.value.findIndex((item) => {
                return item.id == itemArr.id;
            });
            if (ind != 0) {
                setPage(ind - 3, ind);
                filteredTasks.value = lstTasks.value.slice(ind - 3, ind);
            }
        };
        const nextPage = () => {
            let length = filteredTasks.value.length;
            if (length == 3) {
                let itemArr = filteredTasks.value[2];
                let ind = lstTasks.value.findIndex((item) => {
                    return item.id == itemArr.id;
                });
                let lstIndex = lstTasks.value.length - 1;
                if (ind != lstIndex) {
                    setPage(ind + 1, ind + 4);
                }
            }
        };
        const searchList = () => {
            if (SearchItem.value != "" && SearchItem.value) {
                filteredTasks.value = lstTasks.value.filter((item) => {
                    if (
                        item.task.name
                            .toUpperCase()
                            .includes(SearchItem.value.toUpperCase())
                    ) {
                        return item;
                    }
                });
            } else {
                setPage(0, 3);
            }
        };
        const setComplete = (option) => {
            taskId.value = option.task.id;
            modalData.value =
                "Are you sure you want to complete task " +
                option.task.name +
                "?";
            setHeading("Complete Task");
            toggleModal();
        };
        const setRemarks = (option) => {};
        const completeTask = () => {
            postData("/api/completeTask/" + taskId.value)
                .then(() => {
                    if (resp.value) {
                        location.reload();
                        toggleModal();
                    }
                })
                .catch((e) => {
                    error.value = e;
                });
        };

        return {
            modalData,
            SearchItem,
            modalActive,
            heading,
            error,
            filteredTasks,
            nextPage,
            prevPage,
            searchList,
            toggleModal,
            completeTask,
            setComplete,
            setRemarks,
        };
    },
};
</script>
