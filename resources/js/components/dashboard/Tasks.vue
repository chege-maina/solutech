<template>
    <div class="container w-full md:w-11/12 xl:w-11/12 mx-auto px-2 my-3">
        <div class="sm:flex items-center justify-between m-9 mb-0">
            <h1 class="font-bold text-[#510a8b] text-4xl">Tasks List</h1>
            <button
                class="bg-[#510a8b] rounded-full text-white py-2 px-4 hover:scale-105 duration-300 my-3 sm:mt-0 sm:w-auto w-full"
                @click="toggleModal(), setHeading('Add New Task')"
            >
                Add New Task
            </button>
        </div>
        <p class="mt-3 text-sm text-[#510a8b] m-9 hidden sm:block"></p>
        <div
            class="py-4 mt-2 lg:mt-0 rounded-lg overflow-auto hidden md:block shadow bg-gray-100"
        >
            <div class="flex items-center justify-between my-3 px-7">
                <div
                    class="relative flex items-center justify-between text-sm text-[#002c74a9]"
                >
                    <span class="mr-1">Show</span>
                    <select
                        v-model="currentOptions"
                        class="p-1 rounded-xl border bg-gray-50 text-center"
                        @change="paginateOptions"
                    >
                        <option
                            v-for="option in showOptions"
                            :key="option"
                            :value="option"
                        >
                            {{ option }}
                        </option>
                    </select>
                    <span class="ml-1">entries</span>
                </div>
                <div class="relative flex items-center justify-between text-sm">
                    <input
                        class="p-1 px-2 rounded-xl border w-full"
                        type="text"
                        name="search"
                        v-model="SearchItem"
                        id="search"
                        placeholder="Search Here..."
                        @keyup="searchList"
                    />
                </div>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th
                            class="w-20 p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            No.
                        </th>
                        <th
                            class="p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            Name
                        </th>
                        <th
                            class="w-64 p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            Description
                        </th>
                        <th
                            class="w-32 p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            Due Date
                        </th>
                        <th
                            class="w-20 p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Start Time
                        </th>
                        <th
                            class="w-20 p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            End Time
                        </th>
                        <th
                            class="w-20 p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Status
                        </th>
                        <th
                            class="w-20 p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Assign
                        </th>
                        <th
                            class="w-20 p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Edit
                        </th>
                        <th
                            class="w-20 p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Delete
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr
                        v-for="(option, index) in filteredOptions"
                        :key="option.id"
                        :class="{
                            'bg-gray-100': (1 + index) % 2 === 0,
                            'bg-gray-50': (1 + index) % 2 !== 0,
                        }"
                    >
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ 1 + index }}
                        </td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ option.name }}
                        </td>
                        <td class="p-3 text-sm text-gray-700 w-64">
                            {{ option.description }}
                        </td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ option.due_date }}
                        </td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ option.start_time }}
                        </td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ option.end_time }}
                        </td>
                        <td
                            class="p-3 text-sm text-gray-700 whitespace-nowrap text-center"
                        >
                            <span
                                v-if="option.status_id === 1"
                                class="uppercase tracking-wider text-yellow-800 bg-yellow-200 rounded-lg bg-opacity-50 p-1.5 font-medium"
                            >
                                {{ option.status.name }}</span
                            >
                            <span
                                v-else-if="option.status_id === 2"
                                class="uppercase tracking-wider text-blue-800 bg-blue-200 rounded-lg bg-opacity-50 p-1.5 font-medium"
                            >
                                {{ option.status.name }}</span
                            >
                            <span
                                v-else-if="option.status_id === 3"
                                class="uppercase tracking-wider text-green-800 bg-green-200 rounded-lg bg-opacity-50 p-1.5 font-medium"
                            >
                                {{ option.status.name }}</span
                            >
                            <span
                                v-else
                                class="uppercase tracking-wider text-red-800 bg-red-200 rounded-lg bg-opacity-50 p-1.5 font-medium"
                            >
                                {{ option.status.name }}</span
                            >
                        </td>
                        <td
                            class="p-3 text-xl text-red-700 whitespace-nowrap text-center"
                            data-bs-toggle="tooltip"
                            title="Assign"
                            v-if="option.status_id < 2"
                            @click="
                                toggleModal(),
                                    setHeading('Assign Task To User');
                                setStatus(option);
                            "
                        >
                            <i
                                class="bi bi-dash-circle-fill cursor-pointer"
                            ></i>
                        </td>
                        <td
                            class="p-3 text-xl text-green-700 whitespace-nowrap text-center"
                            data-bs-toggle="tooltip"
                            title="Done"
                            v-else
                        >
                            <i
                                class="bi bi-check-circle-fill cursor-pointer"
                            ></i>
                        </td>
                        <td
                            class="p-3 text-[#002D74] text-xl whitespace-nowrap text-center"
                        >
                            <i
                                class="bi bi-pencil-square cursor-pointer"
                                @click="
                                    toggleModal(),
                                        setHeading('Edit Task'),
                                        setEdit(option)
                                "
                            ></i>
                        </td>

                        <td
                            class="p-3 text-red-700 text-xl whitespace-nowrap text-center"
                        >
                            <i
                                class="bi bi-trash-fill cursor-pointer"
                                @click="
                                    option.status_id > 1
                                        ? null
                                        : [
                                              toggleModal(),
                                              setHeading('Delete Task'),
                                              setDelete(option.id, option.name),
                                          ]
                                "
                                :class="[
                                    option.status_id > 1
                                        ? 'text-[#504e4e]'
                                        : '',
                                ]"
                            ></i>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="flex items-center justify-between my-3 px-7">
                <div
                    class="relative flex items-center justify-between text-sm text-[#002c74a9]"
                >
                    <span class="mr-1">Showing</span>
                    <span class="mr-1">{{ firstPosition }}</span>
                    <span class="mr-1">to</span>
                    <span class="mr-1">{{ secondPosition }}</span>
                    <span class="mr-1">of</span>
                    <span>{{ totalRec }}</span>
                    <span class="ml-1">entries</span>
                </div>
                <div
                    class="relative flex items-center justify-between text-sm text-[#002c74a9]"
                >
                    <span class="mr-1">Total Pages</span>
                    <span class="mr-1">{{ totalPages }}</span>
                </div>
                <div
                    class="relative flex items-center justify-between text-sm text-[#002c74a9]"
                >
                    <button
                        class="hover:bg-[#002D74] rounded-full hover:text-white py-1 px-2 hover:scale-105 duration-300 mx-1"
                        data-bs-toggle="tooltip"
                        title="First"
                        @click="goToPage(1)"
                    >
                        <i class="bi bi-caret-left-fill"></i>
                    </button>
                    <div v-for="page in FilteredPages" :key="page">
                        <button
                            class="hover:bg-[#002D74] rounded-full hover:text-white py-1 px-2 hover:scale-105 duration-300 mx-1"
                            @click="goToPage(page)"
                            :class="{
                                'bg-[#002D74] text-white': page == ActivePage,
                            }"
                        >
                            {{ page }}
                        </button>
                    </div>
                    <button
                        class="hover:bg-[#002D74] rounded-full hover:text-white py-1 px-2 hover:scale-105 duration-300 mx-1"
                        data-bs-toggle="tooltip"
                        title="Last"
                        @click="goToPage(totalPages)"
                    >
                        <i class="bi bi-caret-right-fill"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:hidden">
            <input
                class="p-1 px-2 rounded-xl border w-full"
                type="text"
                name="search"
                v-model="SearchItem"
                placeholder="Search Here..."
                @keyup="searchMobiList"
            />
            <div
                class="bg-white p-4 rounded-lg shadow text-sm"
                v-for="(option, index) in filteredMobiOptions"
                :key="option.id"
            >
                <div>No. {{ 1 + index }}</div>
                <div>{{ option.name }}</div>
                <div>{{ option.description }}</div>
                <div>{{ option.due_date }}</div>
                <div>{{ option.start_time }}</div>
                <div>{{ option.end_time }}</div>
                <div>{{ option.status.name }}</div>
                <div class="flex items-center space-x-2 justify-end w-full">
                    <div class="text-[#002D74] text-xl px-1 cursor-pointer">
                        <i
                            class="bi bi-pencil-square"
                            @click="
                                toggleModal(),
                                    setHeading('Edit Task'),
                                    setEdit(option)
                            "
                        ></i>
                    </div>
                    <div
                        class="text-red-500 text-xl px-1 cursor-pointer"
                        @click="
                            toggleModal(), setHeading('Assign Task To User');
                            setStatus(option);
                        "
                        v-if="option.status_id < 2"
                    >
                        <i class="bi bi-dash-circle-fill"></i>
                    </div>
                    <div
                        class="text-green-500 text-xl px-1 cursor-pointer"
                        v-else
                    >
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="text-[#9A031E] text-xl px-1 cursor-pointer">
                        <i
                            class="bi bi-trash-fill"
                            :class="
                                option.status_id > 1 ? 'text-[#504e4e]' : ''
                            "
                            @click="
                                option.status_id > 1
                                    ? null
                                    : [
                                          toggleModal(),
                                          setHeading('Delete Task'),
                                          setDelete(option.id, option.name),
                                      ]
                            "
                        ></i>
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

        <div class="my-8 px-4" v-if="heading === 'Delete Task'">
            <div class="grid grid-cols-1 gap-4">
                <p>
                    Are You Sure You Want To Remove
                    <span class="text-[#9A031E] font-semibold"
                        >{{ modalData }}
                    </span>
                    Completely from the System?
                </p>
            </div>
            <div
                class="sm:flex items-right justify-end m-2 border-t p-2 sm:space-x-2"
            >
                <button
                    class="bg-[#9A031E] rounded-full text-white py-2 px-4 hover:scale-105 duration-300 mt-3 sm:mt-0 sm:w-auto w-full"
                    @click="deleteTask"
                    type="submit"
                >
                    Delete
                </button>
            </div>
        </div>
        <form
            class="my-8 px-4"
            @submit.prevent="assign"
            v-else-if="heading === 'Assign Task To User'"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <select
                    v-model="taskAssign.user_id"
                    class="block w-auto px-4 py-2 my-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                    required
                    @change="setUser()"
                >
                    <option disabled value="">Please select User</option>
                    <option
                        v-for="option in userOptions"
                        :key="option.id"
                        :value="option.id"
                    >
                        {{ option.name }} - {{ option.email }}
                    </option>
                </select>
                <textarea
                    class="block w-full h-full px-4 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                    maxlength="100"
                    v-model="taskAssign.remarks"
                    placeholder="Remarks (Max-100 characters)"
                    required
                >
                </textarea>
            </div>
            {{ taskAssign }}
            <div
                class="sm:flex items-right justify-end m-2 border-t p-2 sm:space-x-2"
            >
                <button
                    class="rounded-full text-[#510a8b] py-2 px-4 hover:border hover:border-[#510a8b] duration-300 mt-3 sm:mt-0 sm:w-auto w-full"
                    @click="clearForm"
                    :disabled="!buttonsActive"
                    :class="[
                        buttonsActive
                            ? ''
                            : 'bg-[#808080] text-white hover:bg-[#808080]',
                    ]"
                >
                    Clear
                </button>
                <button
                    class="bg-[#510a8b] rounded-full text-white py-2 px-4 hover:scale-105 duration-300 mt-3 sm:mt-0 sm:w-auto w-full"
                    type="submit"
                    :disabled="!buttonsActive"
                    :class="[
                        buttonsActive
                            ? ''
                            : 'bg-[#808080] text-white hover:bg-[#808080]',
                    ]"
                >
                    Save
                </button>
            </div>
        </form>

        <form class="my-8 px-4" @submit.prevent="addTask" v-else>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <input
                    class="block w-full h-auto px-4 py-2 my-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                    type="text"
                    name="name"
                    v-model="form.name"
                    id="name"
                    placeholder="Name"
                    required
                />
                <div class="flex">
                    <label
                        for="due_date"
                        class="text-sm text-[#310058] py-2 my-2 block w-32"
                        >Due Date:</label
                    >
                    <input
                        class="block w-full px-4 py-2 my-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                        type="datetime-local"
                        name="due_date"
                        v-model="form.due_date"
                        id="due_date"
                        placeholder="Due Date"
                        required
                    />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div class="flex">
                    <label
                        for="start_time"
                        class="text-sm text-[#310058] py-2 my-2 block w-32"
                        >Start Time:</label
                    >
                    <input
                        class="block w-full px-4 py-2 my-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                        type="datetime-local"
                        name="start_time"
                        v-model="form.start_time"
                        id="start_time"
                        placeholder="Start Time"
                        required
                    />
                </div>
                <div class="flex">
                    <label
                        for="end_time"
                        class="text-sm text-[#310058] py-2 my-2 block w-32"
                        >End Time:</label
                    >
                    <input
                        class="block w-full px-4 py-2 my-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                        type="datetime-local"
                        name="end_time"
                        v-model="form.end_time"
                        id="end_time"
                        placeholder="End Time"
                        required
                    />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-2">
                <textarea
                    class="block w-full h-full px-4 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                    maxlength="255"
                    v-model="form.description"
                    placeholder="Description (Max-255 characters)"
                    required
                >
                </textarea>
            </div>
            <div
                class="sm:flex items-right justify-end m-2 border-t p-2 sm:space-x-2"
            >
                <button
                    class="rounded-full text-[#510a8b] py-2 px-4 hover:border hover:border-[#510a8b] duration-300 mt-3 sm:mt-0 sm:w-auto w-full"
                    @click="clearForm"
                    :disabled="!buttonsActive"
                    :class="[
                        buttonsActive
                            ? ''
                            : 'bg-[#808080] text-white hover:bg-[#808080]',
                    ]"
                >
                    Clear
                </button>
                <button
                    class="bg-[#510a8b] rounded-full text-white py-2 px-4 hover:scale-105 duration-300 mt-3 sm:mt-0 sm:w-auto w-full"
                    type="submit"
                    :disabled="!buttonsActive"
                    :class="[
                        buttonsActive
                            ? ''
                            : 'bg-[#808080] text-white hover:bg-[#808080]',
                    ]"
                >
                    Save
                </button>
            </div>
        </form>
    </Modal>
