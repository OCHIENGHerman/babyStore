import { ChangeEvent, FormEventHandler, useState } from "react"
import { useNavigate } from "react-router-dom";
import Swal from "sweetalert2";
import { loginUser } from "../Components/urls";
import { useUser } from "../hooks/useUser";

function Login() {

    const [formData, setFormData] = useState({
        email:"",
        password:""
    });

    const [loading, setLoading] = useState(false);

    const navigate = useNavigate();
    const { login } = useUser();

    const handleChange = (event:ChangeEvent<HTMLInputElement>) => {
        const key = event.target.name;
        const value = event.target.value;

        setFormData({ ...formData, [key]:value});
    }



    const handleLogin: FormEventHandler<HTMLFormElement> = (event) => {
        
        event.preventDefault();

        setLoading(true);

        fetch(loginUser, {
            method:'POST',
            headers:{
                'Content-Type' : 'application/json'
            },
            body:JSON.stringify(formData)
        })
        .then((response) => {
            if (response.ok){

                return response.json();

            }else{
                throw new Error('Response was not ok')
            }
        })
        .then((data) => {

            login(data.Token, data.User);
            console.log(data.User.roles[0].name);
            console.log(data);

            Swal.fire({
                position:"top-end",
                icon:"success",
                title:"Logged in",
                showConfirmButton:false,
                timer:1000
            })

            const isAdmin = data.User.roles[0].name == 'admin';

            if (isAdmin){
                navigate('/admin');
            }else{
                navigate('/cart');
            }

            
        })
        .catch((error) => {
            console.error('Error', error);

            Swal.fire({
                icon:"error",
                title:"Ooops...",
                text:"Something went wrong"
            })
        })
        .finally(() => {
            setLoading(false);
        })
    }
  return (
    <div className="container flex flex-col justify-center items-center mx-auto mt-60">

        <div className="mx-auto">

            <h3 className="text-3xl text-cyan-900 font-bold">Welcome</h3>
            <h4 className="text-xl text-gray-500 mt-4">Please login here</h4>


            <form className="space-y-6" onSubmit={handleLogin}>

                <div className="mt-2">
                    <label className="block text-sm font-medium text-gray-600">Email Address</label>
                    <div className="mt-4">
                        <input name="email" value={formData.email} onChange={handleChange} type="email" required className="w-full rounded-md border-2 border-zinc-950 indent-3 text-gray-900 shadow-sm py-1.5"/>
                    </div>
                </div>

                <div className="mt-2">
                    <label className="block text-sm font-medium text-gray-600">Password</label>
                    <div className="mt-4">
                        <input name="password" value={formData.password} onChange={handleChange} type="password" required className="w-full rounded-md border-2 border-zinc-950 indent-3 text-gray-900 shadow-sm py-1.5"/>
                    </div>
                </div>

                <div className="flex items-center">
                    <div>
                        <input type="checkbox" name="rememberme" className="form-checkbox mr-2"></input>
                    </div>

                    <label className="text-blue-900">Remember Me</label>

                    <a href="/resetpassword" className="text-blue-500 ml-36">Forgot Password ?</a>

                </div>
                
                <div>
                    <a href="/register" className="text-blue-900">Don't have an account? Register</a>
                </div>

                <div>
                    <button type="submit" className="flex justify-center px-40 py-4 rounded-md bg-blue-600 font-semibold hover:bg-green-900 cursor-pointer text-white text-2xl">Login</button>
                </div>

            </form>

        </div>

        {loading && (
            <div className="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center">
                <div className="bg-white p-6 rounded-lg shadow-md">
                    <p className="text-lg font-semibold">Loading...</p>
                </div>
            </div>
        )}
    </div>
  )
}

export default Login