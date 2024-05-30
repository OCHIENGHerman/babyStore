import { Routes, Route } from "react-router-dom"
import Homepage from "./pages/user/home"
import SuperAdminDashboard from "./pages/super_admin/superADashboard"
import AdminDashboard from "./pages/admin/adminDashboard"
import Signup from "./pages/signup"
import Login from "./pages/login"
import ProductSearch from "./pages/user/productSearch"

export default function App() {
  
  return (
    <>
      <Routes>
        <Route path="/" element={<Homepage />} />
        <Route path="/super_admin" element={<SuperAdminDashboard />} />
        <Route path="/admin" element={<AdminDashboard />} />
        <Route path="/signup" element={<Signup />} />
        <Route path="/login" element={<Login />} />
        <Route path="/search" element={<ProductSearch />} />
      </Routes>
    </>
  )
}
