import axios from 'axios';

let headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
}

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    headers['Authorization'] = `Bearer ${token.content}`;
}   else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const httpClient = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    timeout: 10000,
    headers: headers,
    withCredentials: true,
});

export default httpClient;
