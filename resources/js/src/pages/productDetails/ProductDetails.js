// icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import { grey } from '@mui/material/colors';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import ExpandMoreOutlinedIcon from '@mui/icons-material/ExpandMoreOutlined';
import CloseRoundedIcon from '@mui/icons-material/CloseRounded';
import PlayCircleFilledRoundedIcon from '@mui/icons-material/PlayCircleFilledRounded';
import CheckRoundedIcon from '@mui/icons-material/CheckRounded';

//images
import onErrorImg from './../../assets/icons/Product_Details/onError_img.jpeg'

//translate
import { useTranslation } from "react-i18next";

//react
import React, { useState, useEffect, useContext, Fragment } from "react"
import { Link, useParams, useHistory } from "react-router-dom";
import { axiosInstance } from "../../axios/config";

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getProductDetails } from "./../../redux/actions/productDetailsActions";
import { getOrder } from './../../redux/actions/orderActions'

//components
import YoutubeEmbed from '../../components/YoutubeEmbed';
import ReactStars from "react-rating-stars-component";
import { Form, Modal, Button } from 'react-bootstrap';
import Item from '../../components/Item';
import Loader from "../../components/Loader";
import { CountryContext } from '../../App';
import FavoriteIcon from '../../components/FavoriteIcon';


