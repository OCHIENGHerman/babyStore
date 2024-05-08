import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { productsUrl, addToCartUrl } from './urls';
import axios from 'axios';
import { useUser } from '../hooks/useUser';
import { useCart } from '../hooks/useCart';

interface Product {
  id: number;
  name: string;
  description: string;
  image_url: string;
  price: number;
  quantity: number;
  category: number;
  created_at: string | null;
  updated_at: string | null;
}

const Products: React.FC = () => {
  const { user } = useUser();
  const { addItemsToCart } = useCart();

  const [products, setProducts] = useState<Product[]>([]);

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await fetch(productsUrl);
        const data = await response.json();
        setProducts(data);
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    };

    fetchProducts();
  }, []);

  const addToCart = async (product: Product) => {
    try {
      if (!user) {
        console.log('User not logged in');
        return;
      }

      console.log('User ID:', user?.id);

      await axios.post(addToCartUrl, {
        user_id: user?.id,
        product_id: product.id,
        quantity: 1,
      });

      addItemsToCart({
        user_id: user?.id,
        product_id: product.id,
        quantity: 1,
      });
    } catch (error) {
      console.error('Error adding product to cart:', error);
    }
  };

  return (
    <div className="flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <h1 className="text-4xl font-bold mb-8">Products</h1>
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        {products.map((product) => (
          <div key={product.id} className="relative bg-white shadow-md rounded-lg overflow-hidden cursor-pointer">
            <Link to={`/product/${product.id}`}>
              <div className="relative h-64">
                <img
                  src={product.image_url}
                  alt={product.name}
                  className="w-full h-full object-cover"
                />
              </div>
              <div className="p-6">
                <h2 className="text-xl font-bold mb-2">{product.name}</h2>
                <div className="flex items-center justify-between">
                  <p className="text-lg font-bold">${product.price}</p>
                  {/* <p className="text-gray-600">Quantity: {product.quantity}</p> */}
                </div>
                <p className="text-gray-600 mt-2">Category: {product.category}</p>
              </div>
            </Link>
            <div className='pt-6'>
            <button onClick={() => addToCart(product)} className="absolute bottom-2 left-2 right-2 bg-cyan-700 text-white px-2 py-1 rounded-lg transition-colors duration-300 hover:bg-cyan-800 active:scale-95">Add to Cart
            </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

export default Products;
