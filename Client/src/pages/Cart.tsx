
import React from 'react';
import { useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useCart } from '../hooks/useCart';

const Cart: React.FC = () => {
  const { cart, getCartItemsByUserId } = useCart();

  useEffect(() => {
    getCartItemsByUserId(16);
  }, [getCartItemsByUserId]);

  return (
    <div className="min-h-screen bg-base-200 flex justify-center items-center">
      <div className="container mx-auto py-8">
        <div className="card bg-base-100">
          <div className="card-body">
            {cart && cart.length === 0 ? (
                <div className="grid h-20 card place-items-center">
                  <p>Your cart is empty.</p>
                </div>
            ): (
              <div className="">
                  <h1 className="text-3xl font-bold mb-4">Cart</h1>
                  <div className="divider"></div>
                    {cart && cart.map((item) => (
                      <div key={item.id} className="">
                        <div className="flex items-center">
                          <div className="ml-10">
                            <img src={item.image_url} alt={item.name} className="w-20 h-20 object-cover mr-4 pb-3" />
                            <button className="btn btn-ghost text-2xl text-blue-300 mr-4">Remove</button>
                          </div>
                          <div className="ml-40">
                            <h2 className="text-lg font-bold">{item.name}</h2>
                          </div>
                          <div className="ml-40">
                            <p className="font-bold text-xl">Price: ${item.price}</p>
                            <p className="text-xl">Quantity: {item.quantity}</p>
                          </div>
                        </div>
                      </div>
                    ))}
              </div>
            )}
          </div>  
        </div>
        
        {cart && cart.length === 0 ? (
          <p>Your cart is empty.</p>
          ) : (
          <div style={{ width: '50%', textAlign: 'center' }}>
            
            
            <div className="flex justify-end mt-4">
              <Link
                to="/checkout"
                className="bg-cyan-700 text-white px-4 py-2 rounded-md hover:bg-cyan-800 transition-colors duration-300"
              >
                Proceed to Checkout
              </Link>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default Cart;