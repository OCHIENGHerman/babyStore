import { createContext, ReactNode, useState } from 'react'

interface  CartItems{
    user_id: number;
    product_id: number;
    quantity: number;
}

export interface CartContextProps {
    cartItems: CartItems | null;
    addItemsToCart: (newCartItems:CartItems) => void;
    removeItemsFromCart: () => void;
}

export const CartContext = createContext<CartContextProps | undefined>(undefined);

export const CartProvider: React.FC<{ children: ReactNode }> = ({ children }) => {

    const [cartItems, setCartItems] = useState<CartItems | null>(null);
    
    const addItemsToCart = (newCartItems:CartItems) => {
        setCartItems(newCartItems);

        console.log("Item set successfully:", newCartItems);
    };

    const removeItemsFromCart = () => {
        setCartItems(null);

    };


    const contextValue: CartContextProps = {
        cartItems,
        addItemsToCart,
        removeItemsFromCart,
    };

    return <CartContext.Provider value={contextValue}>{children}</CartContext.Provider>
}