const ProductDetails = () => {
    //translate
    const { t } = useTranslation();

    // for route
    const history = useHistory()

    // current country
    const { country, } = useContext(CountryContext)


    // product Size
    const [sizeId, setSizeId] = useState()
    const [selcectSizeId, setSelcectSizeId] = useState() // for cart

    const chosenSize = (property) => {
        setSizeId(property.id);
        setSelcectSizeId(property.sub_prop_id)
    }

    //product Color
    const [colorId, setColorId] = useState()
    const [selcectColorId, setSelcectColorId] = useState() // for cart

    const chosenColor = (property) => {
        setColorId(property.id);
        setSelcectColorId(property.sub_prop_id)
    }

    //product counter
    const [counter, setCounter] = useState(1)

    // Counter state is incremented
    const incrementCount = () => {
        setCounter(counter + 1)
    }

    // Counter state is decremented
    const decrementCount = () => {
        counter > 1 ? setCounter(counter - 1) : setCounter(1)
    }

    // add to cart function
    const addItemToCart = async (id) => {

        await axiosInstance({
            method: "post",
            url: `/makeOrder`,
            data: {
                "item_id": id,
                "count": counter,
                "props": [selcectSizeId, selcectColorId]
            }
        })
            .then((res) => res.status && dispatch(getOrder()))

            .catch((err) => console.error(err));

    }

    // show video modal
    const [modalShow, setModalShow] = useState(false);


    const previewLarge = (smallImgSrc) => {
        let fullImg = document.getElementById("largeImg");
        fullImg.src = smallImgSrc
    }

    // product details section
    const [describe, setDescribe] = useState("details")


    // fetch from api
    const dispatch = useDispatch()

    const { id: productId } = useParams();

    const { loading, productDetails: item, error } = useSelector(state => state.productDetails)

    useEffect(() => {

        dispatch(getProductDetails(productId))

    }, [dispatch, error, productId])

    const brandName = item && item.vendor_info ? item.vendor_info.vendor_name : "";

    const brandId = item && item.vendor_info ? item.vendor_info.id : "";

    //review item
    const addReviewTOProduct = async () => {

        localStorage.getItem("api-token") ? 

        await axiosInstance({
            method: "post",
            url: `/userItemReview`,
            data: {
                item_id: productId,
                rate: productRate,
                comment: commentReview

            }
        })
            .then(res => res.data)
            .then(data => console.log(data))

            .catch((err) => console.error(err))

            : history.push("/login")
    }

    const [productRate, setProductRate] = useState(0)

    const [commentReview, setCommentReview] = useState("")

    // rating stars value
    const ratingChanged = (newRating) => {
        setProductRate(newRating);
    };


    return (
        <Fragment>
            {loading ? <Loader /> :
                <div className="Product-details d-flex flex-column mt-4 container">

                    {/* /////////////////////////////////////////////////////////////////////// */}
                    <div className="d-flex align-items-center page-names">

                        <Link to="/" className="text-decoration-none">
                            <HomeOutlinedIcon style={{ color: grey[500] }} className="me-2" />
                            <span className="page-name">{t("Home")}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} className="ms-2" />
                        {/* /////////////////////////////// */}

                        <Link to={`/brands-categories/${brandName}/${brandId}`}

                            className="text-decoration-none ">

                            <span className="page-name">{brandName}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} className="ms-2" />
                        {/* /////////////////////////////// */}

                        <Link to={`/sub-categories/${item.categoryName}/${brandName}/${item.categor_id}/${brandId}`}

                            className="text-decoration-none ">

                            <span className="page-name">{item.categoryName}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} className="ms-2" />
                        {/* /////////////////////////////// */}

                        <Link to={`/category-items/${item.s_categoryName}/${item.sub_cat_id}/${item.categoryName}/${item.categor_id}/${brandName}/${brandId}`}

                            className="text-decoration-none ">

                            <span className="page-name">{item.s_categoryName}</span>
                        </Link>

                        {/* /////////////////////////////// */}

                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="row my-4">

                        <div className="product col-lg-6 col-12">

                            <div className='row'>

                                <div className="d-flex flex-column small-preview col-3 ">
                                    {item.other_item_images && item.other_item_images.map(img =>

                                        <div className="product-small-img" key={img.id}>

                                            <img src={img.itemImageName} alt="previewImg"

                                                onClick={() => previewLarge(img.itemImageName)}
                                            />
                                        </div>
                                    )}

                                    {/*product video */}
                                    <button onClick={() => setModalShow(true)}
                                        style={{
                                            backgroundImage: `url("${item.itemImage}")`,
                                        }}>

                                        <PlayCircleFilledRoundedIcon />
                                    </button>

                                    <VideoModal
                                        show={modalShow}
                                        onHide={() => setModalShow(false)}
                                        item={item}
                                    />

                                </div>

                                {/*large image preview */}
                                <div className="product-large-img col-9 ">
                                    <img src={item.itemImage} alt="previewImg" id="largeImg" />
                                </div>
                            </div>
                        </div>
                        {/* ///////////////////////////////// */}

                        <div className="details d-flex flex-column col-12 col-lg-6 ">

                            <span className="brand-name mt-3 mb-2">{item.vendor_info && item.vendor_info.vendor_name}</span>

                            <div className="rating">
                                <ReactStars
                                    count={5}
                                    value={item.rate}
                                    edit={false}
                                    size={24}
                                    activeColor="#ffd700"
                                />
                                {/* <span>(180)</span> */}
                            </div>

                            <span className="product-name my-2">{item.itemName}</span>

                            <div className="price">

                                <span>{item.itemPriceAfterDis}
                                    &nbsp;{country === "sa" ? t("SAR") : t("KWD")}</span>

                                <span>{item.itemPrice}
                                    &nbsp;{country === "sa" ? t("SAR") : t("KWD")}</span>
                            </div>

                            {item.size && item.size.length > 0 &&

                                <div className="d-flex flex-column product-size">
                                    <span >{t("Size")}</span>
                                    <div className="d-flex diff-size">


                                        {item.size.map(it => (
                                            <button key={it.id} onClick={() => chosenSize(it)}

                                                className={`btn-size ${sizeId === it.id ? "btn-size-active" : ""} `}>

                                                {it.propertyName}</button>
                                        ))}

                                    </div>
                                </div>

                            }

                            {item.color && item.color.length > 0 &&

                                <div className="d-flex flex-column product-color ">
                                    <span>{t("Color")}</span>
                                    <div className="d-flex diff-color">

                                        {item.color.map(it => (
                                            <div className='d-flex flex-column '

                                                key={it.id}>

                                                <button
                                                    className="btn-color d-flex justify-content-center align-items-center"
                                                    onClick={() => chosenColor(it)}
                                                    style={{ backgroundColor: `${it.propertyName}` }}>

                                                    {colorId === it.id ?
                                                        < CheckRoundedIcon style={{ fill: "#fff" }} />
                                                        : null}

                                                </button>

                                            </div>
                                        ))}

                                    </div>
                                </div>
                            }
                            <div className="d-flex product-count">

                                <div className="d-flex justify-content-between align-items-center px-1 count-num">
                                    <button className="btn-minus" onClick={decrementCount}>-</button>
                                    <span>{counter}</span>
                                    <button className="btn-add" onClick={incrementCount}>+</button>
                                </div>

                                <button className="btn-cart"
                                    onClick={() => addItemToCart(item.id)}
                                >{t("Add to Cart")}</button>

                                <div className="btn-fav d-flex justify-content-center align-items-center" >
                                    <FavoriteIcon item={item} />
                                </div>

                            </div>

                        </div>

                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="d-flex flex-column product-describe mt-4">

                        <div className="row align-items-center mx-1">
                            <span className={`describe ${describe === "details" ? "describe-active" : null} d-flex justify-content-center align-items-center col-lg-4 col-12 `}

                                onClick={() => setDescribe("details")}>

                                {t("Product Details")}
                            </span>

                            <span className={`describe ${describe === "shipping" ? "describe-active" : null} d-flex justify-content-center align-items-center col-lg-4 col-12 `}
                                onClick={() => setDescribe("shipping")}>

                                {t("Shipping and return terms")}
                            </span>

                            <span className={`describe ${describe === "size" ? "describe-active" : null} d-flex justify-content-center align-items-center col-lg-4 col-12 `}
                                onClick={() => setDescribe("size")}>

                                {t("Size guide")}
                            </span>

                        </div>

                        <ul className="pe-4">

                            {(() => {

                                switch (describe) {
                                    case "details":
                                        return (
                                            <li>{item.itemDescribe}</li>

                                        );
                                    case "shipping":
                                        return (
                                            <li>shipping</li>

                                        );
                                    case "size":
                                        return (
                                            <li>size</li>

                                        );
                                    default:
                                        return (
                                            <></>
                                        );
                                }

                            })()}

                        </ul>

                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="d-flex flex-column product-match my-4">

                        <span className="header">{t("This product is fit with")}</span>

                        <div className="d-flex flex-column justify-content-center align-items-center items-section">

                            <div className="items row mx-0 justify-content-center p-4">

                                {item.itemFit && item.itemFit.filter((item, index) => index <= 7).map(it =>

                                    <div className='col-lg-3 col-6 mb-4' key={it.id}>

                                        <Item item={it} />
                                    </div>
                                )}

                            </div>
                            <div className="d-flex justify-content-center my-4">
                                <button className="btn-more "
                                    onClick={(e) => {
                                        e.preventDefault();
                                        return history.push("/see-more/itemFit");
                                    }}  >
                                    {t("Browse more")}</button>
                            </div>
                        </div>

                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="d-flex flex-column product-review my-4">

                        <span className="header mb-4">{t("Reviews")}</span>

                        <div className="d-flex flex-column review-section">

                            <div className="reviews d-flex flex-column ">

                                {item.reviews && item.reviews.map(re =>
                                    <div className="review row" key={re.id}>

                                        <div className="review-profile col-4 col-lg-1">

                                            <img src={re.user_info.image} alt="profile img"
                                                onError={(e) => { e.target.onerror = null; e.target.src = onErrorImg }}
                                            />
                                        </div>

                                        <div className="d-flex flex-column col-8 col-lg-11 pt-1">
                                            <span className="review-content">{re.comment}</span>
                                            <span className="review-rating">
                                                <ReactStars
                                                    count={5}
                                                    value={re.rate}
                                                    edit={false}
                                                    size={24}
                                                    activeColor="#ffd700"
                                                /></span>
                                            <span className="review-name">{re.user_info.name}</span>
                                        </div>
                                    </div>
                                )}

                            </div>

                            <button className="btn-more-reviews d-flex align-items-center me-auto">
                                <span>{t("More Reviews")}</span>
                                <ExpandMoreOutlinedIcon />
                            </button>
                        </div>
                        {/* //////////////////////////////////// */}

                        <div className="d-flex flex-column add-review">
                            <span className="header mb-3">{t("Add Comment")}</span>

                            <Form onSubmit={addReviewTOProduct}>

                                {/* <Form.Control placeholder={t("Name")} /> */}

                                <ReactStars
                                        count={5}
                                        onChange={ratingChanged}
                                        size={24}
                                        activeColor="#ffd700"
                                        required
                                    />

                                <Form.Control as="textarea" rows={4} placeholder={t("Write your Comment Here")}
                                    value={commentReview} className="my-4"
                                    onChange={(e) => setCommentReview(e.target.value)}
                                />

                                <div className="d-flex align-items-center rate-send-review">
                               
                                    <button className="btn-send" type="submit">{t("Send")}</button>
                                </div>
                            </Form>
                        </div>
                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className="d-flex flex-column maybe-like-products ">
                        <span className="header">{t("You may also like")}</span>

                        <div className="row mx-0 items w-100">

                            {item.itemMayLike && item.itemMayLike.filter((item, index) => index <= 7).map(it =>
                                <div className='col-lg-3 col-6 mb-2' key={it.id}>

                                    <Item item={it} />
                                </div>
                            )}

                        </div>
                        <div className="d-flex justify-content-center my-4">
                            <button className="btn-more "
                                onClick={(e) => {
                                    e.preventDefault();
                                    return history.push("/see-more/itemMayLike");
                                }}  >
                                {t("Browse more")}</button>
                        </div>
                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}
                </div>
            }
        </Fragment>
    )
}

export default ProductDetails;

//declare video modal
const VideoModal = (props) => {

    //translate
    const { t } = useTranslation();

    return (
        <Modal
            show={props.show}
            onHide={props.onHide}
            centered
            animation
            size="lg"
            className="video-modal"
        >
            <Modal.Header  >
                <Modal.Title id="contained-modal-title-vcenter" className="px-2">
                    {t("Product Video")}
                </Modal.Title>
                <button ><CloseRoundedIcon onClick={props.onHide} /></button>


            </Modal.Header>
            <Modal.Body>

                <YoutubeEmbed embedLink={props.item.videoLink ? props.item.videoLink : ""} />

            </Modal.Body>
            <Modal.Footer>
                <Button onClick={props.onHide}>{t("Close")}</Button>
            </Modal.Footer>
        </Modal>
    );
}