//react
import React, { useEffect, useState, createContext, useCallback } from "react";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import { axiosInstance } from "./axios/config";

// redux
import { useDispatch } from 'react-redux'

//style
import "./App.scss";
import "bootstrap/dist/css/bootstrap.min.css";

//components
import NavBar from "./components/navbar/Navbar";
import Categories from "./components/Categories";
import Footer from "./components/Footer";
import Header from "./components/Header";
import ScrollToTop from "./components/ScrollToTop";

//pages
import Home from "./pages/home/Home";
import ProductDetails from "./pages/productDetails/ProductDetails";
import Search from "./pages/search/Search";
import NotFound from "./pages/notFound/NotFound";
import Brands from "./pages/brands/Brands";
import RecentItems from "./pages/recentItems/RecentItems";
import LastChance from "./pages/lastChance/LastChance";
import SeeMore from "./pages/seeMorePage/SeeMore";
import BrandCategories from "./pages/brandCategories/BrandCategories";
import Favorite from "./pages/favorite/Favorite";
import Cart from './pages/cart/Cart'
import SubCategories from "./pages/subCategories/SubCategories";
import CategoryItems from "./pages/categoryItems/CategoryItems";
import Login from "./pages/login/Login";
import Register from "./pages/register/Register";
import ConfirmOrder from "./pages/confirmOrder/ConfirmOrder";
import Profile from "./pages/profile/Profile";
import ConfirmOrderDone from "./pages/confirmOrder/ConfirmOrderDone";
import PrivacyPolicies from "./pages/privacyPolicies/PrivacyPolicies";
import OfferItems from "./pages/offerItems/OfferItems";


//function for user data
import { getUserProfile } from "./redux/actions/userActions";
import { getAddress } from "./redux/actions/addressActions";

// firebase
// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

// mode context
export const ThemeContext = createContext();

// country context
export const CountryContext = createContext();


