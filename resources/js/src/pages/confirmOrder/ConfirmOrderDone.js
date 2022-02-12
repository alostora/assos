//react
import React from 'react';

//react router
import { Link, useHistory } from 'react-router-dom';

//translate
import { useTranslation } from "react-i18next";

//material ui
import CheckCircleOutlineIcon from '@mui/icons-material/CheckCircleOutline';
import { green, grey } from '@mui/material/colors';
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';


const ConfirmOrderDone = () => {

    //translate
    const { t } = useTranslation();

    //for route
    const history = useHistory();


    return (
        <div className='d-flex flex-column container my-4 confirm-order-page'>

            <div className="d-flex align-items-center page-names mb-4">

                <Link to="/" className="text-decoration-none d-flex align-items-center ">
                    <HomeOutlinedIcon style={{ color: grey[500] }} />
                    <span className="page-name mx-1">{t("Home")}</span>
                </Link>

                <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                <span className="page-name ">{t("Confirm Order")}</span>
            </div>

            <div className='d-flex flex-column justify-content-center align-items-center my-5'>
                <CheckCircleOutlineIcon sx={{ color: green[500] }} fontSize='large' />
                <h3 className='my-2'>{t("Thank you for your order from Molk")}</h3>
            </div>
            <div className='d-flex flex-column justify-content-center align-items-center pb-4'>
                <button className='btn-continue-shopping'
                    onClick={(e) => {
                        e.preventDefault();
                        return history.push("/")
                    }}>
                    {t("Continue Shopping")}
                </button>
            </div>
        </div>
    )

};

export default ConfirmOrderDone;