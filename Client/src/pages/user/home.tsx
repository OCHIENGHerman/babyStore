import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';

const Homepage: React.FC = () => {
    const [searchQuery, setSearchQuery] = useState('');
    const navigate = useNavigate();

    const handleSearch = () => {
        if (searchQuery.trim()) {
            navigate(`/search?query=${searchQuery.trim()}`);
        }
    };

    return (
        <div>
            <h1>Homepage</h1>
            <div>
                <input
                    type="text"
                    placeholder="Search products..."
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                />
                <button onClick={handleSearch}>Search</button>
            </div>
        </div>
    )
}

export default Homepage;