//icons
import logoIcon from './../../assets/icons/Home/Group.svg'
import nameLogoIcon from './../../assets/icons/Home/Group (1).svg'
import orderIcon from '../../assets/icons/Profile/order_icon.svg'

//icons material-ui
import FavoriteBorderRoundedIcon from '@mui/icons-material/FavoriteBorderRounded';
import NotificationsNoneOutlinedIcon from '@mui/icons-material/NotificationsNoneOutlined';
import LocalGroceryStoreOutlinedIcon from '@mui/icons-material/LocalGroceryStoreOutlined';
import Paper from '@mui/material/Paper';
import InputBase from '@mui/material/InputBase';
import IconButton from '@mui/material/IconButton';
import SearchIcon from '@mui/icons-material/Search';
import Badge from '@mui/material/Badge';
import MenuIcon from '@mui/icons-material/Menu';
import { grey } from '@mui/material/colors';
import LogoutIcon from '@mui/icons-material/Logout';
import AccountCircleIcon from '@mui/icons-material/AccountCircle';
import LocationOnRoundedIcon from '@mui/icons-material/LocationOnRounded';
import CreditCardRoundedIcon from '@mui/icons-material/CreditCardRounded';
import NotificationsIcon from '@mui/icons-material/Notifications';
//import SmsIcon from '@mui/icons-material/Sms';
import CardGiftcardIcon from '@mui/icons-material/CardGiftcard';

//translate
import { useTranslation } from "react-i18next"

//react
import React, { useState, useEffect, useRef, Fragment } from 'react'
import { Link, NavLink, useHistory } from "react-router-dom";

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getSearchProducts } from './../../redux/actions/searchActions'
import { getFavoriteItems } from './../../redux/actions/favoriteActions'
import { getOrder } from '../../redux/actions/orderActions';
import { logout } from '../../redux/actions/userActions';

//components
import { Navbar, Dropdown } from 'react-bootstrap'
import Loader from '../Loader';


