import React from 'react'
import { Link } from 'react-router-dom';


const BrandLogo = ({ brand }) => {
    return (

        <Link to={`/brands-categories/${brand.vendor_name}/${brand.id}`}
            className="text-decoration-none col-lg-2 col-3 my-4">

            <img src={brand.vendor_logo}
                alt="brand Icon"
                className='brand-logo-img'
            />

        </Link>
    )
}

export default BrandLogo;
