//icons
//import vipCrownIcon from './../../assets/icons/Home/vip-crown-line.svg'
import offerIcon from './../../assets/icons/Home/Group 9.svg'
import qrScanImg from './../../assets/icons/Home/Group 13019.svg'
import mobilhomeImg from './../../assets/icons/Home/05_home___1 1.png'

import storeIcon1 from './../../assets/icons/Home/Mobile app store badge.svg'
import storeIcon2 from './../../assets/icons/Home/Mobile app store badge (1).svg'
import storeIcon3 from './../../assets/icons/Home/Mobile app store badge (2).svg'

// icons material-ui
//import LocalShippingOutlinedIcon from '@mui/icons-material/LocalShippingOutlined';
//import MoodOutlinedIcon from '@mui/icons-material/MoodOutlined';

//react
import React, { useEffect, Fragment } from "react"
import { useTranslation } from "react-i18next";
import { Link, useHistory } from 'react-router-dom'

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getHomePage } from "../../redux/actions/homeActions";

//components
import Carousel from 'react-bootstrap/Carousel'
import Item from './../../components/Item'
import Brand from './Brand'
import BrandLogo from '../../components/BrandLogo'
import Loader from "../../components/Loader"


export default function Home({ brands }) {

    //translate
    const { t } = useTranslation();

    // for route
    const history = useHistory()

    //route ads
    const routeUrl = (categoryName, categoryId, brandName, brandId) => {

        if (categoryId) {
            return `/sub-categories/${categoryName}/${brandName}/${categoryId}/${brandId}`
        } else {
            return `/brands-categories/${brandName}/${brandId}`
        }

    }

    // fetch from api
    const dispatch = useDispatch()

    const { loading, homePage, error } = useSelector(state => state.homePage)


    useEffect(() => {

        dispatch(getHomePage())

    }, [dispatch, error])

    return (
        <Fragment >
            {loading ? <Loader /> :
                <div className="home d-flex flex-column ">

                    {/* /////////////////////////////////////////////////////////////////////// */}
                    {/* <div className="details-header d-flex align-items-center text-nowrap flex-wrap mx-auto py-1">
                        <div className="details-name px-4">

                            <LocalShippingOutlinedIcon />
                            <span className="px-1">{t("Free Shipping Above 299 SAR")}</span>
                        </div>
                        <div className="details-name px-4">
                            <MoodOutlinedIcon />
                            <span className="px-1">{t("24 hour technical support")}</span>
                        </div>
                        <div className="details-name px-4">
                            <img src={vipCrownIcon} alt="vip Crown Icon" />
                            <span className="px-1">{t("original products")} </span>
                        </div>
                    </div> */}
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <Carousel
                        nextIcon={<span aria-hidden="false" />}
                        prevIcon={<span aria-hidden="false" />}
                        className="home-carousel mt-5">

                        {homePage && homePage.sliders.map(slider => (
                            <Carousel.Item interval={1000} key={slider.id}>

                                <img src={slider.image} alt="Carousel Img" />

                            </Carousel.Item>
                        ))}
                    </Carousel>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="d-flex flex-column justify-content-center align-items-center brand-section container px-0">
                        <span className="section-title mb-3">{t("Shop by Brand")}</span>

                        <div className="row mx-0 brand-items justify-content-center w-100">

                            {brands && brands.map(br => (

                                <div className="col-lg-3 col-6 mb-4 " key={br.id}>

                                    <Brand brand={br} />
                                </div>
                            ))}

                        </div>

                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="d-flex justify-content-center align-items-center offer-section container">

                        <a href={`${homePage && homePage.banner && homePage.banner.link}`} target="_blank">
                            <img src={homePage && homePage.banner && homePage.banner.image} alt="offer Icon"
                                onError={(e) => { e.target.onerror = null; e.target.src = offerIcon }}
                            />
                        </a>
                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="best-offer-section d-flex flex-column container mt-4">

                        <span className="best-offer-word mb-4">{t("Best offers")}</span>

                        <div className="row mx-0 items w-100">

                            {homePage && homePage.itemMayLike.filter((item, index) => index <= 7).map(it =>
                                <div className='col-lg-3 col-6 mb-2' key={it.id}>

                                    <Item item={it} />

                                </div>
                            )}

                        </div>

                        <div className="d-flex justify-content-center my-4">
                            <button className="btn-more"
                                onClick={(e) => {
                                    e.preventDefault();
                                    return history.push("/see-more/itemMayLike");
                                }}  >
                                {t("Browse more")}</button>
                        </div>

                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="brands-offers d-flex flex-column justify-content-center mb-3 container-fluid">
                        <div className='container'>

                            <span className="header d-flex justify-content-center my-4">{t("Brands Offers")}</span>

                            <div className="row justify-content-center align-items-center mb-3">

                                {homePage && homePage.ads.filter((item, index) => index <= 1).map(ad => (


                                    <div className='col-6 my-3' key={ad.id}>

                                        <Link to={() => routeUrl(ad.categoryName, ad.cat_id, ad.vendor_name, ad.vendor_id)}
                                            className="text-decoration-none">

                                            <img src={ad.adImage} alt="adds Icon" className="item-offer-lg" />
                                        </Link>

                                    </div>
                                ))}

                                {homePage && homePage.ads.filter((item, index) => index > 1).map(ad => (

                                    <div className='col-lg-4 col-6 my-3' key={ad.id}>
                                        <Link to={() => routeUrl(ad.categoryName, ad.cat_id, ad.vendor_name, ad.vendor_id)}
                                            className="text-decoration-none ">

                                            <img src={ad.adImage} alt="adds Icon" className="item-offer-sm" />
                                        </Link>
                                    </div>
                                ))}

                            </div>
                        </div>
                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="fashion-section d-flex flex-column container mt-4 px-0">
                        <span className="header mb-4 mx-2">{t("Recently Seen")}</span>

                        <div className="row mx-0 items w-100 ">
                            {homePage && homePage.recentItems.filter((item, index) => index <= 7).map(it =>
                                <div className='col-lg-3 col-6 mb-2' key={it.id}>

                                    <Item item={it} />

                                </div>
                            )}

                        </div>
                        <div className="d-flex justify-content-center my-4">
                            <button className="btn-more "
                                onClick={(e) => {
                                    e.preventDefault();
                                    return history.push("/see-more/recentItems");
                                }}  >
                                {t("Browse more")}</button>
                        </div>
                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="brands-papular d-flex flex-column mt-4 mb-3 container px-0">
                        <span className="header d-flex justify-content-center mb-4">{t("Most Popular Brands")}</span>

                        <div className="row mx-0 justify-content-center align-items-center w-100">
                            {brands && brands.map(br => (

                                <BrandLogo brand={br} key={br.id} />
                            ))}

                        </div>
                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className='container-fluid download-section my-4'>

                        <div className="d-flex justify-content-center align-items-center container">
                            <div className='row mx-0 w-100'>

                                <div className="list d-flex justify-content-center align-items-center col-12 col-lg-4">
                                    <ul>
                                        <li>{t("Full support for all platforms")}</li>
                                        <li>{t("Easy access at any time")}</li>
                                        <li>{t("More offers and gifts")}</li>
                                        <li>{t("Exclusive features of the application")}</li>
                                    </ul>
                                </div>
                                <div className="qr-scan d-flex flex-column justify-content-center align-items-center col-6 col-lg-4">
                                    <span className="header pb-2">{t("Download")}</span>
                                    <img src={qrScanImg} alt="qrScan Img" width="160px" height="160px" />
                                </div>

                                <div className="mobil-img d-flex col-6 col-lg-4">
                                    <img src={mobilhomeImg} alt="mobilhome Img" width="300px" height="auto" />
                                </div>
                            </div>
                        </div>

                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}
                    <div className='container mt-3'>

                        <div className="store-download row justify-content-center align-items-center">
                            <button className='col-4'> <img src={storeIcon1} alt="store Icon" /></button>
                            <button className='col-4'> <img src={storeIcon2} alt="store Icon" /></button>
                            <button className='col-4'> <img src={storeIcon3} alt="store Icon" /></button>
                        </div>
                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                </div>
            }
        </Fragment>
    )
}

