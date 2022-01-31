//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//translate
import { useTranslation } from "react-i18next";

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getOrder } from './../../redux/actions/orderActions'

//react
import React, { Fragment, useEffect, useState, useContext } from 'react';

//react router
import { Link, useHistory } from 'react-router-dom';

//component
import Loader from '../../components/Loader';
import { axiosInstance } from '../../axios/config';
import { CountryContext } from '../../App';
import { Form } from 'react-bootstrap';


const ConfirmOrder = () => {

    //translate
    const { t } = useTranslation();

    //for route
    const history = useHistory();

    // current country
    const { country, } = useContext(CountryContext)

    //data for confirm

    const [shippingTypeSelect, setShippingTypeSelect] = useState(0)

    // fetch from api
    const dispatch = useDispatch()

    // order
    const { loading, order, error } = useSelector(state => state.order)

    const cartItems = order ? order.order_items : [];

    // CheckOutDetails 
    const [checkDetails, setCheckDetails] = useState({})

    const getCheckOutDetails = async () => {

        await axiosInstance({
            method: "get",
            url: `/checkOutDetails`,
        })
            .then(res => res.data)
            .then(data => setCheckDetails(data.data))

            .catch((err) => console.error(err));
    }

    //address
    const defaultAddress = checkDetails ? checkDetails.shippingAddress : null

    //shipping types
    const shippingTypes = checkDetails ? checkDetails.orderSetting : null

    const normalShippingType = shippingTypes ? shippingTypes.find(type => type.settingName === "normalShipping") : ""

    const fastShippingType = shippingTypes ? shippingTypes.find(type => type.settingName === "fastShipping") : ""

    //tax Value
    const addedTaxValue = shippingTypes ? shippingTypes.find(type => type.settingName === "addedTax") : ""

    const taxPercent = (order.total_price * addedTaxValue.settingValue) / 100;

    //payment method value
    const [payMethodValue, setPayMethodValue] = useState("")

    //total price
    const [totalPrice, setTotalPrice] = useState(0)


    useEffect(() => {

        dispatch(getOrder())

        getCheckOutDetails()

    }, [dispatch, error])

    const [confirmData, setConfirmData] = useState({})

    useEffect(() => {

        setConfirmData({
            id: order && order.id,
            shippingType: shippingTypeSelect && shippingTypeSelect.settingName,
            paymentMethod: payMethodValue,
            addedTax: taxPercent,
            shippingAddress_id: defaultAddress && defaultAddress.id,
            shippingValue: shippingTypeSelect && shippingTypeSelect.settingValue,
            sub_total: order && order.total_price,
            total: totalPrice
        })
    }, [order, shippingTypeSelect, payMethodValue, checkDetails, taxPercent, defaultAddress, totalPrice])

    useEffect(() => {
        setTotalPrice(
            shippingTypeSelect && addedTaxValue && order ?

                order.total_price + taxPercent + shippingTypeSelect.settingValue :
                order.total_price + taxPercent
        )
    }, [shippingTypeSelect, order, addedTaxValue, checkDetails, taxPercent])

    //confirm order function
    const confirmOrder = async () => {

        await axiosInstance({
            method: "post",
            url: `/confirmOrder`,
            data: confirmData
        })
            .then(res => res.data)
            .then(data => console.log({ data }))

            .catch((err) => console.error(err));
    }


    return (
        <div className='d-flex flex-column container my-4 confirm-order-page'>

            <div className="d-flex align-items-center page-names mb-4">

                <Link to="/molk" className="text-decoration-none d-flex align-items-center ">
                    <HomeOutlinedIcon style={{ color: grey[500] }} />
                    <span className="page-name mx-1">{t("Home")}</span>
                </Link>

                <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                <span className="page-name ">{t("Confirm Order")}</span>
            </div>

            <Fragment>
                {loading ? <Loader /> :

                    <div className='container d-flex flex-column'>

                        <div className='d-flex flex-column items-cart'>

                            <span className='items-num mb-3'>{cartItems && cartItems.length} &nbsp; {t("Cart Items")}</span>

                            <div className='items row mx-0 mb-3'>
                                {cartItems && cartItems.map(item =>

                                    <div className='item-cart d-flex flex-column col-lg-2 col-3' key={item.id}>

                                        <img src={item.itemImage} alt='itemImage' />
                                        <span className='item-name my-1'>{item.itemName}</span>
                                    </div>

                                )}
                            </div>
                        </div>
                        {/*///////////////////////////////////////////*/}

                        <div className='d-flex flex-column delivery-address'>

                            <span className='header mt-4 mb-3'>{t("Delivery Address")}</span>

                            <div className='row'>

                                <div className='d-flex flex-column address-details col-lg-10 col-12 p-2'>

                                    <div className='row mb-2'>
                                        <span className='col-2 fw-bold'>{t("Name")}</span>
                                        <span className='col-10 details'>{defaultAddress && defaultAddress.name}</span>
                                    </div>


                                    <div className='row mb-2'>
                                        <span className='col-2 fw-bold'>{t("Address")}</span>
                                        <span className='col-10 details'>


                                            {`${defaultAddress && defaultAddress.street ? defaultAddress.street : ""} - ${defaultAddress && defaultAddress.address}`}</span>
                                    </div>


                                    <div className='row mb-2'>
                                        <span className='col-2 fw-bold'>{t("Phone")}</span>
                                        <span className='col-10 details'>{defaultAddress && defaultAddress.phone}</span>
                                    </div>

                                </div>

                                <button className='btn-change-address d-flex justify-content-center align-items-center my-2 col-lg-2 col-12 p-1'
                                    onClick={(e) => {
                                        e.preventDefault();
                                        return history.push('/profile/address')
                                    }}
                                >
                                    {defaultAddress ? t("Change Address") : t("Add Address")}
                                </button>
                            </div>
                        </div>
                        {/*///////////////////////////////////////////*/}

                        <div className='d-flex flex-column mt-4 delivery-options'>
                            <span className='d-flex header mb-3'>{t("Delivery options")}</span>

                            <div className='row mx-0 option-details mb-2'>

                                <div className="form-check col-lg-6 col-12">
                                    <input className="form-check-input" type="radio" name="flexRadioDelivery" id="flexRadio1"
                                        value={normalShippingType} required
                                        onChange={() => setShippingTypeSelect(normalShippingType)}
                                    />
                                    <label className="form-check-label row" htmlFor="flexRadio1">

                                        <span className='col-3'>{t("Normal Delivery")} </span>
                                        <span className='col-9 shipping-option'>{`(${normalShippingType && normalShippingType.settingOptions})`}</span>
                                    </label>
                                </div>

                                <span className='col-lg-6 col-12 d-flex justify-content-end'>

                                    {normalShippingType && normalShippingType.settingValue}
                                    &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                                </span>
                            </div>

                            <div className='row mx-0 option-details'>

                                <div className="form-check col-lg-6 col-12" >
                                    <input className="form-check-input" type="radio" name="flexRadioDelivery" id="flexRadio2"
                                        value={fastShippingType}
                                        onChange={() => setShippingTypeSelect(fastShippingType)}
                                    />
                                    <label className="form-check-label row" htmlFor="flexRadio2">

                                        <span className='col-3'>{t("Fast Shipping")} </span>
                                        <span className='col-9 shipping-option'>{`(${fastShippingType && fastShippingType.settingOptions})`}</span>
                                    </label>
                                </div>

                                <span className='col-lg-6 col-12 d-flex justify-content-end'>

                                    {fastShippingType && fastShippingType.settingValue}
                                    &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                                </span>
                            </div>
                        </div>
                        {/*///////////////////////////////////////////*/}

                        <div className='d-flex flex-column mt-5 pay-options mb-2'>
                            <span className='d-flex header mb-3'>{t("Payment options")}</span>

                            <div className='row'>

                                <div className='col-lg-4 col-12'>

                                    <div className="form-check option-details mb-2">
                                        <input className="form-check-input" type="radio" name="flexRadioPayment" id="flexRadiopay1"
                                            value={""}
                                        />
                                        <label className="form-check-label" htmlFor="flexRadiopay1">
                                            {t("Credit Card")}
                                        </label>
                                    </div>

                                    <div className="form-check option-details mb-2">
                                        <input className="form-check-input" type="radio" name="flexRadioPayment" id="flexRadiopay2"
                                            value={"cash"}
                                            onChange={(e) => setPayMethodValue(e.target.value)}
                                        />
                                        <label className="form-check-label" htmlFor="flexRadiopay2">
                                            {t("Paiement when recieving")}
                                        </label>
                                    </div>
                                </div>

                                <div className='col-lg-8 col-12 d-flex justify-content-end'>

                                    <button className='btn-add-card d-flex justify-content-center align-items-center my-2 p-1'>
                                        {t("Add a new card")}
                                    </button>
                                </div>
                            </div>
                        </div>
                        {/*///////////////////////////////////////////*/}

                        <div className='d-flex justify-content-center discount-code py-4'>

                            <Form.Control type="text" placeholder={t("Enter discount code")}
                                onChange={e => console.log(e.target.value)} />
                            <button className='btn-active-copoun '>{t("activation")}</button>

                        </div>
                        {/*///////////////////////////////////////////*/}

                        <div className='order-calc px-5'>

                            <div className='d-flex justify-content-between pb-3'>
                                <span className='second-header'>{t("Total order")}</span>
                                <span className='calc-result'>
                                    {order && order.total_price}
                                    &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                                </span>
                            </div>

                            <div className='d-flex justify-content-between pb-3'>
                                <span className='second-header'>{t("Shipping Expenses")}</span>
                                <span className='calc-result'>
                                    {shippingTypeSelect && shippingTypeSelect.settingValue}
                                    &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                                </span>
                            </div>

                            <div className='d-flex justify-content-between pb-3'>
                                <span className='second-header'>
                                    {t("Value added tax")} &nbsp;{`(${addedTaxValue && addedTaxValue.settingValue}%)`}

                                </span>
                                <span className='calc-result'>
                                    {addedTaxValue && order && taxPercent}
                                    &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                                </span>
                            </div>
                        </div>
                        {/*///////////////////////////////////////////*/}

                        <div className='d-flex justify-content-between py-4 px-5 order-total'>
                            <span className='second-header'>
                                {t("Total")}

                            </span>
                            <span className='calc-result'>
                                {totalPrice}

                                &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                            </span>
                        </div>
                        {/*///////////////////////////////////////////*/}
                        <div className='submit-order d-flex justify-content-end p-4'>
                            <button className='d-flex justify-content-center align-items-center btn-complete-order'
                                onClick={confirmOrder}
                            >
                                {t("Complete order")}
                            </button>

                        </div>
                        
                    </div>
                }
            </Fragment>
        </div>

    )
};

export default ConfirmOrder;