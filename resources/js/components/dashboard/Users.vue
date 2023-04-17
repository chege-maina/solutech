<template>
    <div class="container w-full md:w-4/5 xl:w-4/5 mx-auto px-2 my-3">
        <div class="sm:flex items-center justify-between m-9 mb-0">
            <h1 class="font-bold text-[#510a8b] text-4xl">Users List</h1>
            <button
                class="bg-[#510a8b] rounded-full text-white py-2 px-4 hover:scale-105 duration-300 my-3 sm:mt-0 sm:w-auto w-full"
                @click="toggleModal(), setHeading('Add New User')"
            >
                Add New User
            </button>
        </div>
        <p class="mt-3 text-sm text-[#510a8b] m-9 hidden sm:block">
            Users are people who can sign into this application. View and manage
            App Members here.
        </p>
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
                            class="p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            Email
                        </th>
                        <th
                            class="w-32 p-3 text-sm font-semibold tracking-wide text-left"
                        >
                            User Role
                        </th>
                        <th
                            class="w-20 p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Edit
                        </th>
                        <th
                            class="w-20 p-3 text-sm font-semibold tracking-wide text-center"
                        >
                            Status
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
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ option.email }}
                        </td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ option.roles.role }}
                        </td>
                        <td
                            class="p-3 text-[#002D74] text-xl whitespace-nowrap text-center"
                        >
                            <i
                                class="bi bi-pencil-square cursor-pointer"
                                @click="
                                    toggleModal(),
                                        setHeading('Edit User'),
                                        setEdit(
                                            option.email,
                                            option.name,
                                            option.roles.id,
                                            option.id
                                        )
                                "
                            ></i>
                        </td>
                        <td
                            class="p-3 text-xl text-red-700 whitespace-nowrap text-center"
                            data-bs-toggle="tooltip"
                            title="Activate"
                            v-if="option.status < 2"
                            @click="
                                toggleModal(), setHeading('Change Status');
                                setStatus(
                                    option.id,
                                    option.status,
                                    option.name
                                );
                            "
                        >
                            <i
                                class="bi bi-dash-circle-fill cursor-pointer"
                            ></i>
                        </td>
                        <td
                            class="p-3 text-xl text-green-700 whitespace-nowrap text-center"
                            data-bs-toggle="tooltip"
                            title="Disable"
                            v-else
                            @click="
                                toggleModal(), setHeading('Change Status');
                                setStatus(
                                    option.id,
                                    option.status,
                                    option.name
                                );
                            "
                        >
                            <i
                                class="bi bi-check-circle-fill cursor-pointer"
                            ></i>
                        </td>
                        <td
                            class="p-3 text-red-700 text-xl whitespace-nowrap text-center"
                        >
                            <i
                                class="bi bi-trash-fill cursor-pointer"
                                @click="
                                    option.status > 0
                                        ? null
                                        : [
                                              toggleModal(),
                                              setHeading('Delete User'),
                                              setDelete(option.id, option.name),
                                          ]
                                "
                                :class="[
                                    option.status > 0 ? 'text-[#504e4e]' : '',
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
                <div>{{ option.email }}</div>
                <div>{{ option.name }}</div>
                <div>{{ option.roles.role }}</div>
                <div class="flex items-center space-x-2 justify-end w-full">
                    <div class="text-[#002D74] text-xl px-1 cursor-pointer">
                        <i
                            class="bi bi-pencil-square"
                            @click="
                                toggleModal(),
                                    setHeading('Edit User'),
                                    setEdit(
                                        option.email,
                                        option.name,
                                        option.roles.id,
                                        option.id,
                                        option.phone
                                    )
                            "
                        ></i>
                    </div>
                    <div
                        class="text-red-500 text-xl px-1 cursor-pointer"
                        @click="
                            toggleModal(), setHeading('Change Status');
                            setStatus(option.id, option.status, option.name);
                        "
                        v-if="option.status < 2"
                    >
                        <i class="bi bi-dash-circle-fill"></i>
                    </div>
                    <div
                        class="text-green-500 text-xl px-1 cursor-pointer"
                        @click="
                            toggleModal(), setHeading('Change Status');
                            setStatus(option.id, option.status, option.name);
                        "
                        v-else
                    >
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="text-[#9A031E] text-xl px-1 cursor-pointer">
                        <i
                            class="bi bi-trash-fill"
                            :class="option.status > 0 ? 'text-[#504e4e]' : ''"
                            @click="
                                option.status > 0
                                    ? null
                                    : [
                                          toggleModal(),
                                          setHeading('Delete User'),
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

        <div class="my-8 px-4" v-if="heading === 'Delete User'">
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
                    @click="deleteUsr"
                    type="submit"
                >
                    Delete
                </button>
            </div>
        </div>
        <div class="my-8 px-4" v-else-if="heading === 'Change Status'">
            <div class="grid grid-cols-1 gap-4">
                <p>
                    Are You Sure You Want To
                    <span
                        v-if="userstatus < 2"
                        class="text-green-500 font-semibold"
                    >
                        Activate {{ modalData }}</span
                    ><span v-else class="text-[#9A031E] font-semibold">
                        Deactivate {{ modalData }}</span
                    >?
                </p>
            </div>
            <div
                class="sm:flex items-right justify-end m-2 border-t p-2 sm:space-x-2"
            >
                <button
                    class="rounded-full text-white py-2 px-4 hover:scale-105 duration-300 mt-3 sm:mt-0 sm:w-auto w-full"
                    @click="statusUsr"
                    type="submit"
                    :class="{
                        'bg-[#9A031E]': userstatus > 1,
                        'bg-green-500': userstatus < 2,
                    }"
                >
                    Okay
                </button>
            </div>
        </div>

        <form class="my-8 px-4" @submit.prevent="register" v-else>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <input
                    class="block w-full px-4 py-2 my-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                    type="email"
                    name="email"
                    id="email"
                    v-model="form.email"
                    placeholder="Email"
                    required
                />
                <input
                    class="block w-full px-4 py-2 my-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                    type="text"
                    name="name"
                    v-model="form.name"
                    id="name"
                    placeholder="Name"
                    required
                />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <select
                    v-model="form.role_id"
                    class="block w-full px-4 py-2 my-2 rounded-lg placeholder-gray-600 bg-gray-900 text-gray-300 border-gray-700 focus:border-[#310058] focus:ring-[#310058] focus:outline-none focus:ring focus:ring-opacity-40"
                    required
                >
                    <option disabled value="">Please select User Type</option>
                    <option
                        v-for="option in roleOptions"
                        :key="option.id"
                        :value="option.id"
                    >
                        {{ option.role }}
                    </option>
                </select>
            </div>
            <div
                class="sm:flex items-right justify-end m-2 border-t p-2 sm:space-x-2"
            >
                <button
                    class="rounded-full text-[#510a8b] py-2 px-4 hover:border hover:border-[#510a8b] duration-300 mt-3 sm:mt-0 sm:w-auto w-full"
                    @click="clearForm"
                    :disabled="!buttonsActive"
                >
                    Clear
                </button>
                <button
                    class="bg-[#510a8b] rounded-full text-white py-2 px-4 hover:scale-105 duration-300 mt-3 sm:mt-0 sm:w-auto w-full"
                    type="submit"
                    :disabled="!buttonsActive"
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

