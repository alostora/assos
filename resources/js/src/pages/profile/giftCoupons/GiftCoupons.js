//react
import React, { useState, useEffect, Fragment } from "react";

//translate
import { useTranslation } from "react-i18next"

//material-ui
import ContentCopyOutlinedIcon from '@mui/icons-material/ContentCopyOutlined';

//component
import Loader from "../../../components/Loader";
import { axiosInstance } from "../../../axios/config";

const GiftCoupons = () => {

    //translate
    const { t } = useTranslation();

    //copy text function
    const copyTextFunction = (code) => {

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(code);

        /* Alert the copied text */
        console.log("Copied the text: " + code);

    }

    // get coupons

    const [coupons, setCoupons] = useState([])

    const [loading, setLoading] = useState(true)

    const getCoupons = async () => {

        await axiosInstance({
            method: "get",
            url: `/discountCopons`,
        })
            .then(res => res.data)
            .then(data => {
                setLoading(!data.status);
                setCoupons(data.data);
            })

            .catch((err) => console.error(err));
    }

    useEffect(() => {

        getCoupons();

    }, [])


    return (

        <Fragment>
            {loading ? <Loader /> :

                <div className="d-flex flex-column coupon-page ">

                    <span className="section-header mb-2">{t("Gift Coupons")}</span>

                    {coupons && coupons.length > 0 ?

                        <Fragment>

                            {coupons && coupons.map(coupon => (

                                <div className="row coupon-body mb-4" key={coupon.id}>

                                    <div className='d-flex flex-column px-5 py-4 col-lg-9 col-12'>

                                        <span className='header'>{t("Discount")} &nbsp;{coupon.discountValue}%</span>

                                        <div className='row copy-section my-2 px-1'>

                                            <input type="text" value={coupon.code} id="myInput" readOnly
                                                className='coupon-code px-2 d-flex justify-content-center align-items-center col-lg-10 col-8' />

                                            <button className="copy-word my-2 px-4 d-flex justify-content-center align-items-center col-lg-2 col-4"
                                                onClick={() => copyTextFunction(coupon.code)}>

                                                <ContentCopyOutlinedIcon fontSize="small" />  {t("Copy")}
                                            </button>

                                        </div>
                                        <span className="py-3 coupon-details">
                                            {`${t("Get a discount")} ${coupon.discountValue}% 
                                            ${t("when you buy a brand")} ${coupon.vendor_info && coupon.vendor_info.vendor_name}`}
                                        </span>

                                    </div>

                                    <div className="d-flex justify-content-center align-items-center col-lg-3 col-12 p-2">

                                        <div className="brand-logo_coupon ">
                                            <img src={coupon.vendor_info && coupon.vendor_info.vendor_logo}
                                                alt="brandLogo" />
                                        </div>

                                    </div>
                                </div>

                            ))}
                        </Fragment>

                        :
                        <div className='d-flex flex-column justify-content-center align-items-center my-5'>

                            <h4 className='d-flex my-3'>{t("There are no Gift Coupons at the moment")}</h4>
                        </div>
                    }
                </div>
            }
        </Fragment >
    )
};

export default GiftCoupons;