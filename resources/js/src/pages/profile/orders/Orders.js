//react
import React, { Fragment, useContext, useEffect, useState } from 'react';

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
import Loader from '../../../components/Loader';
import { axiosInstance } from '../../../axios/config';


const Orders = () => {

    //translate
    const { t } = useTranslation();

    // current country
    const { country, } = useContext(CountryContext);

    const history = useHistory();

    //get allOrders
    const [orders, setOrders] = useState([])

    const [loading, setLoading] = useState(true)

    const getAllOrders = async () => {

        await axiosInstance({
            method: "get",
            url: `/getAllOrders`,
        })
            .then(res => res.data)
            .then(data => {
                setLoading(!data.status);
                setOrders(data.order);
            })

            .catch((err) => console.error(err));
    }

    //order status
    const [orderStatus, setOrderStatus] = useState("confirmed")


    useEffect(() => {

        getAllOrders();

    }, [])

    return (
        <Fragment>
            {loading ? <Loader /> :

                <div className='d-flex flex-column profile-orders px-2'>

                    <span className='header mb-2'>{t("Orders")}</span>

                    <div className='d-flex align-items-center filter-buttons px-1 my-2'>

                        <button className={`btn-filter ${orderStatus === "confirmed" && "btn-active"}`}
                            onClick={() => setOrderStatus("confirmed")}>

                            {t("Current")}
                        </button>

                        <button className={`btn-filter ${orderStatus === "completed" && "btn-active"}`}
                            onClick={() => setOrderStatus("completed")}>

                            {t("Completed")}
                        </button>

                        <button className={`btn-filter ${orderStatus === "canceled" && "btn-active"}`}
                            onClick={() => setOrderStatus("canceled")}>

                            {t("Canceled")}
                        </button>
                    </div>

                    {orders && orders.filter(order => order.status === orderStatus).map(order =>

                        <div key={order.id} className='mb-4'>

                            <div className='d-flex justify-content-between my-2 order-details'>

                                <div className='d-flex'>
                                    <span className='header-secondary '>{t("Order")}:</span>
                                    <span className='second-details px-2'>{order.orderCode}</span>
                                </div>

                                <div className='d-flex'>
                                    <span className='header-secondary '>{t("Order Date")}:</span>
                                    <span className='second-details px-2'>{order.date}</span>
                                </div>
                            </div>

                            <div className='d-flex flex-column my-2 progress-order'>

                                <ProgressBar variant="success" className='my-2'
                                    now={(orderStatus === 'confirmed' && 50)
                                        || (orderStatus === 'completed' && 100)
                                        || (orderStatus === "canceled" && 0
                                            || 0)} />

                                <div className={`d-flex justify-content-between progress-details`}>
                                    <span className={`${orderStatus === "canceled" ? "progress-details-cancel" : "progress-details-confirm"}`}>

                                        {orderStatus !== "canceled" ? t("Receipt of order") : t("Cancelling order")}
                                    </span>

                                    <span className={`${orderStatus !== "canceled" && "progress-details-confirm"}`}>

                                        {t("Processing")}
                                    </span>

                                    <span className={`${orderStatus === "completed" && "progress-details-confirm"}`}>

                                        {t("completed")}
                                    </span>

                                </div>
                            </div>

                            <div className='d-flex flex-column order-items my-2'>
                                <span className='header d-flex mb-2'>{t("Products")}</span>

                                {order.order_items.filter((item, index) => index <= 1).map(item =>

                                    <div className='order-item row mb-4' key={item.id}>

                                        <div className='col-lg-3 col-7'>
                                            <img src={item.itemImage} alt="orderItem" />
                                        </div>

                                        <div className='col-lg-9 col-5 d-flex flex-column'>
                                            {/* <span className='mb-2 brand-name'>dfdd</span> */}

                                            <span className='item-name mb-2'>{item.itemName}</span>

                                            <span className='mb-2 item-price'>
                                                {item.itemPriceAfterDis} &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                                            </span>

                                            <div className='d-flex item-count'>
                                                <span className='mx-2 '>{t("Count")}:</span>
                                                <span>{item.item_count}</span>
                                            </div>

                                        </div>

                                    </div>

                                )}
                                <button className='btn-order-details d-flex'
                                    onClick={(e) => {
                                        e.preventDefault();
                                        return history.push(`/profile/order/order-details-${order.id}`);
                                    }}
                                >
                                    {t("View order details")}
                                    <span className='px-2'>{localStorage.getItem("i18nextLng") === "en" ?
                                        <ArrowForwardIcon /> : <ArrowBackIcon />}</span>
                                </button>

                            </div>
                        </div>
                    )}
                </div>
            }
        </Fragment >
    )
};

export default Orders;