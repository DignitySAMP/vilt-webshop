export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    two_factor_secret: string | null;
    two_factor_recovery_codes: string | null;
    two_factor_confirmed_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface UserContact {
    id: number;
    user_id: User;
    name: string;
    role: string;
    email: string;
    phone: string;
    created_at: string;
    updated_at: string;
}
export interface UserAddress {
    id: number;
    user_id: User;
    street: string;
    number: string;
    city: string;
    postal: string;
    area: string;
    country: string;
    created_at: string;
    updated_at: string;
}
export interface UserPayment {
    id: number;
    user_id: User;
    name: string;
    type: string;
    identifier: string;
    code: string;
    created_at: string;
    updated_at: string;
}

export interface Order {
    id: number;
    user_id: User;
    status: string;
    created_at: string;
    updated_at: string;
}

export interface OrderItem {
    id: number;
    order_id: Order;
    item_id: Item;
    amount: number;
    price: number; // must be double; TODO: js has a limitation on float/double types; make sure this is infered properly
    created_at: string;
    updated_at: string;
}

export interface ShoppingCart {
    id: number;
    user_id: User;
    order_id: Order;
    created_at: string;
    updated_at: string;
}

export interface OrderPayment {
    id: number;
    order_id: Order;
    method: string;
    amount: number;
    created_at: string;
    updated_at: string;
}

export interface Item {
    id: number;
    item_category_id: number;
    item_category: ItemCategory;
    supplier_id: nunber;
    supplier: Supplier;
    name: string;
    description: string;
    image: string;
    image_url: string;
    price: number; // must be double; TODO: js has a limitation on float/double types; make sure this is infered properly
    stock: number;
    created_at: string;
    updated_at: string;
}

export interface ItemCategory {
    id: number;
    name: string;
    description: string;
    item_count: number;
    created_at: string;
    updated_at: string;
}

export interface Supplier {
    id: number;
    name: string;
    description: string;
    created_at: string;
    updated_at: string;
}

export interface SupplierContacts {
    id: number;
    supplier_id: Supplier;
    name: string;
    role: string;
    email: string;
    phone: string;
    created_at: string;
    updated_at: string;
}
export interface SupplierAddresses {
    id: number;
    supplier_id: Supplier;
    street: string;
    number: string;
    city: string;
    postal: string;
    area: string;
    country: string;
    created_at: string;
    updated_at: string;
}
export interface SupplierOrder {
    id: number;
    supplier_id: Supplier;
    created_at: string;
    updated_at: string;
}
export interface SupplierOrderItems {
    id: number;
    supplier_order_id: SupplierOrder;
    item_id: Item;
    created_at: string;
    updated_at: string;
}
