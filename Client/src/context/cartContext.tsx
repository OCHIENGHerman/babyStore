import { createContext, ReactNode, useState } from 'react'
import { getCartItemsByUserIdUrl } from '../Components/urls';

interface  CartItems{
    user_id: number;
    product_id: number;
    quantity: number;
}

interface Cart{
    id: number;
    user_id: number;
    product_id: number;
    name: string,
    image_url: string,
    price: number,
    quantity: number;
    created_at: string | null;
    updated_at: string | null;
}

export interface CartContextProps {
    cartItems: CartItems | null;
    cart: Cart[] | null;
    addItemsToCart: (newCartItems:CartItems) => void;
    removeItemsFromCart: () => void;
    getCartItemsByUserId: (userId: number) => void;
}

export const CartContext = createContext<CartContextProps | undefined>(undefined);

export const CartProvider: React.FC<{ children: ReactNode }> = ({ children }) => {

    const [cartItems, setCartItems] = useState<CartItems | null>(null);
    const [cart, setCart] = useState<Cart[] | null>(null);
    
    const addItemsToCart = (newCartItems:CartItems) => {
        setCartItems(newCartItems);

        console.log("Item set successfully:", newCartItems);
    };

    const removeItemsFromCart = () => {
        setCartItems(null);

    };

    const getCartItemsByUserId = async (userId: number) => {
        try {
            const response = await fetch(`${getCartItemsByUserIdUrl.replace('{userId}', userId.toString())}`);
            const data = await response.json();
            console.log("Cart items:", data);
            setCart(data);
        } catch (error) {
            console.error('Error fetching cart items:', error);
        }
    };


    const contextValue: CartContextProps = {
        cartItems,
        cart,
        addItemsToCart,
        removeItemsFromCart,
        getCartItemsByUserId
    };

    return <CartContext.Provider value={contextValue}>{children}</CartContext.Provider>
}