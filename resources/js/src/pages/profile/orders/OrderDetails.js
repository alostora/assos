//react
import React, { Fragment, useContext, useEffect, useState } from 'react';

//translate
import { useTranslation } from "react-i18next"

// redux
import { useDispatch } from 'react-redux'
import { getOrder } from '../../../redux/actions/orderActions';

//react router
import { useHistory, useParams } from "react-router-dom";

//component 
import { ProgressBar } from 'react-bootstrap';
import { CountryContext } from '../../../App';
import Loader from '../../../components/Loader';
import { axiosInstance } from '../../../axios/config';


const OrderDetails = () => {

    //translate
    const { t } = useTranslation();

    // current country
    const { country, } = useContext(CountryContext);

    //route
    const history = useHistory();

    //params

    const { order_id } = useParams()

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

    const selectedOrder = orders ? orders.find(order => order.id === Number(order_id)) : {}


    useEffect(() => {

        getAllOrders();

    }, [])

    const dispatch = useDispatch()

    const addItemToCart = (id) => {

        axiosInstance({
            method: "post",
            url: `/makeOrder`,
            data: {
                "item_id": id,
                "count": 1,
                "props": []
            }
        })
            .then((res) => res.status && dispatch(getOrder()))

            .catch((err) => console.error(err));

    }


    return (
        <Fragment>
            {loading ? <Loader /> :

                < div className='d-flex flex-column order-details-page pb-4'>

                    <span className='order-code d-flex '>
                        <span >{t("Order")}:</span>
                        <span className='px-2 secondary-color-grey'>{selectedOrder && selectedOrder.orderCode}</span>
                    </span>
                    {/*///////////////////////////////////////////*/}

                    <div className='d-flex flex-column my-2 progress-order'>

                        <ProgressBar variant="success" className='my-2'
                            now={(() => {
                                switch (selectedOrder && selectedOrder.status) {
                                    case "confirmed":
                                        return 50;
                                    case "completed":
                                        return 100;
                                    case "canceled":
                                        return 0;
                                    default:
                                        return 0;
                                }
                            })()} />

                        <div className={`d-flex justify-content-between progress-details`}>
                            <span className={`${selectedOrder && selectedOrder.status === "canceled" ? "progress-details-cancel" : "progress-details-confirm"}`}>

                                {selectedOrder && selectedOrder.status !== "canceled" ? t("Receipt of order") : t("Cancelling order")}
                            </span>

                            <span className={`${selectedOrder && selectedOrder.status !== "canceled" && "progress-details-confirm"}`}>

                                {t("Processing")}
                            </span>

                            <span className={`${selectedOrder && selectedOrder.status === "completed" && "progress-details-confirm"}`}>

                                {t("completed")}
                            </span>

                        </div>
                    </div>
                    {/*///////////////////////////////////////////*/}

                    <div className='details-section row mt-4'>

                        <div className='d-flex flex-column col-lg-6 col-12'>

                            <div className='order-details-line mb-2 row'>
                                <span className='col-5'>{t("Order Number")} </span>
                                <span className='secondary-color-grey px-2 col-7'>{selectedOrder && selectedOrder.orderCode}</span>
                            </div>

                            <div className='order-details-line mb-2 row'>
                                <span className='col-5'>{t("Payment Method")} </span>
                                <span className='secondary-color-grey px-2 col-7'>{selectedOrder && selectedOrder.paymentMethod}</span>
                            </div>

                            <div className='order-details-line mb-2 row'>
                                <span className='col-5'>{t("Delivery Address")} </span>
                                <span className='secondary-color-grey px-2 col-7'>
                                    {selectedOrder && selectedOrder.shippingAddress && `${selectedOrder.shippingAddress.street} - ${selectedOrder.shippingAddress.address}`}
                                </span>
                            </div>
                        </div>

                        <div className='d-flex flex-column col-lg-6 col-12'>

                            <div className='order-details-line mb-2 row'>
                                <span className='col-5'>{t("Order Date")} </span>
                                <span className='secondary-color-grey px-2 col-7'>{selectedOrder && selectedOrder.date}</span>
                            </div>

                            <div className='order-details-line mb-2 row'>
                                <span className='col-5'>{t("Delivery Method")} </span>
                                <span className='secondary-color-grey px-2 col-7'>{selectedOrder && selectedOrder.shippingType}</span>
                            </div>

                            <div className='order-details-line mb-2 row'>
                                <span className='col-5'>{t("Estimated arrival time")} </span>
                                <span className='secondary-color-grey px-2 col-7'>{selectedOrder && selectedOrder.expectedDate}</span>
                            </div>
                        </div>
                    </div>
                    {/*///////////////////////////////////////////*/}

                    <div className='d-flex flex-column order-items my-4'>

                        <span className='header d-flex mb-2'>{t("Products")}</span>

                        {selectedOrder && selectedOrder.order_items.map(item =>
                            <div className='order-item row mb-4' key={item.id}>

                                <div className='col-lg-10 col-12'>
                                    <div className='row'>

                                        <div className='col-lg-3 col-7'>
                                            <img src={item.itemImage} alt="orderItem" />
                                        </div>

                                        <div className='col-lg-9 col-5 d-flex flex-column'>
                                            {/* <span className='mb-2 brand-name'>dfdd</span> */}

                                            <span className='item-name mb-2'>{item.itemName}</span>

                                            <span className='mb-2 item-price'>
                                                {item.itemPriceAfterDis} &nbsp;{country === "sa" ? t("SAR") : t("KWD")}</span>

                                            <div className='d-flex item-count'>
                                                <span className='mx-2 '>{t("Count")}:</span>
                                                <span>{item.item_count}</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div className='d-flex flex-column justify-content-between align-items-center col-lg-2 col-12 mt-2'>

                                    <button className='btn-order-again mb-2'
                                        onClick={() => addItemToCart(item.item_id)}>
                                        {t("order again")}
                                    </button>

                                    {selectedOrder && selectedOrder.canBack && <button className='btn-return-order'
                                        onClick={(e) => {
                                            e.preventDefault();
                                            return history.push(`/profile/order/product-back-${item.order_id}-${item.item_id}`);
                                        }}>

                                        {t("Product return")}
                                    </button>}

                                </div>
                            </div>
                        )}
                    </div>
                    {/*///////////////////////////////////////////*/}

                    <div className='order-calc pt-2 px-4'>

                        <div className='d-flex justify-content-between pb-3'>
                            <span className='second-header'>{t("Total order")}</span>
                            <span className='calc-result'>
                                {selectedOrder && selectedOrder.total_price}
                                &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                            </span>
                        </div>

                        <div className='d-flex justify-content-between pb-3'>
                            <span className='second-header'>{t("Shipping Expenses")}</span>
                            <span className='calc-result'>
                                {selectedOrder && selectedOrder.shippingValue}
                                &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                            </span>
                        </div>

                        <div className='d-flex justify-content-between pb-3'>
                            <span className='second-header'>{t("Coupon Discount")}</span>
                            <span className='calc-result'>
                                {selectedOrder && (selectedOrder.discountCopon * selectedOrder.total_price) / 100}
                                &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                            </span>
                        </div>

                        <div className='d-flex justify-content-between pb-3'>
                            <span className='second-header'>
                                {t("Value added tax")}

                            </span>
                            <span className='calc-result'>
                                {selectedOrder && selectedOrder.addedTax}
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

                            {selectedOrder && selectedOrder.total - ((selectedOrder.discountCopon * selectedOrder.total_price) / 100)}
                            &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                        </span>
                    </div>
                </div>

            }
        </Fragment >
    )
};

export default OrderDetails;
