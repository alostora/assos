//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//react
import React, { useEffect, Fragment } from 'react'
import { Link, useParams } from 'react-router-dom'

//redux
import { useDispatch, useSelector } from 'react-redux'
import { getBrandCategories } from '../../redux/actions/brandCategoriesAction'

//translate
import { useTranslation } from "react-i18next";

//component
import Loader from '../../components/Loader'
import Carousel from 'react-bootstrap/Carousel'


const BrandCategories = () => {

    //translate
    const { t } = useTranslation();

    // fetch from api
    const dispatch = useDispatch()

    const { id: brandId, name: brandName } = useParams();

    const { loading, brandCategories, error } = useSelector(state => state.brandCategories)

    const { categories, sliders } = brandCategories ? brandCategories : [];


    useEffect(() => {

        dispatch(getBrandCategories(brandId))

    }, [dispatch, error, brandId])


    return (

        <Fragment>
            {loading ? <Loader /> :

                <div className="brand-categories d-flex flex-column my-4 ">

                    <div className="d-flex align-items-center page-names container mb-3">

                        <Link to="/" className="text-decoration-none d-flex align-items-center ">
                            <HomeOutlinedIcon style={{ color: grey[500] }} />
                            <span className="page-name mx-1">{t("Home")}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                        <Link to="/brands" className="text-decoration-none ">
                            <span className="page-name ">{t("Brands")}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                        <span className="page-name ">{brandName}</span>

                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    {sliders && sliders.length > 0 ?

                        <Fragment>
                            <Carousel
                                nextIcon={<span aria-hidden="false" />}
                                prevIcon={<span aria-hidden="false" />}
                                className="brand-categories-carousel">

                                {sliders && sliders.map(slider => (
                                    <Carousel.Item interval={1000} key={slider.id}>

                                        <img src={slider.image} alt="CarouselImg" />

                                    </Carousel.Item>
                                ))}
                            </Carousel>
                            {/* /////////////////////////////////////////////////////////////////////// */}

                            <div className='d-flex flex-column container items-category'>
                                <span className="header d-flex mb-5">{t("Categories")}</span>

                                <div className="row mx-0 justify-content-center align-items-center ">

                                    {categories && categories.map(category => (

                                        <div className='d-flex flex-column col-lg-4 col-6 my-2 item-category' key={category.id}>
                                            <Link to={`/sub-categories/${category.categoryName}/${brandName}/${category.id}/${brandId}`}
                                                className="text-decoration-none d-flex flex-column"
                                            >
                                                <img src={category.categoryImage} alt="categoryImage" />
                                                <span className='category-name my-2'>{category.categoryName}</span>
                                            </Link>
                                        </div>

                                    ))}
                                </div>
                            </div>
                            {/* /////////////////////////////////////////////////////////////////////// */}
                        </Fragment>
                        :
                        <div className='d-flex justify-content-center my-5'>
                            <h1>{t("There are no products in this brand")}</h1>
                        </div>
                    }
                </div>

            }
        </Fragment >
    )
}

export default BrandCategories