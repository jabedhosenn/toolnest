export interface ApplicationStatus {
    application: string;
    status: string;
    timestamp: string;
}

export interface ApiResource<T> {
    data: T;
}
