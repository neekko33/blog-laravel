export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

export interface Post {
    id: number,
    title: string,
    content: string,
    description: string,
    user_id: number,
    category_id: number,
    category: Category,
    tags: Tag[],
    published: boolean,
    created_at: Date,
    updated_at: Date
}

export interface Category {
    id: number,
    name: string,
    created_at: Date,
    updated_at: Date
}

export interface Tag {
    id: number,
    name: string,
    created_at: Date,
    updated_at: Date
}

export interface Link {
    url: string,
    label: string,
    active: boolean
}
