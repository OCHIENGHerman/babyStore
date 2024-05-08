import { useContext } from "react";
import { CartContext, CartContextProps } from "../context/cartContext";
export const useCart = (): CartContextProps => {
    const context = useContext(CartContext);

    if (!context) {
        throw new Error('useCart must be used within an CartProvider')
    }

    return context
};