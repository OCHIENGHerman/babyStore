import React, { createContext, useState, useEffect } from 'react';
// import React, { createContext, useState, useEffect, useContext } from 'react';
import axios from 'axios';
import { loginUrl } from '../url';

interface UserData {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    email_verified_at: string | null;
    phone_number: string | null;
    role: string;
    created_at: string;
    updated_at: string;
}

export interface AuthContextData {
    user: UserData | null;
    token: string | null;
    login: (email: string, password: string) => void;
    logout: () => void;
}

interface AuthProviderProps {
    children: React.ReactNode;
}

export const AuthContext = createContext<AuthContextData>({
    user: null,
    token: null,
    login: () => {},
    logout: () => {}
});

// export const useAuth = () => useContext(AuthContext);

export const AuthProvider: React.FC<AuthProviderProps> = ({ children }) => {
    const [user, setUser] = useState<UserData | null>(null);
    const [token, setToken] = useState<string | null>(null);

    useEffect(() => {
        const storedToken = localStorage.getItem('token');
        const storedUser = localStorage.getItem('user');
        if (storedToken && storedUser) {
            setUser(JSON.parse(storedUser));
            setToken(storedToken);
        }
    }, []);

    const login = async (email: string, password: string) => {
        try {
            const response = await axios.post(loginUrl, {
                email,
                password,
            },
            {
                headers: {
                    'Content-Type': 'application/json',
                },
            }
        );

            if (response.data.status) {
                setUser(response.data.user);
                setToken(response.data.token);
                localStorage.setItem('token', response.data.token);
                localStorage.setItem('user', JSON.stringify(response.data.user));
            }
        } catch (error) {
            console.error('Login error:', error);
        }
    };

    const logout = () => {
        setUser(null);
        setToken(null);
        localStorage.removeItem('token');
        localStorage.removeItem('user');
    };

    return (
        <AuthContext.Provider value={{user, token, login, logout}}>
            {children}
        </AuthContext.Provider>
    );
};