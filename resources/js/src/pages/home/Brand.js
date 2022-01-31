//react
import React from 'react'

import { Link } from "react-router-dom";


const Brand = ({ brand }) => {
    return (
        <Link to={`/brands-categories/${brand.vendor_name}/${brand.id}`}
            className="text-decoration-none">

            <div className='d-flex justify-content-center align-items-center brand-item'
                style={{
                    backgroundImage: `linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.4)) , url("${brand.vendor_image}")`,
                }}>

                <img src={brand.vendor_logo} alt="item Brand Icon" />
            </div>
        </Link>
    )
}

export default Brand;