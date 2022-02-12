import React from 'react'
import { useTranslation } from "react-i18next";
import { Link } from 'react-router-dom';

//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//components
//import Carousel from 'react-bootstrap/Carousel'
import BrandLogo from '../../components/BrandLogo';

//image
//import brand_slider_img from './../../assets/icons/Brands/vendor_slider_img.jpg'


const Brands = ({ brands }) => {

    //translate
    const { t } = useTranslation();


    return (
        <div className="all-brands d-flex flex-column my-4 ">

            <div className="d-flex align-items-center page-names container mb-3">

                <Link to="/molk" className="text-decoration-none d-flex align-items-center ">
                    <HomeOutlinedIcon style={{ color: grey[500] }} />
                    <span className="page-name mx-1">{t("Home")}</span>
                </Link>

                <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                <span className="page-name ">{t("Brands")}</span>

            </div>

            {/* <Carousel
                nextIcon={<span aria-hidden="false" />}
                prevIcon={<span aria-hidden="false" />}
                className="brands-carousel">

                <Carousel.Item interval={1000} >

                    <img src={brand_slider_img} alt="Carousel Img" />

                </Carousel.Item>

            </Carousel> */}

            <div className='d-flex flex-column container my-5'>
                <span className="header d-flex mb-5">{t("Shop by Brands")}</span>

                <div className="row mx-0 justify-content-center align-items-center w-100">
                    {brands && brands.map(br => (

                        <BrandLogo brand={br} key={br.id} />
                    ))}

                </div>
            </div>

        </div>
    )
}

export default Brands