import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

export function useUserRole() {
    const page = usePage();
    const roleId = computed(() => page.props.auth?.user?.role_id);

    return {
        isAdmin: computed(() => roleId.value === 1), // Admin
        isOfficer: computed(() => roleId.value === 2), // Officer
        isUser: computed(() => roleId.value === 3), // User
    };
}
