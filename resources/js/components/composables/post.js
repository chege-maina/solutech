import { ref } from "vue";

export function usePost() {
    const res = ref(null);
    const message = ref(null);
    const resData = ref(null);
    const postData = async (url, data) => {
        await axios.post(url, data).then((resp) => {
            if (resp.data.success) {
                res.value = resp.data.success;
                resData.value = resp.data.data;
                message.value = resp.data.message;
            } else {
                message.value = resp.data.message;
            }
        });

    }

    return { res, message, postData, resData }
}