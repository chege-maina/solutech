import { ref } from "vue";

export function useGet() {

    const resData = ref(null);
    const getData = async (url) => {
        await axios.get(url).then((resp) => {
            if (resp.data.data) {
                resData.value = resp.data.data;
            }
        });

    }

    return { getData, resData }
}