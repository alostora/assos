//react
import React, { useEffect, Fragment } from 'react'
import { Link, useParams } from 'react-router-dom'

//redux
import { useDispatch, useSelector } from 'react-redux'
import { getSubCategories } from '../../redux/actions/subCategoriesActions'

//translate
import { useTranslation } from "react-i18next";

//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//component 
import Loader from '../../components/Loader';


const CategoriesItems = () => {

    //translate
    const { t } = useTranslation();

    // fetch from api
    const dispatch = useDispatch()

    const { category_name: categoryName, brand_name: brandName, category_id: categoryId, brand_id: brandId } = useParams();

    const { loading, subCategories, error } = useSelector(state => state.subCategories)


    useEffect(() => {

        dispatch(getSubCategories(categoryId, brandId))

    }, [dispatch, error, categoryId, brandId])


    return (
        <Fragment>
            {loading ? <Loader /> :

                <div className="sub-categories d-flex flex-column my-4 container">

                    <div className="d-flex align-items-center page-names  mb-3">

                        <Link to="/" className="text-decoration-none d-flex align-items-center ">
                            <HomeOutlinedIcon style={{ color: grey[500] }} />
                            <span className="page-name mx-1">{t("Home")}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                        <Link to={`/brands-categories/${brandName}/${brandId}`} className="text-decoration-none ">
                            <span className="page-name ">{brandName}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                        <span className="page-name ">{categoryName}</span>

                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                    <div className='d-flex flex-column items-category'>

                        <div className="row mx-0 justify-content-center align-items-center ">

                            {subCategories && subCategories.map(subCategory => (

                                <div className='d-flex flex-column col-lg-3 col-6 my-2 item-category' key={subCategory.id}>

                                    <Link
                                        to={`/category-items/${subCategory.s_categoryName}/${subCategory.id}/${categoryName}/${categoryId}/${brandName}/${brandId}`}
                                        className="text-decoration-none d-flex flex-column">

                                        <img src={subCategory.s_categoryImage} alt="categoryImage" />
                                        <span className='category-name my-2'>{subCategory.s_categoryName}</span>

                                    </Link>
                                </div>

                            ))}
                        </div>
                    </div>
                    {/* /////////////////////////////////////////////////////////////////////// */}

                </div>

            }
        </Fragment >
    )
}


export default CategoriesItems;