const NavBar = () => {

    //translate
    const { t } = useTranslation();

    const history = useHistory();

    const [expanded, setExpanded] = useState(false);

    const [inputText, setInputText] = useState("");

    // fetch from api for search
    const dispatch = useDispatch()

    //favorite Items
    const { favoriteItems } = useSelector(state => state.favoriteItems)
    /////////////////////////////////////////

    //cart items 
    const { order } = useSelector(state => state.order)

    const cartItems = order ? order.order_items : [];

    const cartItemsLength = cartItems && cartItems.length > 0 ?
        cartItems.map(it => it.item_count).reduce((previous, current) => previous + current) : 0 ;

    ////////////////////////////////////////////////////

    // search products
    const { loading, products, error } = useSelector(state => state.searchProducts)

    const searchItems = products ? products.data : [];
    ////////////////////////////////////////////////////

    useEffect(() => {

        //search
        dispatch(getSearchProducts({
            itemNameSearch: inputText,
        }))

        //favorite
        dispatch(getFavoriteItems())

        //cart
        dispatch(getOrder())

    }, [dispatch, inputText, error])

    //show and hidden search items 
    const [show, setShow] = useState(false);

    const ref = useRef(null);

    const handleClickOutside = (event) => {
        if (ref.current && !ref.current.contains(event.target)) {

            setShow(false);
        }
    };

    useEffect(() => {
        document.addEventListener("click", handleClickOutside, true);
        return () => {
            document.removeEventListener("click", handleClickOutside, true);
        };
    });
    ///////////////////////////////////////////////////////////

    // search input function
    const searchInput = (e) => {

        e.preventDefault();

        if (e.target.value.trim() === "") {

            setShow(false)
        }

        setInputText(e.target.value)

        setShow(true)
    }

    ////////////////////////////////////////////////////////////////////

    // login
    const { user } = useSelector(state => state.auth)

    /////////////////////////////////////////////////////////////

    //logout
    const logoutHandler = (e) => {

        e.preventDefault();

        dispatch(logout())

        localStorage.removeItem("api-token");

        return history.push("/")
    }

    return (
        <Navbar
            id="navbar"
            expand="lg"
            className="navbar navbar-expand-lg navbar-light px-0 nav-header py-4 container"
            collapseOnSelect={true}
            expanded={expanded}>
            <div className="container-fluid">
                <NavLink
                    to="/"
                    activeClassName="selected"
                    className="text-decoration-none"
                >
                    <div className="logo d-flex align-items-center px-5">
                        <img src={logoIcon} alt="logo Icon" width="52.85px" height="54px" />
                        <img src={nameLogoIcon} alt="name Logo Icon" width="89.83px" height="33.48px" />

                    </div>
                </NavLink>
                {/* //////////////////////////////////// */}

                <div className="d-flex flex-row order-2 order-lg-3">

                    <Navbar.Toggle
                        aria-controls="basic-navbar-nav"
                        className="toggle-nav-btn"
                        onClick={() => setExpanded(expanded ? false : true)}>

                        <MenuIcon style={{ color: grey[500] }} />
                    </Navbar.Toggle>
                </div>
                {/* //////////////////////////////////// */}

                <Navbar.Collapse id="basic-navbar-nav" className="order-3 order-lg-2 py-2">
                    <ul className="navbar-nav ">
                        <li className="nav-item py-1 search-section px-1 col-xl-7 col-lg-5 col-md-12 col-12">

                            <Paper
                                component="form"
                                sx={{ p: '1px 1px', display: 'flex', alignItems: 'center', height: 60 }}
                                className="search-form px-4">

                                <InputBase
                                    sx={{ ml: 1, flex: 1 }}
                                    placeholder={t("Search for what you want")}
                                    onChange={(e) => searchInput(e)}

                                    onKeyPress={(event) => {
                                        if (event.key === 'Enter') {
                                            event.preventDefault();
                                            setShow(false);
                                            setExpanded(false);
                                            return history.push(`/search/?product=${inputText.replace(" ", "_")}`)
                                        }
                                    }}
                                />

                                <IconButton type="submit" sx={{ p: '10px' }} aria-label="search" className='btn-search'
                                    onClick={(event) => {
                                        event.preventDefault();
                                        setExpanded(false)
                                        setShow(false);
                                        return history.push(`/search/?product=${inputText.replace(" ", "_")}`)
                                    }}>

                                    <SearchIcon />
                                </IconButton>

                            </Paper>

                            {show &&

                                <div className='suggestions d-flex flex-column' ref={ref}>

                                    {loading ? <Loader /> :

                                        <Fragment>

                                            {searchItems && searchItems.map(item => (

                                                <Link
                                                    to={`/search/?product=${item.itemName.replace(" ", "_")}`}
                                                    className="text-decoration-none suggestion" key={item.id}
                                                    onClick={() => {
                                                        setShow(false)
                                                        setInputText(item.itemName)
                                                    }} >

                                                    {item.itemName}
                                                </Link>

                                            ))}
                                        </Fragment>
                                    }
                                </div>
                            }

                        </li>
                        {/* //////////////////////////////////// */}

                        <li className="nav-item d-flex align-items-center py-1">

                            <Link
                                to="/favorite"
                                className="text-decoration-none d-flex align-items-center justify-content-center fav-btn"
                                onClick={() => setExpanded(false)}>

                                <Badge badgeContent={favoriteItems && favoriteItems.length} color="error">
                                    <FavoriteBorderRoundedIcon />
                                </Badge>

                            </Link>

                            <Link
                                to="/"
                                className="text-decoration-none d-flex align-items-center justify-content-center notifi-btn"
                                onClick={() => setExpanded(false)}>

                                <NotificationsNoneOutlinedIcon />

                            </Link>

                            <Link
                                to="/cart"
                                className="text-decoration-none d-flex align-items-center justify-content-center cart-btn"
                                onClick={() => setExpanded(false)}>

                                <Badge badgeContent={cartItemsLength} color="error">
                                    <LocalGroceryStoreOutlinedIcon />
                                </Badge>

                            </Link>

                        </li>
                        {/* //////////////////////////////////// */}

                        <li className="nav-item d-flex align-items-center py-1 px-4">
                            {user ?

                                <Dropdown className='dropdown-user-profile '>
                                    <Dropdown.Toggle variant="secondary" id="dropdown-basic" className='btn-toggle-user-info '>
                                        <span className='px-1'>{user.name}</span>
                                    </Dropdown.Toggle>

                                    <Dropdown.Menu className='dropdown-user-profile-item'>
                                        <Dropdown.Item
                                            className='d-flex align-items-center py-2'
                                            onClick={(e) => {
                                                e.preventDefault();
                                                history.push("/profile/profile-info");
                                                window.location.reload();
                                            }}>
                                            <AccountCircleIcon />
                                            <span className='px-1'>{t("Profile")}</span>
                                        </Dropdown.Item>
                                        {/*//////////////////////////////////*/}

                                        <Dropdown.Item
                                            className='d-flex align-items-center py-2'
                                            onClick={(e) => {
                                                e.preventDefault();
                                                history.push("/profile/order");
                                                window.location.reload();
                                            }}>

                                            <img src={orderIcon} alt="orderIcon" width="20px" height="20px" />
                                            <span className='px-1'>{t("Orders")}</span>

                                        </Dropdown.Item>
                                        {/*//////////////////////////////////*/}

                                        <Dropdown.Item className='d-flex align-items-center py-2'
                                            onClick={(e) => {
                                                e.preventDefault();
                                                history.push("/profile/address");
                                                window.location.reload();
                                            }}>
                                            <LocationOnRoundedIcon />
                                            <span className='px-1'>{t("Address")}</span>
                                        </Dropdown.Item>
                                        {/*//////////////////////////////////*/}

                                        <Dropdown.Item className='d-flex align-items-center py-2'
                                            onClick={(e) => {
                                                e.preventDefault();
                                                history.push("/profile/payment-methods");
                                                window.location.reload();
                                            }}>
                                            <CreditCardRoundedIcon />
                                            <span className='px-1'>{t("Payment Methods")}</span>
                                        </Dropdown.Item>
                                        {/*//////////////////////////////////*/}

                                        <Dropdown.Item className='d-flex align-items-center py-2'
                                            onClick={(e) => {
                                                e.preventDefault();
                                                history.push("/profile/notifications");
                                                window.location.reload();
                                            }}>
                                            <NotificationsIcon />
                                            <span className='px-1'>{t("Notifications")}</span>
                                        </Dropdown.Item>
                                        {/*//////////////////////////////////*/}

                                        {/* <Dropdown.Item className='d-flex align-items-center py-2'
                                            onClick={(e) => {
                                                e.preventDefault();
                                                history.push("/profile/communication-preferences");
                                                window.location.reload();
                                            }}>
                                            <SmsIcon />
                                            <span className='px-1'>{t("Communication Preferences")}</span>
                                        </Dropdown.Item> */}
                                        {/*//////////////////////////////////*/}

                                        <Dropdown.Item
                                            className='d-flex align-items-center py-2'
                                            onClick={(e) => {
                                                e.preventDefault();
                                                history.push("/profile/gift-coupons");
                                                window.location.reload();
                                            }}>

                                            <CardGiftcardIcon />
                                            <span className='px-1'>{t("Gift Coupons")}</span>

                                        </Dropdown.Item>
                                        {/*//////////////////////////////////*/}

                                        <Dropdown.Item
                                            className='d-flex align-items-center py-2'
                                            onClick={logoutHandler}>

                                            <LogoutIcon />
                                            <span className='px-1'>{t("Log Out")}</span>

                                        </Dropdown.Item>

                                    </Dropdown.Menu>
                                </Dropdown>

                                : <button className="login-btn d-flex justify-content-center align-items-center p-4"
                                    onClick={(event) => {
                                        event.preventDefault();
                                        setExpanded(false)
                                        return history.push(`/login`)
                                    }}>
                                    <span className="userName text-nowrap px-1">

                                        {t("Login")}
                                    </span>

                                </button>}

                        </li>
                        {/* //////////////////////////////////// */}

                    </ul>
                </Navbar.Collapse>
            </div>
        </Navbar>

    )
}

export default NavBar