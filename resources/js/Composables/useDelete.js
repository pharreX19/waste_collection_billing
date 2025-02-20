import { ref } from "vue";
import { route } from "ziggy-js";
import { router } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

export function useDelete() {
    const isDeleting = ref(false);
    const error = ref(null);

    const deleteRecord = async (url, parameter) => {
        if (!url) {
            console.error("URL is required for deletion");
            return;
        }

        isDeleting.value = true;
        error.value = null;

        router.delete(route(url, parameter), {
            onSuccess: () => {
                toast.success("އެދިލެއްވި ރެކޯރޑް ސިސްޓަމުން ފުހެލެވިއްޖެ");
            },
            onError: () => {
                toast.error(
                    "ސިސްޓަމުން ރެކޯރޑް ފުހެލުމުގައި މައްސަލައެއް ދިމާވެއްޖެ"
                );
            },
        });
    };

    return {
        isDeleting,
        error,
        deleteRecord,
    };
}
