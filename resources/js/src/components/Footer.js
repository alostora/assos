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
                <div className="social-icons row justify-content-center mb-2">
                    <button className='col-2'> <img src={TikTokIcon} alt="TikTok Icon" /></button>
                    <button className='col-2'> <img src={SnapchatIcon} alt="Snapchat Icon" /></button>
                    <button className='col-2'> <img src={YouTubeIcon} alt="YouTube Icon" /></button>
                    <button className='col-2'> <img src={InstagramIcon} alt="Instagram Icon" /></button>
                    <button className='col-2'> <img src={TwitterIcon} alt="Twitter Icon" /></button>
                    <button className='col-2'> <img src={FacebookIcon} alt="Facebook Icon" /></button>
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
                                <li className='col-6'>{t("who are we")}</li>
                                <li className='col-6'>{t("Our goal")}</li>

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