</template>

<script>
import Modal from "../../components/includes/Modal.vue";
import { ref, onMounted, reactive } from "vue";
import { usePost } from "../composables/post";
import { useGet } from "../composables/get";

export default {
    components: { Modal },
    setup() {
        const { resData: getRes, getData: getData } = useGet();
        const { res: resp, message: msg, postData: postData } = usePost();

        const modalActive = ref(false);
        const buttonsActive = ref(true);
        const heading = ref();
        let initialState = {
            id: "",
            name: "",
            description: "",
            due_date: "",
            start_time: "",
            end_time: "",
            status_id: 1,
        };
        const form = reactive({ ...initialState });
        let error = ref("");
        let modalData = ref("");
        let taskId = ref();
        let options = ref([]);
        let userOptions = ref([]);
        let showOptions = ref([1, 2, 3, 4, 5, 10, 25, 50, 100]);
        let currentOptions = ref(10);
        let PageRange = ref(5);
        let filteredOptions = ref([]);
        let filteredMobiOptions = ref([]);
        let assignInit = {
            task_id: "",
            remarks: "",
            user_id: "",
            email: "",
            userName: "",
            due_date: "",
            start_time: "",
        };
        let taskAssign = reactive({ ...assignInit });
        let totalRec = ref(0);
        let totalPages = ref(0);
        let Pages = ref([]);
        let ActivePage = ref();
        let SearchItem = ref();
        let FilteredPages = ref([]);
        let firstPosition = ref(0);
        let secondPosition = ref(0);
        onMounted(() => {
            getData("/api/getTasks")
                .then(() => {
                    if (getRes.value) {
                        options.value = getRes.value;
                        paginateOptions();
                        getData("/api/getUsers").then(() => {
                            if (getRes.value) {
                                userOptions.value = getRes.value;
                            }
                        });
                    }
                })
                .catch((e) => {
                    error.value = e;
                    console.log(e);
                });
        });

        const toggleModal = () => {
            if (buttonsActive.value) {
                modalActive.value = !modalActive.value;
                buttonsActive.value = true;
                clearForm();
            }
        };
        const clearForm = () => {
            Object.assign(form, initialState);
            taskAssign.remarks = "";
            taskAssign.user_id = "";
            error.value = null;
        };
        const setHeading = (headSet) => {
            heading.value = headSet;
        };
        const setEdit = (option) => {
            form.name = option.name;
            form.description = option.description;
            form.due_date = option.due_date;
            form.start_time = option.start_time;
            form.end_time = option.end_time;
            form.status_id = option.status_id;
            form.id = option.id;
        };
        const setDelete = (d_id, d_name) => {
            taskId.value = d_id;
            modalData.value = d_name;
        };
        const searchList = () => {
            if (SearchItem.value != "" && SearchItem.value) {
                filteredOptions.value = options.value.filter((item) => {
                    if (item.name.includes(SearchItem.value)) {
                        return item;
                    }
                });
                getRange(options.value, filteredOptions.value);
            } else {
                paginateOptions();
            }
        };
        const searchMobiList = () => {
            if (SearchItem.value != "" && SearchItem.value) {
                filteredMobiOptions.value = options.value.filter((item) => {
                    if (item.name.includes(SearchItem.value)) {
                        return item;
                    }
                });
                getRange(options.value, filteredMobiOptions.value);
            } else {
                paginateOptions();
            }
        };
        const paginateOptions = () => {
            filteredOptions.value = options.value.slice(
                0,
                currentOptions.value
            );
            filteredMobiOptions.value = options.value;
            totalRec.value = options.value.length;
            totalPages.value = totalRec.value % currentOptions.value;
            totalPages.value =
                totalPages.value == 0
                    ? totalRec.value / currentOptions.value
                    : Math.trunc(totalRec.value / currentOptions.value + 1);
            getRange(options.value, filteredOptions.value);

            Pages.value = [];
            for (var i = 1; i <= totalPages.value; i++) {
                Pages.value.push(i);
            }
            FilteredPages.value = Pages.value.slice(0, PageRange.value);
            ActivePage.value = 1;
        };
        const getRange = (mainData, secData) => {
            var first = secData.slice(0, 1);
            var second = secData.slice(
                currentOptions.value - 1,
                currentOptions.value
            );

            firstPosition.value = mainData.indexOf(first[0]) + 1;
            secondPosition.value = mainData.indexOf(second[0]) + 1;

            if (currentOptions.value > secData.length) {
                secondPosition.value = totalRec.value;
            }
        };
        const goToPage = (page) => {
            if (page <= Math.round(PageRange.value / 2)) {
                FilteredPages.value = Pages.value.slice(0, PageRange.value);
            } else {
                let range = Math.trunc(PageRange.value / 2);
                FilteredPages.value = Pages.value.slice(
                    page - range - 1,
                    page + range
                );
            }

            let lastRange = currentOptions.value * page;
            let firstRange = lastRange - currentOptions.value;

            filteredOptions.value = options.value.slice(firstRange, lastRange);
            getRange(options.value, filteredOptions.value);
            ActivePage.value = page;
        };
        const setStatus = (option) => {
            taskAssign.task_id = option.id;
            taskAssign.due_date = option.due_date;
            taskAssign.start_time = option.start_time;
        };
        const setUser = () => {
            let arr = userOptions.value.filter((item) => {
                if (item.id == taskAssign.user_id) {
                    taskAssign.userName = item.name;
                    taskAssign.email = item.email;
                }
            });
        };
        const deleteTask = () => {
            postData("/api/deleteTask/" + taskId.value)
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
        const assign = () => {
            buttonsActive.value = false;
            postData("/api/assignTask", taskAssign)
                .then(() => {
                    if (resp.value) {
                        location.reload();
                        toggleModal();
                    } else {
                        buttonsActive.value = true;
                        error.value = msg.value;
                    }
                })
                .catch((e) => {
                    buttonsActive.value = true;
                    error.value = e;
                });
        };
        const addTask = () => {
            buttonsActive.value = false;
            let url = "";
            if (heading.value === "Add New Task") {
                url = "addTask";
            } else {
                url = "editTask";
            }
            postData("/api/" + url, form)
                .then(() => {
                    if (resp.value) {
                        location.reload();
                        toggleModal();
                    } else {
                        buttonsActive.value = true;
                        error.value = msg.value;
                    }
                })
                .catch((e) => {
                    buttonsActive.value = true;
                    error.value = e;
                });
        };

        return {
            SearchItem,
            options,
            userOptions,
            showOptions,
            currentOptions,
            filteredOptions,
            filteredMobiOptions,
            error,
            modalData,
            taskAssign,
            modalActive,
            buttonsActive,
            totalRec,
            totalPages,
            firstPosition,
            secondPosition,
            FilteredPages,
            ActivePage,
            searchList,
            searchMobiList,
            goToPage,
            paginateOptions,
            toggleModal,
            setEdit,
            deleteTask,
            setDelete,
            setStatus,
            setHeading,
            addTask,
            clearForm,
            heading,
            form,
            setUser,
            assign,
        };
    },
};
</script>
<style scoped></style>
