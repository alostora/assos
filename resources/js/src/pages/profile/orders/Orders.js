//react
import React, { useContext } from 'react';

//react router
import { useHistory } from "react-router-dom";

//translate
import { useTranslation } from "react-i18next"

//material ui
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import ArrowForwardIcon from '@mui/icons-material/ArrowForward';

//component
import { ProgressBar } from 'react-bootstrap';
import { CountryContext } from '../../../App';


const Orders = () => {

    //translate
    const { t } = useTranslation();

    // current country
    const { country, } = useContext(CountryContext);

    const history = useHistory();

    return (
        <div className='d-flex flex-column profile-orders px-2'>

            <span className='header mb-2'>{t("Orders")}</span>

            <div className='d-flex align-items-center filter-buttons px-1 my-2'>

                <button className='btn-filter btn-active '>{t("Current")}</button>
                <button className='btn-filter'>{t("Completed")}</button>
                <button className='btn-filter'>{t("Canceled")}</button>
            </div>

            <div className='d-flex justify-content-between my-2 order-details'>

                <div className='d-flex'>
                    <span className='header-secondary '>{t("Order")}:</span>
                    <span className='second-details px-2'>#fff</span>
                </div>

                <div className='d-flex'>
                    <span className='header-secondary '>{t("Order Date")}:</span>
                    <span className='second-details px-2'>#fff</span>
                </div>
            </div>

            <div className='d-flex flex-column my-2 progress-order'>
                <ProgressBar variant="success" now={50} className='my-2' />
                <div className='d-flex justify-content-between progress-details'>
                    <span>{t("Receipt of order")}</span>
                    <span>{t("Processing")}</span>
                    <span>{t("completed")}</span>
                </div>
            </div>

            <div className='d-flex flex-column order-items my-2'>
                <span className='header d-flex mb-2'>{t("Products")}</span>

                <div className='order-item row mb-4'>

                    <div className='col-lg-3 col-7'>
                        <img src="https://source.unsplash.com/user/c_v_r/1900x800" alt="orderItem" />
                    </div>

                    <div className='col-lg-9 col-5 d-flex flex-column'>
                        <span className='mb-2 brand-name'>dfdd</span>

                        <span className='item-name mb-2'>fddddddddd</span>

                        <span className='mb-2 item-price'>555 &nbsp;{country === "sa" ? t("SAR") : t("KWD")}</span>

                        <div className='d-flex item-count'>
                            <span className='mx-2 '>{t("Count")}:</span>
                            <span>2</span>
                        </div>

                    </div>
                </div>

                <button className='btn-order-details d-flex'
                onClick={(e)=>{
                    e.preventDefault();
                    return history.push("/profile/order/order-details");
                }}
                >
                    {t("View order details")}
                    <span className='px-2'>{localStorage.getItem("i18nextLng") === "en" ?
                        <ArrowForwardIcon /> : <ArrowBackIcon />}</span>
                </button>

            </div>

        </div>
    )
};

export default Orders;