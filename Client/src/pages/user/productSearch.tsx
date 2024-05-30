import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useSearchParams, useNavigate } from 'react-router-dom';
import { searchProducts } from '../../url';

interface Product {
    id: number;
    name: string;
    description: string;
    image_url: string;
    price: number;
    quantity: number;
    category_id: number;
}

const ProductSearch: React.FC = () => {
    const [searchResults, setSearchResults] = useState<Product[]>([]);
    const [searchParams] = useSearchParams();
    const navigate = useNavigate();

    const searchQuery = searchParams.get('query') || '';

    useEffect(() => {
        const fetchSearchResults = async () => {

            try {
                const response = await axios.get<Product[]>(
                    `${searchProducts}?query=${searchQuery}`
                );
                setSearchResults(response.data);
            } catch (error) {
                console.error('Error featching search results:', error);
            }
        };
        if (searchQuery) {
            fetchSearchResults();
        }
    }, [searchQuery]);

    const handleSearch = (query: string) => {
        navigate(`/search?query=${query}`);
    };

    return (
        <div>
            <h1>Search Products</h1>
            <input
                type="text"
                placeholder='Search...'
                value={searchQuery}
                onChange={(e) => handleSearch(e.target.value)}
            />
            {searchResults.length > 0 ? (
                <ul>
                    {searchResults.map((product) => (
                        <li key={product.id}>
                            <h3>{product.name}</h3>
                            <p>{product.description}</p>
                            <p>${product.price}</p>
                            <img src={product.image_url} alt={product.name} />
                        </li>
                    ))}
                </ul>
            ): (
                <p>No search results found.</p>
            )}
        </div>
    )
}

export default ProductSearch;