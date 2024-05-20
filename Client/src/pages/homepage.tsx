import MainLayout from "../layout/mainlayout"
import Banner from "../Components/banner"
import Products from "../Components/products"

import { useState } from 'react'
import PaymentForm from '../Components/mpesa'


interface Product {
  id: number;
  name: string;
  description: string;
  image_url: string;
  price: number;
  quantity: number;
  category: string;
  created_at: string | null;
  updated_at: string | null;

}

interface HomepageProps {
  addToCart: (product: Product) => void;
  cartItems: Product[];
  cartCount: number;
}
function Homepage({ addToCart, cartItems, cartCount }: HomepageProps) {
  const [isModalOpen, setIsModalOpen] = useState<boolean>(false);

  const openModal = () => {
    setIsModalOpen(true);
  };

  const closeModal = () => {
    setIsModalOpen(false);
  };

    return (
      <> 
      <MainLayout cartItems={cartItems} cartCount={cartCount}>
          <div className="min-h-screen bg-base-200">
            <div className="bg-cyan-800 p-4 block-md">
            </div>
            <div>
              <button onClick={openModal}>Open Payment Modal</button>
              <PaymentForm isOpen={isModalOpen} onClose={closeModal} />
            </div>
            <Banner />
            {/* <div className="bg-green-900 p-4 block-md">
            </div> */}
            <div>
              < Products addToCart={addToCart}/>
            </div>
          </div>
      </MainLayout>
      </>
    )
  }
  
  export default Homepage
  
