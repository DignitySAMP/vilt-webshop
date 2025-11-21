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
    user_id: number;
    user?: User | null;
    name: string;
    role: string;
    email: string;
    phone: string;
    created_at: string;
    updated_at: string;
}
export interface UserAddress {
    id: number;
    user_id: number;
    user?: User | null;
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
    user_id: number;
    user?: User | null;
    name: string;
    type: string;
    identifier: string;
    code: string;
    created_at: string;
    updated_at: string;
}

export interface Order {
    id: number;
    user_id: number;
    user?: User | null;
    status: string;
    created_at: string;
    updated_at: string;
}

export interface OrderItem {
    id: number;
    order_id: number;
    order?: Order | null;
    item_id: number;
    item?: Item | null;
    amount: number;
    price: number; // must be double; TODO: js has a limitation on float/double types; make sure this is infered properly
    created_at: string;
    updated_at: string;
}

export interface ShoppingCart {
    id: number;
    user_id: number;
    user?: User | null;
    order_id: number;
    order?: Order | null;
    created_at: string;
    updated_at: string;
}

export interface OrderPayment {
    id: number;
    order_id: number;
    order?: Order | null;
    method: string;
    amount: number;
    created_at: string;
    updated_at: string;
}

export interface Item {
    id: number;
    item_category_id: number;
    item_category?: ItemCategory | null;
    supplier_id: number;
    supplier?: Supplier | null;
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
    pending_orders: number;
    orders?: SupplierOrder | null;
    contacts?: SupplierContacts | null;
    addresses?: SupplierAddresses | null;

    created_at: string;
    updated_at: string;
}

export interface SupplierContacts {
    id: number;
    supplier_id: number;
    supplier?: Supplier | null;
    name: string;
    role: string;
    email: string;
    phone: string;
    created_at: string;
    updated_at: string;
}
export interface SupplierAddresses {
    id: number;
    supplier_id: number;
    supplier?: Supplier | null;
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
    supplier_id: number;
    supplier?: Supplier | null;
    status: "pending" | "processing" | "completed";
    created_at: string;
    updated_at: string;
}
export interface SupplierOrderItems {
    id: number;
    supplier_order_id: number;
    supplier_order?: SupplierOrder | null;
    item_id: number;
    item?: Item | null;
    created_at: string;
    updated_at: string;
}

interface ShoppingCart {
    id: number;
    user_id: number;
    created_at: string;
    updated_at: string;
    items: ShoppingCartItem[];
}

interface ShoppingCartItem {
    id: number;
    shopping_cart_id: number;
    item_id: number;
    quantity: number;
    created_at: string;
    updated_at: string;
    item: Item;
}
