//material-ui
import AccountCircleIcon from '@mui/icons-material/AccountCircle';
import HomeRoundedIcon from '@mui/icons-material/HomeRounded';
import ArrowBackIosIcon from '@mui/icons-material/ArrowBackIos';
import ArrowForwardIosIcon from '@mui/icons-material/ArrowForwardIos';
import MenuIcon from '@mui/icons-material/Menu';
import { grey } from '@mui/material/colors';
import CreditCardRoundedIcon from '@mui/icons-material/CreditCardRounded';
import NotificationsIcon from '@mui/icons-material/Notifications';
import SmsIcon from '@mui/icons-material/Sms';
import LogoutIcon from '@mui/icons-material/Logout';

//icons
import orderIcon from '../../assets/icons/Profile/order_icon.svg'

//translate
import { useTranslation } from "react-i18next"

//react
import React, { useState } from 'react';

//redux
import { useDispatch } from 'react-redux'
import { logout } from '../../redux/actions/userActions';

//componet
import { Navbar } from 'react-bootstrap'
import { NavLink, useHistory } from "react-router-dom";


const NavProfile = () => {

    //translate
    const { t } = useTranslation();

    //for open and close nav profile
    const [expanded, setExpanded] = useState(false);

    const history = useHistory();

    const dispatch = useDispatch()

    //logout
    const logoutHandler = (e) => {

        e.preventDefault();

        dispatch(logout());

        localStorage.removeItem("api-token");

        history.push("/molk");

        window.location.reload();
    }

    return (
        <Navbar
            id="navbar"
            expand="lg"
            className='profile-nav'
            collapseOnSelect={true}
            expanded={expanded}
        >
            <Navbar.Toggle aria-controls="basic-navbar-nav" className='mb-3 toggle-btn'
                onClick={() => setExpanded(expanded ? false : true)}
            >

                <MenuIcon style={{ color: grey[500] }} />
            </Navbar.Toggle>
            <Navbar.Collapse id="basic-navbar-nav" >
                <ul className="nav flex-column w-100">
                    <li className="nav-item mb-3" onClick={() => setExpanded(false)}>
                        <NavLink
                            to="/profile/profile-info"
                            className="text-decoration-none d-flex justify-content-between link-item"
                            activeClassName="selected-link">

                            <div>
                                <AccountCircleIcon />
                                <span className='px-2'>{t("Profile")}</span>
                            </div>

                            <span className='arrow-link'>  {localStorage.getItem("i18nextLng") === "en" ?
                                <ArrowForwardIosIcon /> : <ArrowBackIosIcon />}
                            </span>
                        </NavLink>
                    </li>
                    {/*//////////////////////////////////*/}

                    <li className="nav-item mb-3" onClick={() => setExpanded(false)}>
                        <NavLink
                            to="/profile/orders"
                            className="text-decoration-none d-flex justify-content-between link-item"
                            activeClassName="selected-link">

                            <div>
                                <img src={orderIcon} alt="orderIcon" width="20px" height="20px" />
                                <span className='px-2'>{t("Orders")}</span>
                            </div>

                            <span className='arrow-link'>  {localStorage.getItem("i18nextLng") === "en" ?
                                <ArrowForwardIosIcon /> : <ArrowBackIosIcon />}
                            </span>
                        </NavLink>
                    </li>
                    {/*//////////////////////////////////*/}

                    <li className="nav-item mb-3" onClick={() => setExpanded(false)}>
                        <NavLink
                            to="/profile/address"
                            className="text-decoration-none d-flex justify-content-between link-item"
                            activeClassName="selected-link">

                            <div>
                                <HomeRoundedIcon />
                                <span className='px-2'>{t("Address")}</span>
                            </div>

                            <span className='arrow-link'>  {localStorage.getItem("i18nextLng") === "en" ?
                                <ArrowForwardIosIcon /> : <ArrowBackIosIcon />}
                            </span>
                        </NavLink>
                    </li>
                    {/*//////////////////////////////////*/}

                    <li className="nav-item mb-3" onClick={() => setExpanded(false)}>
                        <NavLink
                            to="/profile/payment-methods"
                            className="text-decoration-none d-flex justify-content-between link-item"
                            activeClassName="selected-link">

                            <div>
                                <CreditCardRoundedIcon />
                                <span className='px-2'>{t("Payment Methods")}</span>
                            </div>

                            <span className='arrow-link'>  {localStorage.getItem("i18nextLng") === "en" ?
                                <ArrowForwardIosIcon /> : <ArrowBackIosIcon />}
                            </span>
                        </NavLink>
                    </li>
                    {/*//////////////////////////////////*/}

                    <li className="nav-item mb-3" onClick={() => setExpanded(false)}>
                        <NavLink
                            to="/profile/notifications"
                            className="text-decoration-none d-flex justify-content-between link-item"
                            activeClassName="selected-link">

                            <div>
                                <NotificationsIcon />
                                <span className='px-2'>{t("Notifications")}</span>
                            </div>

                            <span className='arrow-link'>  {localStorage.getItem("i18nextLng") === "en" ?
                                <ArrowForwardIosIcon /> : <ArrowBackIosIcon />}
                            </span>
                        </NavLink>
                    </li>
                    {/*//////////////////////////////////*/}

                    <li className="nav-item mb-3" onClick={() => setExpanded(false)}>
                        <NavLink
                            to="/profile/communication-preferences"
                            className="text-decoration-none d-flex justify-content-between link-item"
                            activeClassName="selected-link">

                            <div>
                                <SmsIcon />
                                <span className='px-2'>{t("Communication Preferences")}</span>
                            </div>

                            <span className='arrow-link'>  {localStorage.getItem("i18nextLng") === "en" ?
                                <ArrowForwardIosIcon /> : <ArrowBackIosIcon />}
                            </span>
                        </NavLink>
                    </li>
                    {/*//////////////////////////////////*/}

                    <li className="nav-item mb-3" onClick={(e) => {
                        logoutHandler(e);
                        setExpanded(false);
                    }}>
                        <NavLink
                            to="/molk"
                            className="text-decoration-none d-flex justify-content-between link-item"
                            activeClassName="selected-link">

                            <div>
                                <LogoutIcon />
                                <span className='px-2'>{t("Log Out")}</span>
                            </div>

                            <span className='arrow-link'>  {localStorage.getItem("i18nextLng") === "en" ?
                                <ArrowForwardIosIcon /> : <ArrowBackIosIcon />}
                            </span>
                        </NavLink>
                    </li>
                    {/*//////////////////////////////////*/}
                </ul>
            </Navbar.Collapse>
        </Navbar>
    )
};

export default NavProfile;