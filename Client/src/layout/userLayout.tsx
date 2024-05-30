import React, { useState } from 'react';
import { Outlet, Link, useNavigate } from 'react-router-dom';

const UserLayout: React.FC = () => {
    const [searchQuery, setSearchQuery] = useState('');
    const navigate = useNavigate();

    const handleSearch = () => {
        if (searchQuery.trim()) {
            navigate(`/search?query=${searchQuery.trim()}`);
        }
    };

    return (
        <div>
            <header>
                <div>
                    <h1>BabyStore App</h1>
                    <div>
                        <input
                            type='text'
                            placeholder='Search products...'
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                        />
                        <button onClick={handleSearch}>Search</button>
                    </div>
                </div>
                <nav>
                    <ul>
                        <li>
                            <Link to="/">Home</Link>
                        </li>
                    </ul>
                </nav>
            </header>
            <main>
                <Outlet />
            </main>
            <footer>
                <h1>&copy; 2023 BabyStore</h1>
            </footer>
        </div>
    )
}

export default UserLayout;