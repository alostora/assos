import React, { useState, useEffect } from 'react'
import { useTranslation } from "react-i18next";
import { Link, useParams } from 'react-router-dom';

//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//component
import PaginatedItems from '../../components/PaginatedItems';
import Loader from '../../components/Loader';
import { axiosInstance } from '../../axios/config';


const OfferItems = () => {

    //translate
    const { t } = useTranslation();

    //id from link
    const { offer_id } = useParams()

    //fetch Items
    const [offerProducts, setOfferProducts] = useState([])

    const getOfferProducts = async () => {

        await axiosInstance({
            method: "get",
            url: `/offerItems/${offer_id}`,
        })
            .then(res => res.data)
            .then(data => setOfferProducts(data.data))

            .catch((err) => console.error(err));
    }

    useEffect(() => {

        getOfferProducts()

    }, [])

    return (

        <div className='recent-items-page d-flex flex-column my-4'>

            <div className="d-flex align-items-center page-names container mb-4">

                <Link to="/molk" className="text-decoration-none d-flex align-items-center ">
                    <HomeOutlinedIcon style={{ color: grey[500] }} />
                    <span className="page-name mx-1">{t("Home")}</span>
                </Link>

                <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                <span className="page-name ">{t("Offer Products")}</span>

            </div>

            <div>

                {offerProducts ?

                    <div className="recent-items container ">

                        {offerProducts && offerProducts.length > 0 &&

                            <PaginatedItems items={offerProducts} itemsPerPage={4} />
                        }

                    </div>

                    : <Loader />
                }

            </div>

        </div>
    )
}

export default OfferItems;