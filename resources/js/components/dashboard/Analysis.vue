<template>
    <div class="container w-full md:w-11/12 xl:w-11/12 mx-auto px-2 my-3">
        <div class="sm:flex items-center justify-between m-4">
            <h1 class="font-bold text-[#510a8b] text-4xl">
                Tasks Analysis as at {{ date }}
            </h1>
        </div>
        <div class="rounded-lg bg-gray-200 text-center p-10">
            <span class="font-semibold"> Tasks Representation</span>
            <div class="m-2 md:flex justify-center text-[#510a8b]">
                <div>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { usePost } from "../composables/post";
import { useGet } from "../composables/get";
import Chart from "chart.js/auto";

export default {
    setup() {
        const { resData: getRes, getData: getData } = useGet();
        const { res: resp, message: msg, postData: postData } = usePost();

        let date = ref([]);
        let tasksCount = ref([]);
        let tasksLabel = ref([]);
        let tasksData = ref([]);

        onMounted(() => {
            setOverdue();
            getDateCur();
            getTasksCount();
        });
        const getDateCur = () => {
            getData("/api/CurrentDate/")
                .then(() => {
                    if (getRes.value) {
                        date.value = getRes.value;
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        };
        const getTasksCount = () => {
            getData("/api/getTasksCount/")
                .then(() => {
                    if (getRes.value) {
                        tasksCount.value = getRes.value;
                        let arr = tasksCount.value.filter((item) => {
                            tasksLabel.value.push(item.status.name);
                            tasksData.value.push(item.totalTasks);
                        });
                    }
                    const ctx = document.getElementById("pieChart");
                    new Chart(ctx, {
                        type: "pie",
                        data: {
                            labels: tasksLabel.value,
                            datasets: [
                                {
                                    label: "Number of Tasks",
                                    data: tasksData.value,
                                    borderWidth: 1,
                                },
                            ],
                        },
                    });
                })
                .catch((e) => {
                    console.log(e);
                });
        };
        const setOverdue = () => {
            getData("/api/setOverdue/")
                .then(() => {
                    if (getRes.value) {
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        };
        return { date };
    },
};
</script>
<style scoped></style>
