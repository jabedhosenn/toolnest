import http from '@/services/http';
import type { ApiResource, ApplicationStatus } from '@/types/api';

export async function fetchApplicationStatus(): Promise<ApplicationStatus> {
    const response = await http.get<ApiResource<ApplicationStatus>>('/api/v1/status');

    return response.data.data;
}
