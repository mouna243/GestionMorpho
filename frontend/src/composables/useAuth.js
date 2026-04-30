import { computed } from 'vue';
import { useRouter } from 'vue-router';

export function useAuth() {
    const router = useRouter();

    const isLoggedIn = computed(() => !!localStorage.getItem('token'));
    const user = computed(() => JSON.parse(localStorage.getItem('user') || 'null'));

    function logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.removeItem('role');
        localStorage.removeItem('department');
        router.push('/login');
    }

    return { isLoggedIn, user, logout };
}
