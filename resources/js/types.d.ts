export interface Todo {
    todo_id: number;
    created_at: string;
    updated_at: string;
    title: string;
    completed: 0 | 1;
    user_id: string | null;
    user: null | Record<string, any>;
}
//# sourceMappingURL=types.d.ts.map