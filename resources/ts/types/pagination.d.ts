export interface LinkProps {
    active: boolean;
    label: string;
    page: number;
    url: string;
}

export interface PaginationData<T = any> {
    current_page: number;
    data: T[];
    first_page_url: string;
    from: number;
    last_page: number;
    links: Array<LinkProps>;
    next_page_url: string;
    path: string;
    prev_page: number;
    prev_page_url: string;
    to: number;
    total: number;
}

// type without the data array for pagination component
export type PaginationMeta = Omit<PaginationData, 'data'> & { data: Array<any> };