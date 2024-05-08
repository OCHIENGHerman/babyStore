import { createContext, ReactNode, useState } from 'react'

interface Cart
 {
    id: number;
    user_id: number,
    product_id: number,
    quantity: number,
    created_at: string,
}

export interface CartContextProps {
    cart: Cart | null;
    addToCart: (product: Cart) => void;
    removeFromCart: () => void;
}

export const CartContext = createContext<CartContextProps | undefined>(undefined);

export const CartProvider: React.FC<{ children: ReactNode }> = ({ children }) => {

    const [cart, setCart] = useState<Cart | null>(null);

    const addToCart = (product: Cart) => {
        setCart(product);
    }

    const removeFromCart = () => {
        setCart(null);
    }

    const contextValue: CartContextProps = {
        cart,
        addToCart,
        removeFromCart,
    };

    return <CartContext.Provider value={contextValue}>{children}</CartContext.Provider>
}