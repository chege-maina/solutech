<template>
    <div class="container w-full md:w-11/12 xl:w-11/12 mx-auto px-2 my-3">
        <div class="sm:flex items-center justify-between m-4">
            <h1 class="font-bold text-[#510a8b] text-4xl">
                Assigned Tasks Report
            </h1>
        </div>

        <div
            class="py-4 mt-2 lg:mt-0 rounded-lg overflow-auto md:block shadow bg-gray-100"
        >
            <p
                class="mt-3 text-sm text-[#510a8b] ml-3 font-semibold mb-1 sm:block"
            >
                Filter Report
            </p>
            <div
                class="mt-1 flex items-center justify-start space-x-8 mx-2 text-sm text-[#002c74a9]"
            >
                <select
                    class="p-1 rounded-xl border bg-gray-50 w-auto"
                    v-model="currentUser"
                    @change="searchListUser(currentUser)"
                >
                    <option disabled value="">Filter By User</option>
                    <option
                        v-for="option in usersList"
                        :key="option.id"
                        :value="option.id"
                    >
                        {{ option.name }} - {{ option.email }}
                    </option>
                </select>
                <select
                    class="p-1 rounded-xl border bg-gray-50 w-auto"
                    v-model="currentStatus"
                    @change="searchListStatus(currentStatus)"
                >
                    <option disabled value="">Filter By Status</option>
                    <option
                        v-for="option in statusOptions"
                        :key="option.id"
                        :value="option.id"
                    >
                        {{ option.name }}
                    </option>
                </select>
                <button
                    @click="Reload"
                    class="bg-[#510a8b] rounded-full text-white p-2 hover:scale-105 duration-300 w-16"
                >
                    Reset
                </button>
                <button
                    @click="ViewReport"
                    class="bg-[#510a8b] rounded-full text-white p-2 hover:scale-105 duration-300"
                >
                    Get PDF
                </button>
            </div>
            <div class="flex items-center justify-between my-3 px-7">
                <div
                    class="flex items-center justify-between text-sm text-[#002c74a9]"
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
                <input
                    class="p-1 px-2 rounded-xl border"
                    type="text"
                    name="search"
                    v-model="SearchUser"
                    id="search"
                    placeholder="Search Here..."
                    @keyup="searchClientList"
                />
            </div>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th
                            class="p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            No.
                        </th>
                        <th
                            class="p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            Task
                        </th>
                        <th
                            class="p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            User
                        </th>
                        <th
                            class="p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Start Date
                        </th>
                        <th
                            class="p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Due Date
                        </th>
                        <th
                            class="p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            Remarks
                        </th>
                        <th
                            class="p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Status
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
                            {{ option.task.name }}
                        </td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ option.user.name }}
                        </td>
                        <td
                            class="p-3 text-sm text-gray-700 whitespace-nowrap text-center"
                        >
                            {{ option.task.start_time }}
                        </td>
                        <td
                            class="p-3 text-sm text-gray-700 whitespace-nowrap text-center"
                        >
                            {{ option.task.due_date }}
                        </td>
                        <td class="p-3 text-sm text-gray-700">
                            {{ option.remarks }}
                        </td>
                        <td
                            class="p-3 text-sm text-gray-700 whitespace-nowrap text-center"
                        >
                            <span
                                v-if="option.task.status_id === 1"
                                class="uppercase tracking-wider text-yellow-800 bg-yellow-200 rounded-lg bg-opacity-50 p-1.5 font-medium"
                            >
                                {{ option.task.status.name }}</span
                            >
                            <span
                                v-else-if="option.task.status_id === 2"
                                class="uppercase tracking-wider text-blue-800 bg-blue-200 rounded-lg bg-opacity-50 p-1.5 font-medium"
                            >
                                {{ option.task.status.name }}</span
                            >
                            <span
                                v-else-if="option.task.status_id === 3"
                                class="uppercase tracking-wider text-green-800 bg-green-200 rounded-lg bg-opacity-50 p-1.5 font-medium"
                            >
                                {{ option.task.status.name }}</span
                            >
                            <span
                                v-else
                                class="uppercase tracking-wider text-red-800 bg-red-200 rounded-lg bg-opacity-50 p-1.5 font-medium"
                            >
                                {{ option.task.status.name }}</span
                            >
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
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { usePost } from "../composables/post";
import { useGet } from "../composables/get";

