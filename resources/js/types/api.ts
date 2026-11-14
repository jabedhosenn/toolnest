export interface ApplicationStatus {
    application: string;
    status: string;
    timestamp: string;
}

export interface ApiResource<T> {
    data: T;
}

export interface ApiResourceCollection<T> {
    data: T[];
    links: {
        first: string | null;
        last: string | null;
        prev: string | null;
        next: string | null;
    };
    meta: {
        current_page: number;
        from: number | null;
        last_page: number;
        path: string;
        per_page: number;
        to: number | null;
        total: number;
    };
}

export interface CategoryDirectoryResource {
    id: number;
    name: string;
    slug: string;
    description: string | null;
    icon: string;
    sort_order: number;
    tools_count?: number;
}

export interface ToolDirectoryResource {
    id: number;
    name: string;
    slug: string;
    description: string;
    icon: string;
    category: CategoryDirectoryResource;
    route_name: string;
    component_identifier: string;
    is_featured: boolean;
    is_popular: boolean;
    is_active: boolean;
    sort_order: number;
    tags: string[];
}

export interface ToolListFilters {
    category?: string;
    featured?: boolean;
    popular?: boolean;
    sort?: 'sort_order' | 'recent' | 'name';
    page?: number;
    per_page?: number;
}
