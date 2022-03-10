//icons
import TikTokIcon from './../assets/icons/Home/TikTok .svg'
import SnapchatIcon from './../assets/icons/Home/Snapchat .svg'
import YouTubeIcon from './../assets/icons/Home/YouTube .svg'
import InstagramIcon from './../assets/icons/Home/Instagram .svg'
import TwitterIcon from './../assets/icons/Home/Twitter.svg'
import FacebookIcon from './../assets/icons/Home/Facebook .svg'
import logoNameWhite from './../assets/icons/Home/logo-word-white.svg'
import logoIcon from './../assets/icons/Home/Group.svg'

//translate
import { useTranslation } from "react-i18next";

//react router
import { Link } from 'react-router-dom'


const Footer = ({ categories, brands }) => {

    //translate
    const { t } = useTranslation();

    return (
        <div className="footer d-flex flex-column justify-content-center align-items-center mt-5">

            <div className="social d-flex flex-column justify-content-center align-items-center">
                <span className="header my-3">{t("Follow us to find out what's new")}</span>
                <div className="social-icons row justify-content-center mb-2 ">

                    <a href="https://www.tiktok.com/" target="_blank" className='col-2 social-icon'>
                        <img src={TikTokIcon} alt="TikTok Icon" />
                    </a>

                    <a href="https://www.snapchat.com/" target="_blank" className='col-2 social-icon'>
                        <img src={SnapchatIcon} alt="Snapchat Icon" />
                    </a>

                    <a href="https://www.youtube.com/" target="_blank" className='col-2 social-icon'>
                        <img src={YouTubeIcon} alt="YouTube Icon" />
                    </a>

                    <a href="https://www.instagram.com/" target="_blank" className='col-2 social-icon'>
                        <img src={InstagramIcon} alt="Instagram Icon" />
                    </a>

                    <a href="https://twitter.com/" target="_blank" className='col-2 social-icon'>
                        <img src={TwitterIcon} alt="Twitter Icon" />
                    </a>

                    <a href="https://www.facebook.com/" target="_blank" className='col-2 social-icon'>
                        <img src={FacebookIcon} alt="Facebook Icon" />
                    </a>

                </div>
            </div>
            {/* /////////////////////////////////////////////////////////////////////// */}

            <div className="footer-info d-flex flex-column justify-content-center align-items-center ">

                <div className="logo my-4">
                    <img src={logoIcon} alt="logo Icon" width="77px" height="78px" />
                    <img src={logoNameWhite} alt="name Logo Icon" width="130px" height="49px" />

                </div>

                <div className='container px-5'>

                    <div className="lists row mt-2">

                        <div className="list col-12 col-lg-4">
                            <span className="name-list ">{t("Brands")}</span>
                            <ul className='row'>
                                {brands && brands.map(brand => (

                                    <li className='col-6' key={brand.id}>

                                        <Link to={`/brands-categories/${brand.vendor_name}/${brand.id}`}
                                            className="text-decoration-none d-flex brand-route">

                                            {brand.vendor_name}

                                        </Link>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        {/* ////////////////////////// */}

                        <div className="list col-12 col-lg-4">
                            <span className="name-list">{t("Categories")}</span>
                            <ul className='row'>
                                {categories && categories.map(category =>

                                    <li className='col-6' key={category.id}>

                                        {category.categoryName}
                                    </li>
                                )}
                            </ul>
                        </div>
                        {/* ////////////////////////// */}

                        <div className="list col-12 col-lg-4">
                            <span className="name-list">{t("About Molk")}</span>
                            <ul className='row'>

                                <li className='col-6'>

                                    <Link to="/molk/About-Us/5"
                                        className="text-decoration-none d-flex brand-route">

                                        {t("About Us")}
                                    </Link>
                                </li>

                                <li className='col-6'>

                                    <Link to="/molk/Privacy-Policies/3"
                                        className="text-decoration-none d-flex brand-route">

                                        {t("Privacy Policies")}
                                    </Link>

                                </li>

                                <li className='col-6'>

                                    <Link to="/molk/Our-Vision/2"
                                        className="text-decoration-none d-flex brand-route">

                                        {t("Our Vision")}
                                    </Link>

                                </li>

                                <li className='col-6'>

                                    <Link to="/molk/Return-Policy/4"
                                        className="text-decoration-none d-flex brand-route">

                                        {t("Return Policy")}
                                    </Link>

                                </li>

                                <li className='col-6'>

                                    <Link to="/molk/Help/6"
                                        className="text-decoration-none d-flex brand-route">

                                        {t("Help")}
                                    </Link>

                                </li>

                                <li className='col-6'>

                                    <Link to="/molk/Contact-Us/send-form"
                                        className="text-decoration-none d-flex brand-route">

                                        {t("Contact Us")}
                                    </Link>

                                </li>
                            </ul>

                        </div>
                        {/* ////////////////////////// */}

                    </div>
                </div>
                {/* /////////////////////////////////////////////////////////////////////// */}

                <div className="owner d-flex justify-content-center align-items-center p-2">
                    <span>{t("All Copyrights Reserved")}</span>
                </div>

            </div>
        </div>
    )
}

export default Footer;

