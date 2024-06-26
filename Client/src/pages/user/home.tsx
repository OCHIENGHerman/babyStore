import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { getProductsUrl } from '../../url';

interface Product {
    id: number;
    name: string;
    description: string;
    image_url: string;
    price: number;
    quantity: number;
    category_id: number;
    created_at: string | null;
    updated_at: string | null;
}
const Homepage: React.FC = () => {
    const [products, setProducts] = useState<Product[]>([]);

    useEffect(() => {
        const fetchProducts = async () => {
            try {
                const response = await axios.get<Product[]>(getProductsUrl);
                setProducts(response.data);
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        };

        fetchProducts();
    }, []);
   
    return (
        <div>
            <h1>Products</h1>
            <ul>
                {products.map((product) => (
                    <li key={product.id}>
                        <h3>{product.name}</h3>
                        <p>{product.description}</p>
                        <p>Price: ${product.price}</p>
                        <img src={product.image_url} alt={product.name} />
                    </li>
                ))}
            </ul>
        </div>
    )
}

export default Homepage;