export default {
    components: { Modal },
    setup() {
        const modalActive = ref(false);
        const buttonsActive = ref(true);
        const heading = ref();
        let initialState = {
            id: "",
            name: "",
            email: "",
            role_id: "",
            phone: "",
        };
        const form = reactive({ ...initialState });
        let error = ref("");
        let modalData = ref("");
        let userid = ref();
        let userstatus = ref();
        let options = ref([]);
        let showOptions = ref([1, 2, 3, 4, 5, 10, 25, 50, 100]);
        let currentOptions = ref(10);
        let PageRange = ref(5);
        let filteredOptions = ref([]);
        let filteredMobiOptions = ref([]);
        let userStat = { id: "", status: "" };
        let roleOptions = ref([]);
        let totalRec = ref(0);
        let totalPages = ref(0);
        let Pages = ref([]);
        let ActivePage = ref();
        let SearchItem = ref();
        let FilteredPages = ref([]);
        let firstPosition = ref(0);
        let secondPosition = ref(0);
        let phoneSuffix = ref("");
        onMounted(() => {
            axios
                .get("/api/getUsers")
                .then((res) => {
                    if (res.data.user) {
                        options.value = res.data.user;
                        paginateOptions();
                    }
                })
                .catch((e) => {
                    error.value = e.res.data.message;
                });
            axios
                .get("/api/getRoles")
                .then((res) => {
                    if (res.data.roles) {
                        roleOptions.value = res.data.roles;
                    }
                })
                .catch((e) => {
                    error.value = e.res.data.message;
                });
        });

        const toggleModal = () => {
            modalActive.value = !modalActive.value;
            buttonsActive.value = true;
            clearForm();
        };
        const clearForm = () => {
            Object.assign(form, initialState);
            error.value = null;
        };
        const setHeading = (headSet) => {
            heading.value = headSet;
        };
        const setEdit = (e_email, e_name, e_role, e_id, e_phone) => {
            form.email = e_email;
            form.name = e_name;
            form.role_id = e_role;
            form.id = e_id;
            form.phone = e_phone;
        };
        const setDelete = (d_id, d_name) => {
            userid.value = d_id;
            modalData.value = d_name;
        };
        const searchList = () => {
            if (SearchItem.value != "" && SearchItem.value) {
                filteredOptions.value = options.value.filter((item) => {
                    if (
                        item.name.includes(SearchItem.value) ||
                        item.email.includes(SearchItem.value) ||
                        item.roles.role.includes(SearchItem.value)
                    ) {
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
                    if (
                        item.name.includes(SearchItem.value) ||
                        item.email.includes(SearchItem.value) ||
                        item.roles.role.includes(SearchItem.value)
                    ) {
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
        const setStatus = (d_id, d_status, d_name) => {
            userid.value = d_id;
            userstatus.value = d_status;
            modalData.value = d_name;
        };
        const deleteUsr = async () => {
            await axios

                .post("/api/delete/" + userid.value)
                .then((res) => {
                    if (res.data.success) {
                        location.reload();
                        toggleModal();
                    }
                })
                .catch((e) => {
                    error.value = e.response.data.message;
                });
        };
        const statusUsr = async () => {
            if (userstatus.value === 0) {
                error.value = "You Cannot Change New User Status";
            } else {
                if (userstatus.value == 2) {
                    userStat.status = 1;
                } else {
                    userStat.status = 2;
                }
                userStat.id = userid.value;
                await axios
                    .post("/api/statusUsr", userStat)
                    .then((res) => {
                        if (res.data.success) {
                            location.reload();
                            toggleModal();
                        }
                    })
                    .catch((e) => {
                        error.value = e.response.data.message;
                    });
            }
        };
        const register = async () => {
            buttonsActive.value = false;
            let url = "";
            if (heading.value === "Add New User") {
                url = "register";
            } else {
                url = "edit";
            }

            await axios
                .post("/api/" + url, form)
                .then((res) => {
                    if (res.data.success) {
                        location.reload();
                        toggleModal();
                    }
                })
                .catch((e) => {
                    buttonsActive.value = true;
                    error.value = e.response.data.message;
                });
        };

        return {
            SearchItem,
            options,
            roleOptions,
            showOptions,
            currentOptions,
            filteredOptions,
            filteredMobiOptions,
            error,
            modalData,
            userstatus,
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
            deleteUsr,
            statusUsr,
            setDelete,
            setStatus,
            setHeading,
            register,
            clearForm,
            heading,
            form,
            phoneSuffix,
        };
    },
};
</script>
<style scoped></style>