export default {
    setup() {
        const { resData: getRes, getData: getData } = useGet();
        const { res: resp, message: msg, postData: postData } = usePost();

        let currentUser = ref("");
        let currentStatus = ref("");
        let SearchUser = ref("");
        let usersList = ref([]);

        let options = ref([]);
        let showOptions = ref([1, 2, 3, 4, 5, 10, 25, 50, 100]);
        let currentOptions = ref(50);
        let PageRange = ref(5);
        let filteredOptions = ref([]);
        let statusOptions = ref([]);
        let totalRec = ref(0);
        let totalPages = ref(0);
        let Pages = ref([]);
        let ActivePage = ref();
        let SearchItem = ref();
        let FilteredPages = ref([]);
        let firstPosition = ref(0);
        let secondPosition = ref(0);
        onMounted(() => {
            getData("/api/getReport")
                .then(() => {
                    if (getRes.value) {
                        options.value = getRes.value;
                        paginateOptions();
                        console.log(options.value);
                        getData("/api/getUsers").then(() => {
                            if (getRes.value) {
                                usersList.value = getRes.value;
                                paginateOptions();
                                getData("/api/getStatus").then(() => {
                                    if (getRes.value) {
                                        statusOptions.value = getRes.value;
                                    }
                                });
                            }
                        });
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        });
        const searchListUser = (data) => {
            currentStatus.value = "";
            if (data != "" && data) {
                filteredOptions.value = options.value.filter((item) => {
                    if (item.user_id == data) {
                        return item;
                    }
                });
                getRange(options.value, filteredOptions.value);
            } else {
                paginateOptions();
            }
        };
        const searchListStatus = (data) => {
            if (data != "" && data && currentUser.value != "") {
                filteredOptions.value = options.value.filter((item) => {
                    if (
                        item.user_id == currentUser.value &&
                        item.task.status_id == data
                    ) {
                        return item;
                    }
                });
                getRange(options.value, filteredOptions.value);
            } else if (data != "" && data) {
                filteredOptions.value = options.value.filter((item) => {
                    if (item.task.status_id == data) {
                        return item;
                    }
                });
                getRange(options.value, filteredOptions.value);
            } else {
                paginateOptions();
            }
        };
        const paginateOptions = () => {
            filteredOptions.value = options.value.slice(
                0,
                currentOptions.value
            );
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
        const ViewReport = () => {
            if (options.value.length > 0) {
                let formdata = new FormData();
                formdata.append("data", JSON.stringify(options.value));
                axios({
                    url: "/api/viewReport",
                    method: "post",
                    data: formdata,
                    responseType: "blob",
                    headers: {
                        "Content-Type":
                            "application/x-www-form-urlencoded;charset=UTF-8",
                    },
                })
                    .then((response) => {
                        const url = window.URL.createObjectURL(
                            new Blob([response.data])
                        );
                        const link = document.createElement("a");
                        link.href = url;
                        link.setAttribute("download", "Solutech Report.pdf");
                        document.body.appendChild(link);
                        link.click();
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            }
        };
        const Reload = () => {
            location.reload();
        };
        const searchClientList = () => {
            if (SearchUser.value != "" && SearchUser.value) {
                filteredOptions.value = options.value.filter((item) => {
                    if (
                        item.task.name
                            .toUpperCase()
                            .includes(SearchUser.value.toUpperCase()) ||
                        item.user.name
                            .toUpperCase()
                            .includes(SearchUser.value.toUpperCase())
                    ) {
                        return item;
                    }
                });
                getRange(options.value, filteredOptions.value);
            } else {
                paginateOptions();
            }
        };
        return {
            SearchUser,
            searchClientList,
            currentUser,
            currentStatus,
            Reload,
            ViewReport,
            usersList,
            searchListUser,
            searchListStatus,
            SearchItem,
            options,
            statusOptions,
            showOptions,
            currentOptions,
            filteredOptions,
            totalRec,
            totalPages,
            firstPosition,
            secondPosition,
            FilteredPages,
            ActivePage,
            goToPage,
            paginateOptions,
        };
    },
};
</script>
<style scoped></style>