function App() {

  //firebase
  const firebaseConfig = {
    apiKey: "AIzaSyDXGZlgYyzF0ZfbLkXpr74uvOQyWQRvnWc",
    authDomain: "molk-7daf8.firebaseapp.com",
    projectId: "molk-7daf8",
    storageBucket: "molk-7daf8.appspot.com",
    messagingSenderId: "688587750859",
    appId: "1:688587750859:web:d1de7f059562ccc3aa4a4e"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);

  const messaging = getMessaging();

  const KeyPair =
    "BKbV8KgRfpxV0C4eevbItBcG1NtYIWx9BW_a42S_Zr-pngQWko_yjBweTjXuhAmj0n4nB7arycpV_J_P82fwRfE";


  const getTokenListener = () => {

    getToken(messaging, { vapidKey: KeyPair })
      .then(async (currentToken) => {
        if (currentToken) {
          //console.log("currentToken ::", currentToken);

          await axiosInstance({
            method: "post",
            url: `/userCountery`,
            data: {
              country: localStorage.getItem("country") || "ku",
              deviceId: localStorage.getItem("device-id") || "",
              web_lang: localStorage.getItem("i18nextLng") || "en",
              firebase_token: currentToken
            },
          })
            .then((res) => res.data)
            .then((data) => console.log("set devide id", data))
            .catch((err) => console.error(err));

        } else {
          console.log(
            "No registration token available. Request permission to generate one."
          );
        }
      })
      .catch((err) => {
        console.log("An error occurred while retrieving token. ", err);
      });
  }

  ///////////////////////////////
  const onMessageListener = () =>
    new Promise((resolve) => {
      onMessage(messaging, payload => {
        resolve(payload);
      });
    });
  ////////////////////////////////////////////////////////////////////////

  // mode
  const [mode, setMode] = useState(localStorage.getItem("modeColor") || "light")

  // country
  const [country, setCountry] = useState(localStorage.getItem("country") || "ku")

  // for only preview filter search from api
  const [categories, setCategories] = useState([])
  const [brands, setBrands] = useState([])
  const [properties, setProperties] = useState({})
  const [sortType, setSortType] = useState([])
  const [recentItems, setRecentItems] = useState([])
  const [lastChanceItems, setLastChanceItems] = useState([])
  const [privacyPolicies, setPrivacyPolicies] = useState([])


  // for user profile
  const dispatch = useDispatch()

  const fetchFromApi = useCallback(async () => {

    // firebase token 
    getTokenListener()

    // firebase msg
    onMessageListener()
      .then((payload) => payload)
      .then((data) => console.log("notifi", data.notification))
      .catch((err) => console.log("failed: ", err));

    //categories
    await axiosInstance({
      method: "get",
      url: `/categories`,
    })
      .then((res) => res.data)
      .then((data) => setCategories(data.data.categories))
      .catch((err) => console.error(err));

    //brands vendors
    await axiosInstance({
      method: "get",
      url: `/vendors`,
    })
      .then((res) => res.data)
      .then((data) => setBrands(data.vendors))
      .catch((err) => console.error(err));

    //Properties [size, color]
    await axiosInstance({
      method: "get",
      url: `/properties`,
    })
      .then((res) => res.data)
      .then((data) => setProperties({
        color: data.color,
        clothes_size: data.clothes_size,
        shoes_size: data.shoes_size
      }))
      .catch((err) => console.error(err));

    ///sortType
    await axiosInstance({
      method: "get",
      url: `/sortType`,
    })
      .then((res) => res.data)
      .then((data) => setSortType(data.sortType))
      .catch((err) => console.error(err));

    //recent items
    await axiosInstance({
      method: "get",
      url: `/seeMore/recentItems`,
    })
      .then((res) => res.data)
      .then((data) => setRecentItems(data.items.data))
      .catch((err) => console.error(err));

    //last chance items
    await axiosInstance({
      method: "get",
      url: `/allOfferItems`,
    })
      .then((res) => res.data)
      .then((data) => setLastChanceItems(data.data))
      .catch((err) => console.error(err));

    //privacy policies
    await axiosInstance({
      method: "get",
      url: `/privacy_policies`,
    })
      .then((res) => res.data)
      .then((data) => setPrivacyPolicies(data.data))
      .catch((err) => console.error(err));

  }, [])

  useEffect(() => {

    fetchFromApi()

    dispatch(getUserProfile())

    //user address
    dispatch(getAddress())

  }, [fetchFromApi, dispatch]);

  useEffect(() => {

    const uniqueDeviceId = Math.random().toString(36).substring(2, 20).concat(Math.random().toString(36).substring(2, 20));

    if (!localStorage.getItem("device-id")) {
      localStorage.setItem("device-id", uniqueDeviceId)
    }

    if (!localStorage.getItem("country")) {
      localStorage.setItem("country", "kw")
    }

  }, []);

  return (
    <>
      <Router basename="/molk">
        <ScrollToTop />
        <ThemeContext.Provider value={{ mode, setMode }} >
          <div className={`App App-${mode}`}>

            <CountryContext.Provider value={{ country, setCountry }}>
              <Header />
              <NavBar />
              <Categories />

              <Switch>

                <Route exact path={["/molk", "/"]} render={() => <Home brands={brands} />} />
                <Route exact path={`/product-details/:id`} render={() => <ProductDetails />} />
                <Route exact path={`/search`} render={() =>
                  <Search categories={categories} brands={brands} properties={properties} sortType={sortType} />} />

                <Route exact path={'/brands'} render={() => <Brands brands={brands} />} />
                <Route exact path={'/recent-items'} render={() => <RecentItems recentItems={recentItems} />} />
                <Route exact path={'/last-chance'} render={() => <LastChance lastChanceItems={lastChanceItems} />} />
                <Route exact path={'/offer-items/:offer_id'} render={() => <OfferItems />} />
                <Route exact path={'/brands-categories/:name/:id'} render={() => <BrandCategories />} />
                <Route exact path={'/sub-categories/:category_name/:brand_name/:category_id/:brand_id'} render={() => <SubCategories />} />
                <Route exact
                  path={`/category-items/:subCategory_name/:subCategory_id/:category_name/:category_id/:brand_name/:brand_id`}
                  render={() => <CategoryItems />} />

                <Route exact path={'/favorite'} render={() => <Favorite />} />
                <Route exact path={'/cart'} render={() => <Cart />} />

                <Route exact path={'/login'} render={() => <Login />} />
                <Route exact path={'/register'} render={() => <Register />} />

                <Route exact path={["/profile", "/profile/:name_link", "/profile/:name_link/:name_sub_link"]} render={() => <Profile />} />

                <Route exact path={'/confirm-order/:order_id'} render={() => <ConfirmOrder />} />
                <Route exact path={'/confirm-order-done/:order_id'} render={() => <ConfirmOrderDone />} />

                <Route exact path={'/see-more/:category_items'} render={() => <SeeMore />} />

                <Route exact path={'/molk/:section_name/:section_id'} render={() => <PrivacyPolicies privacyPolicies={privacyPolicies} />} />

                <Route path="*"><NotFound /></Route>

              </Switch>

              <Footer categories={categories} brands={brands} />
            </CountryContext.Provider>

          </div>
        </ThemeContext.Provider>
      </Router>
    </>
  );
}

export default App;
