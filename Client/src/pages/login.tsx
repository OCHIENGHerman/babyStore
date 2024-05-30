import React, { useState } from 'react'
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import { loginUrl } from '../url';

interface LoginData {
    email: string;
    password: string;
}

const Login: React.FC = () => {
    const navigate = useNavigate();
    const [formData, setFormData] = useState<LoginData>({
        email: '',
        password: '',
    });

    const [loading, setLoading] = useState<boolean>(false);
    const [error, setError] = useState<string | null>(null);
    const [message, setMessage] = useState<string | null>(null);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setFormData({ ...formData, [e.target.name]: e.target.value});
    };
    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setLoading(true);
        setError(null);
        setMessage(null);

        try {
            const response = await axios.post(loginUrl, formData, {
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            if (response.data.status) {
                // console.log(response.data.message);
                setMessage(response.data.message);
                navigate('/');
            } else {
                // console.error(response.data.message);
                setError(response.data.error);
            }
        } catch (error) {
            setError('An error occurred. Please try again later.');
            // console.error(error);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div>
         {loading && <p>Loading...</p>}
         {error && <p>{error}</p>}
         {message && <p>{message}</p>} 
        <form onSubmit={handleSubmit}>
            <input
                type='email'
                name='email'
                placeholder='Email'
                value={formData.email}
                onChange={handleChange}
            />
            <input
                type='password'
                name='password'
                placeholder='Password'
                value={formData.password}
                onChange={handleChange}
            />
            <button type='submit' disabled={loading}>
                {loading ? 'Loging in...' : 'Login'}
            </button>
        </form>
        </div>
    );
};

export default Login;