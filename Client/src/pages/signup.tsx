import React, { useState } from 'react'
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

interface RegisterData {
    first_name: string;
    last_name: string;
    email: string;
    password: string;
    password_confirmation: string;
    phone_number: string;
}

const Signup: React.FC = () => {
    const navigate = useNavigate();
    const [formData, setFormData] = useState<RegisterData>({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
        phone_number: '',
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
            const response = await axios.post('http://127.0.0.1:8000/api/register-normal-user', formData, {
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            if (response.data.status) {
                // console.log(response.data.message);
                setMessage(response.data.message);
                navigate('/login');
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
                type='text'
                name='first_name'
                placeholder='First Name'
                value={formData.first_name}
                onChange={handleChange}
            />
            <input
                type='text'
                name='last_name'
                placeholder='Last Name'
                value={formData.last_name}
                onChange={handleChange}
            />
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
            <input
                type='password'
                name='password_confirmation'
                placeholder='Confirm Password'
                value={formData.password_confirmation}
                onChange={handleChange}
            />
            <input
                type='phoneNumber'
                name='phone_number'
                placeholder='Phone Number'
                value={formData.phone_number}
                onChange={handleChange}
            />
            <button type='submit' disabled={loading}>
                {loading ? 'Registering...' : 'Register'}
            </button>
        </form>
        </div>
    );
};

export default Signup;