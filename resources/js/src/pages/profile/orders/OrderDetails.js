//react
import React, { useContext } from 'react';

//translate
import { useTranslation } from "react-i18next"

//react router
import { useHistory } from "react-router-dom";

//component 
import { ProgressBar } from 'react-bootstrap';
import { CountryContext } from '../../../App';


const OrderDetails = () => {

    //translate
    const { t } = useTranslation();

    // current country
    const { country, } = useContext(CountryContext);

    //route
    const history = useHistory();

    return (
        <div className='d-flex flex-column order-details-page pb-4'>

            <span className='order-code d-flex '>
                <span >{t("Order")}:</span>
                <span className='px-2 secondary-color-grey'>53324</span>
            </span>
            {/*///////////////////////////////////////////*/}

            <div className='d-flex flex-column my-2 progress-order'>
                <ProgressBar variant="success" now={100} className='my-2' />
                <div className='d-flex justify-content-between progress-details'>
                    <span>{t("Receipt of order")}</span>
                    <span>{t("Processing")}</span>
                    <span>{t("completed")}</span>
                </div>
            </div>
            {/*///////////////////////////////////////////*/}

            <div className='details-section row mt-4'>

                <div className='d-flex flex-column col-lg-6 col-12'>

                    <div className='order-details-line mb-2 row'>
                        <span className='col-5'>{t("Order Number")} </span>
                        <span className='secondary-color-grey px-2 col-7'>53324</span>
                    </div>

                    <div className='order-details-line mb-2 row'>
                        <span className='col-5'>{t("Payment Method")} </span>
                        <span className='secondary-color-grey px-2 col-7'>كاش</span>
                    </div>

                    <div className='order-details-line mb-2 row'>
                        <span className='col-5'>{t("Delivery Address")} </span>
                        <span className='secondary-color-grey px-2 col-7'>ffffdd ddddddddddfs</span>
                    </div>
                </div>

                <div className='d-flex flex-column col-lg-6 col-12'>

                    <div className='order-details-line mb-2 row'>
                        <span className='col-5'>{t("Order Date")} </span>
                        <span className='secondary-color-grey px-2 col-7'>15-12</span>
                    </div>

                    <div className='order-details-line mb-2 row'>
                        <span className='col-5'>{t("Delivery Method")} </span>
                        <span className='secondary-color-grey px-2 col-7'>سريع</span>
                    </div>

                    <div className='order-details-line mb-2 row'>
                        <span className='col-5'>{t("Estimated arrival time")} </span>
                        <span className='secondary-color-grey px-2 col-7'>72 ساعة</span>
                    </div>
                </div>
            </div>
            {/*///////////////////////////////////////////*/}

            <div className='d-flex flex-column order-items my-4'>

                <span className='header d-flex mb-2'>{t("Products")}</span>

                <div className='order-item row mb-4'>

                    <div className='col-lg-10 col-12'>
                        <div className='row'>

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
                    </div>

                    <div className='d-flex flex-column justify-content-between align-items-center col-lg-2 col-12 mt-2'>

                        <button className='btn-order-again mb-2'>{t("order again")}</button>
                        <button className='btn-return-order'
                            onClick={(e) => {
                                e.preventDefault();
                                return history.push('/profile/order/product-back');
                            }}
                        >
                            {t("return order")}
                        </button>
                    </div>
                </div>
            </div>
            {/*///////////////////////////////////////////*/}

            <div className='order-calc pt-2 px-4'>

                <div className='d-flex justify-content-between pb-3'>
                    <span className='second-header'>{t("Total order")}</span>
                    <span className='calc-result'>
                        5000
                        &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                    </span>
                </div>

                <div className='d-flex justify-content-between pb-3'>
                    <span className='second-header'>{t("Shipping Expenses")}</span>
                    <span className='calc-result'>
                        20
                        &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                    </span>
                </div>

                <div className='d-flex justify-content-between pb-3'>
                    <span className='second-header'>
                        {t("Value added tax")} &nbsp;{`(20%)`}

                    </span>
                    <span className='calc-result'>
                        20
                        &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                    </span>
                </div>
            </div>
            {/*///////////////////////////////////////////*/}

            <div className='d-flex justify-content-between p-4 order-total'>
                <span className='second-header'>
                    {t("Total")}

                </span>
                <span className='calc-result'>
                    5010

                    &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                </span>
            </div>
        </div>
    )
};

export default OrderDetails;
