/** Button variant options */
export type ButtonVariant = 'primary' | 'secondary' | 'ghost' | 'danger';

/** Button size options */
export type ButtonSize = 'sm' | 'md' | 'lg';

/** Badge variant options */
export type BadgeVariant = 'primary' | 'secondary' | 'success' | 'warning' | 'danger' | 'info';

/** Alert variant options */
export type AlertVariant = 'success' | 'warning' | 'danger' | 'info';

/** Toast notification */
export interface ToastMessage {
    id: string;
    variant: AlertVariant;
    title?: string;
    message: string;
    duration?: number;
}

/** Tab item */
export interface TabItem {
    key: string;
    label: string;
    icon?: string;
    disabled?: boolean;
}

/** Pagination metadata */
export interface PaginationMeta {
    currentPage: number;
    lastPage: number;
    perPage: number;
    total: number;
}

/** Breadcrumb item */
export interface BreadcrumbItem {
    label: string;
    to?: string;
    active?: boolean;
}

/** Dropdown menu item */
export interface DropdownMenuItem {
    key: string;
    label: string;
    icon?: string;
    disabled?: boolean;
    danger?: boolean;
    divider?: boolean;
}

/** Select option */
export interface SelectOption {
    value: string | number;
    label: string;
    disabled?: boolean;
}
